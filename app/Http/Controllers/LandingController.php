<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LandingController extends Controller
{
    /**
     * Landing page
     */
    public function index()
    {
        $services = Service::where('is_active', true)
            ->latest()
            ->take(6)
            ->get();

        return view('landing.index', compact('services'));
    }

    /**
     * All services page
     */
    public function services()
    {
        $services = Service::where('is_active', true)
            ->paginate(12);

        return view('landing.services', compact('services'));
    }

    /**
     * Service detail page
     */
    public function serviceDetail(Service $service)
    {
        $upcomingSlots = $service->timeSlots()
            ->where('date', '>=', now()->toDateString())
            ->where('is_available', true)
            ->whereRaw('booked < capacity')
            ->orderBy('date')
            ->orderBy('start_time')
            ->take(10)
            ->get();

        return view('landing.service-detail', compact('service', 'upcomingSlots'));
    }

    /**
     * Search available slots (AJAX)
     */
    public function searchSlots(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'date' => 'required|date|after_or_equal:today',
        ]);

        $slots = TimeSlot::where('service_id', $request->service_id)
            ->where('date', $request->date)
            ->where('is_available', true)
            ->whereRaw('booked < capacity')
            ->with('service')
            ->orderBy('start_time')
            ->get();

        if ($slots->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada slot tersedia untuk tanggal ini.'
            ]);
        }

        return response()->json([
            'success' => true,
            'slots' => $slots
        ]);
    }

    /**
     * Return availability summary for a month (AJAX)
     * - expects: service_id, year, month
     */
    public function availability(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'year' => 'nullable|integer',
            'month' => 'nullable|integer|min:1|max:12',
        ]);

        $year = $request->input('year') ?: Carbon::now()->year;
        $month = $request->input('month') ?: Carbon::now()->month;

        $start = Carbon::create($year, $month, 1)->startOfDay();
        $end = (clone $start)->endOfMonth()->endOfDay();

        // Aggregate available capacity per date
        $rows = DB::table('time_slots')
            ->select('date', DB::raw('SUM(capacity - booked) as available'))
            ->where('service_id', $request->service_id)
            ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->groupBy('date')
            ->get();

        $availability = [];
        foreach ($rows as $r) {
            $availability[$r->date] = (int) $r->available;
        }

        return response()->json([
            'success' => true,
            'year' => (int) $year,
            'month' => (int) $month,
            'availability' => $availability,
        ]);
    }

    /**
     * Return all time slots for a given service and date, including booked counts
     */
    public function daySlots(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'date' => 'required|date',
        ]);

        $serviceId = $request->service_id;
        $date = $request->date;

        $slots = TimeSlot::where('service_id', $serviceId)
            ->where('date', $date)
            ->orderBy('start_time')
            ->get()
            ->map(function ($s) {
                return [
                    'id' => $s->id,
                    'start_time' => $s->start_time,
                    'end_time' => $s->end_time,
                    'capacity' => $s->capacity,
                    'booked' => $s->booked,
                    'is_full' => $s->booked >= $s->capacity,
                ];
            });

        return response()->json([
            'success' => true,
            'date' => $date,
            'slots' => $slots,
        ]);
    }
}

