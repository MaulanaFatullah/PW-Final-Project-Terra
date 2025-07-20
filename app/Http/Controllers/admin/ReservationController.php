<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('user')->latest()->get();
        return view('admin.reservations.index', compact('reservations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required|date_format:H:i',
            'number_of_guests' => 'required|integer|min:1',
            'table_number' => 'nullable|string|max:10',
            'status' => 'required|string|in:Pending,Dikonfirmasi,Dibatalkan,Selesai',
            'notes' => 'nullable|string|max:500',
        ]);

        Reservation::create($request->all());

        return redirect()->route('reservations.index')->with('success', 'Reservasi berhasil ditambahkan!');
    }

    public function show(Reservation $reservation)
    {
        $reservation->load('user');
        return response()->json($reservation);
    }

    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'reservation_date' => 'required|date',
            'reservation_time' => 'required|date_format:H:i',
            'number_of_guests' => 'required|integer|min:1',
            'table_number' => 'nullable|string|max:10',
            'status' => 'required|string|in:Pending,Dikonfirmasi,Dibatalkan,Selesai',
            'notes' => 'nullable|string|max:500',
        ]);

        $reservation->update($request->all());

        return redirect()->route('reservations.index')->with('success', 'Reservasi berhasil diperbarui!');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('reservations.index')->with('success', 'Reservasi berhasil dihapus!');
    }
}
