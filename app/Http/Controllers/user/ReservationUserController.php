<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationUserController extends Controller
{
    public function index()
    {
        $reservations = Auth::user()->reservations()->latest()->get();
        return view('user.reservations.index', compact('reservations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required|date_format:H:i',
            'number_of_guests' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
        ]);

        Auth::user()->reservations()->create([
            'reservation_date' => $request->reservation_date,
            'reservation_time' => $request->reservation_time,
            'number_of_guests' => $request->number_of_guests,
            'status' => 'Pending',
            'notes' => $request->notes,
        ]);

        return redirect()->route('reservations-user.index')->with('success', 'Reservasi berhasil dibuat! Menunggu konfirmasi.');
    }

    public function show(Reservation $reservations_user)
    {
        return response()->json($reservations_user);
    }

    public function update(Request $request, Reservation $reservations_user)
    {
        $request->validate([
            'status' => 'required|string|in:Cancelled',
        ]);

        if ($request->status === 'Cancelled' && $reservations_user->status === 'Pending') {
            $reservations_user->update(['status' => 'Cancelled']);
            return redirect()->route('reservations-user.index')->with('success', 'Reservasi berhasil dibatalkan.');
        }

        return redirect()->route('reservations-user.index')->with('error', 'Reservasi tidak dapat dibatalkan.');
    }
}
