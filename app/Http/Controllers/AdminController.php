<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\TimeSlot;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Admin Dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'confirmed_bookings' => Booking::where('status', 'confirmed')->count(),
            'completed_bookings' => Booking::where('status', 'completed')->count(),
            'total_revenue' => Payment::where('status', 'success')->sum('amount'),
            'today_bookings' => Booking::whereDate('created_at', today())->count(),
        ];

        $recentBookings = Booking::with(['user', 'service', 'slot', 'payment'])
            ->latest()
            ->paginate(10);

        return view('admin.dashboard', compact('stats', 'recentBookings'));
    }

    /**
     * Manage Services
     */
    public function services()
    {
        $services = Service::latest()->paginate(15);
        return view('admin.services.index', compact('services'));
    }

    public function createService()
    {
        return view('admin.services.create');
    }

    public function storeService(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:15',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function editService(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function updateService(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:15',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($data);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil diupdate.');
    }

    public function deleteService(Service $service)
    {
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil dihapus.');
    }

    /**
     * Manage Time Slots
     */
    public function slots()
    {
        $slots = TimeSlot::with('service')
            ->orderBy('date', 'desc')
            ->orderBy('start_time')
            ->paginate(20);

        $services = Service::where('is_active', true)->get();

        return view('admin.slots.index', compact('slots', 'services'));
    }

    public function createSlot()
    {
        $services = Service::where('is_active', true)->get();
        return view('admin.slots.create', compact('services'));
    }

    public function storeSlot(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'capacity' => 'required|integer|min:1',
        ]);

        TimeSlot::create($request->all());

        return redirect()->route('admin.slots.index')->with('success', 'Slot waktu berhasil ditambahkan.');
    }

    public function deleteSlot(TimeSlot $slot)
    {
        if ($slot->bookings()->exists()) {
            return redirect()->back()->with('error', 'Slot ini memiliki booking aktif dan tidak dapat dihapus.');
        }

        $slot->delete();

        return redirect()->route('admin.slots.index')->with('success', 'Slot berhasil dihapus.');
    }

    /**
     * Manage Bookings
     */
    public function bookings(Request $request)
    {
        $query = Booking::with(['user', 'service', 'slot', 'payment']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->latest()->paginate(20);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function confirmBooking(Booking $booking)
    {
        $booking->update(['status' => 'confirmed']);

        if ($booking->payment) {
            $booking->payment->update([
                'status' => 'success',
                'paid_at' => now(),
            ]);
            $booking->update(['payment_status' => 'paid']);
        }

        return redirect()->back()->with('success', 'Booking berhasil dikonfirmasi.');
    }

    public function rejectBooking(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);
        $booking->slot->decrement('booked');

        if ($booking->payment) {
            $booking->payment->update(['status' => 'failed']);
        }

        return redirect()->back()->with('success', 'Booking berhasil ditolak.');
    }

    /**
     * Statistics
     */
    public function statistics()
    {
        $monthlyRevenue = Payment::where('status', 'success')
            ->whereMonth('created_at', now()->month)
            ->sum('amount');

        $popularServices = Service::withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->take(5)
            ->get();

        $bookingsByStatus = Booking::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        return view('admin.statistics', compact('monthlyRevenue', 'popularServices', 'bookingsByStatus'));
    }
}

