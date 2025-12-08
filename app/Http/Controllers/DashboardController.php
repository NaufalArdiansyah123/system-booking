<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * User dashboard
     */
    public function index()
    {
        $user = auth()->user();
        
        $activeBookings = Booking::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->with(['service', 'slot'])
            ->latest()
            ->take(5)
            ->get();

        $completedCount = Booking::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $pendingCount = Booking::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        return view('dashboard.index', compact('activeBookings', 'completedCount', 'pendingCount'));
    }

    /**
     * User profile
     */
    public function profile()
    {
        return view('dashboard.profile');
    }

    /**
     * Update profile
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile berhasil diupdate.');
    }
}
