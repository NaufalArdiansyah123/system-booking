<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TimeSlot;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BookingController extends Controller
{
    /**
     * Preview booking (tanpa login)
     */
    public function preview(TimeSlot $slot)
    {
        if (!$slot->isAvailable()) {
            return redirect()->back()->with('error', 'Slot ini sudah penuh atau tidak tersedia.');
        }

        return view('booking.preview', compact('slot'));
    }

    /**
     * Confirm booking (redirect ke login jika belum)
     */
    public function confirm(Request $request, TimeSlot $slot)
    {
        if (!auth()->check()) {
            session(['intended_booking_slot' => $slot->id]);
            return redirect()->route('login')->with('info', 'Silakan login untuk melanjutkan booking.');
        }

        return view('booking.confirm', compact('slot'));
    }

    /**
     * Store booking
     */
    public function store(Request $request)
    {
        $request->validate([
            'slot_id' => 'required|exists:time_slots,id',
            'note' => 'nullable|string|max:500',
            'payment_method' => 'required|in:transfer,e-wallet,credit_card,cash',
        ]);

        $slot = TimeSlot::findOrFail($request->slot_id);

        if (!$slot->isAvailable()) {
            return redirect()->back()->with('error', 'Slot sudah tidak tersedia.');
        }

        // Create booking
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'service_id' => $slot->service_id,
            'slot_id' => $slot->id,
            'start_time' => $slot->start_time,
            'end_time' => $slot->end_time,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'note' => $request->note,
            'expires_at' => now()->addHours(2), // Booking expire dalam 2 jam
        ]);

        // Update slot
        $slot->increment('booked');

        // Create payment record
        Payment::create([
            'booking_id' => $booking->id,
            'amount' => $slot->service->price,
            'method' => $request->payment_method,
            'status' => 'pending',
        ]);

        return redirect()->route('booking.details', $booking->id)
            ->with('success', 'Booking berhasil dibuat! Silakan lakukan pembayaran.');
    }

    /**
     * Booking details
     */
    public function details(Booking $booking)
    {
        if ($booking->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $booking->load(['service', 'slot', 'payment']);

        return view('booking.details', compact('booking'));
    }

    /**
     * My bookings
     */
    public function myBookings()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->with(['service', 'slot', 'payment'])
            ->latest()
            ->paginate(10);

        return view('booking.my-bookings', compact('bookings'));
    }

    /**
     * Cancel booking
     */
    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->status !== 'pending') {
            return redirect()->back()->with('error', 'Booking ini tidak dapat dibatalkan.');
        }

        // mark booking cancelled and decrement all associated slots
        $booking->update(['status' => 'cancelled']);
        // if booking_slots exist, decrement each; otherwise fallback to primary slot
        if ($booking->bookingSlots()->exists()) {
            foreach ($booking->bookingSlots as $bs) {
                try {
                    $slot = $bs->slot;
                    if ($slot && $slot->booked > 0) {
                        $slot->decrement('booked');
                    }
                } catch (\Exception $e) {
                    Log::warning('Failed to decrement slot on cancel: ' . $e->getMessage());
                }
            }
        } else {
            try {
                if ($booking->slot && $booking->slot->booked > 0) {
                    $booking->slot->decrement('booked');
                }
            } catch (\Exception $e) {
                Log::warning('Failed to decrement fallback slot on cancel: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Booking berhasil dibatalkan.');
    }

    /**
     * Generate QR Code
     */
    public function generateQRCode(Booking $booking)
    {
        if ($booking->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $qrCode = QrCode::size(300)->generate(
            route('booking.details', $booking->id)
        );

        return response($qrCode)->header('Content-Type', 'image/svg+xml');
    }

    /**
     * Create booking with payment (API endpoint)
     */
    public function createBooking(Request $request)
    {
        try {
            $validated = $request->validate([
                'service_id' => 'required|exists:services,id',
                'date' => 'required|date',
                'start_time' => 'required',
                'end_time' => 'required',
                'payment_method' => 'required|in:qris,bank_transfer,ewallet',
                'total_amount' => 'required|numeric|min:0'
            ]);

            // Check if user is logged in, if not create guest booking
            $userId = auth()->check() ? auth()->id() : null;

            // Find or create time slot
            $slot = TimeSlot::where('service_id', $validated['service_id'])
                ->where('date', $validated['date'])
                ->where('start_time', $validated['start_time'])
                ->first();

            if (!$slot) {
                // Create new slot if not exists
                $slot = TimeSlot::create([
                    'service_id' => $validated['service_id'],
                    'date' => $validated['date'],
                    'start_time' => $validated['start_time'],
                    'end_time' => $validated['end_time'],
                    'capacity' => 1,
                    'booked' => 0,
                ]);
            }

            // Generate unique booking code
            $bookingCode = 'BKG-' . strtoupper(uniqid());

            // Create booking with correct column names (primary slot = first hour)
            $booking = Booking::create([
                'user_id' => $userId ?? 1, // Default to user 1 if guest
                'service_id' => $validated['service_id'],
                'slot_id' => $slot->id,
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'booking_code' => $bookingCode,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'note' => $request->note ?? null,
            ]);

            // If booking spans multiple hours, register each hour slot
            try {
                $startHour = intval(substr($validated['start_time'], 0, 2));
                $endHour = intval(substr($validated['end_time'], 0, 2));

                for ($h = $startHour; $h < $endHour; $h++) {
                    $sStart = str_pad($h, 2, '0', STR_PAD_LEFT) . ':00:00';
                    $sEnd = str_pad($h + 1, 2, '0', STR_PAD_LEFT) . ':00:00';

                    $slotHour = TimeSlot::firstOrCreate([
                        'service_id' => $validated['service_id'],
                        'date' => $validated['date'],
                        'start_time' => $sStart,
                        'end_time' => $sEnd,
                    ], [
                        'capacity' => 1,
                        'booked' => 0,
                        'is_available' => true,
                    ]);

                    // increment booked if not already full
                    if ($slotHour->booked < $slotHour->capacity) {
                        $slotHour->increment('booked');
                    }

                    // associate booking -> slot via pivot table
                    \App\Models\BookingSlot::firstOrCreate([
                        'booking_id' => $booking->id,
                        'slot_id' => $slotHour->id,
                    ]);
                }
            } catch (\Exception $e) {
                Log::warning('Failed to attach multi-hour slots: ' . $e->getMessage());
            }
            // Map payment method to match database enum
            $paymentMethodMap = [
                'qris' => 'e-wallet',
                'bank_transfer' => 'transfer',
                'ewallet' => 'e-wallet',
            ];
            
            $dbPaymentMethod = $paymentMethodMap[$validated['payment_method']] ?? 'transfer';

            // Create payment record
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'amount' => $validated['total_amount'],
                'method' => $dbPaymentMethod,
                'status' => 'pending',
            ]);

            $response = [
                'success' => true,
                'booking_id' => $booking->id,
                'message' => 'Booking berhasil dibuat'
            ];

            // Try to generate Midtrans snap token
            try {
                $snapToken = $this->generateMidtransToken($booking, $payment, $validated['payment_method']);
                $response['snap_token'] = $snapToken;
            } catch (\Exception $e) {
                // If Midtrans fails, continue without it
                Log::warning('Midtrans token generation failed: ' . $e->getMessage());
                $response['snap_token'] = null;
                $response['use_manual_payment'] = true;
            }

            return response()->json($response);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Confirm payment called from frontend after Midtrans onSuccess
     */
    public function confirmPayment(Request $request, Booking $booking)
    {
        $request->validate([
            'transaction_id' => 'nullable|string',
            'raw' => 'nullable',
        ]);

        try {
            // update payment record
            $payment = $booking->payment;
            if (!$payment) {
                // create fallback payment record
                $method = $request->input('method') ?? 'e-wallet';
                $payment = Payment::create([
                    'booking_id' => $booking->id,
                    'amount' => $booking->service ? $booking->service->price : 0,
                    'method' => $method,
                    'status' => 'pending',
                ]);
            }

            $transactionId = $request->input('transaction_id') ?? null;
            $raw = $request->input('raw') ? json_encode($request->input('raw')) : null;

            $payment->transaction_id = $transactionId;
            $payment->status = 'success';
            $payment->paid_at = now();
            $payment->save();

            // update booking
            $booking->status = 'confirmed';
            $booking->payment_status = 'paid';
            $booking->save();

            return response()->json(['success' => true, 'message' => 'Payment confirmed', 'booking_id' => $booking->id]);
        } catch (\Exception $e) {
            Log::error('Confirm payment failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to confirm payment'], 500);
        }
    }

    /**
     * Generate Midtrans Snap Token
     */
    private function generateMidtransToken(Booking $booking, Payment $payment, $paymentMethod)
    {
        try {
            // Set Midtrans configuration - pastikan tanpa spasi
            $serverKey = trim(config('midtrans.server_key'));
            
            \Midtrans\Config::$serverKey = $serverKey;
            \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
            \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized', true);
            \Midtrans\Config::$is3ds = config('midtrans.is_3ds', true);

            // Check if server key is valid
            if (empty($serverKey) || $serverKey === 'SB-Mid-server-YOUR_SERVER_KEY') {
                throw new \Exception('Midtrans Server Key not configured properly');
            }

            // Set enabled payments based on user selection
            $enabledPayments = [];
            switch ($paymentMethod) {
                case 'qris':
                    $enabledPayments = ['qris'];
                    break;
                case 'bank_transfer':
                    $enabledPayments = ['bca_va', 'bni_va', 'bri_va', 'permata_va', 'other_va'];
                    break;
                case 'ewallet':
                    $enabledPayments = ['gopay', 'shopeepay'];
                    break;
            }

            $params = [
                'transaction_details' => [
                    'order_id' => 'BOOKING-' . $booking->id . '-' . time(),
                    'gross_amount' => (int) $payment->amount,
                ],
                'customer_details' => [
                    'first_name' => $booking->user ? $booking->user->name : 'Guest',
                    'email' => $booking->user ? $booking->user->email : 'guest@example.com',
                    'phone' => $booking->user ? ($booking->user->phone ?? '08123456789') : '08123456789',
                ],
                'item_details' => [
                    [
                        'id' => $booking->service_id,
                        'price' => (int) $payment->amount,
                        'quantity' => 1,
                        'name' => 'Booking Lapangan - ' . $booking->service->name,
                    ]
                ],
                'enabled_payments' => $enabledPayments,
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);
            return $snapToken;
            
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            throw new \Exception('Failed to generate Midtrans token: ' . $e->getMessage());
        }
    }
}

