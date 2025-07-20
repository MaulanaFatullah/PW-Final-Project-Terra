<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $totalPendingOrders = Order::where('status', 'Pending')->count();
        $totalReservations = Reservation::count();
        $totalPendingReservations = Reservation::where('status', 'Pending')->count();
        $totalCustomers = User::whereHas('role', function ($q) {
            $q->where('name', 'user');
        })->count();

        $monthlyOrders = Order::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, count(*) as total_orders')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $monthlyReservations = Reservation::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, count(*) as total_reservations')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $labels = [];
        $orderData = [];
        $reservationData = [];

        $startMonth = Carbon::now()->subMonths(5)->startOfMonth();
        $endMonth = Carbon::now()->startOfMonth();

        while ($startMonth->lte($endMonth)) {
            $monthKey = $startMonth->format('Y-m');
            $labels[] = $startMonth->format('M Y');
            $orderData[] = $monthlyOrders->get($monthKey)->total_orders ?? 0;
            $reservationData[] = $monthlyReservations->get($monthKey)->total_reservations ?? 0;
            $startMonth->addMonth();
        }

        $chartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Jumlah Pesanan',
                    'data' => $orderData,
                    'borderColor' => '#0d6efd',
                    'tension' => 0.4,
                    'fill' => false,
                ],
                [
                    'label' => 'Jumlah Reservasi',
                    'data' => $reservationData,
                    'borderColor' => '#198754',
                    'tension' => 0.4,
                    'fill' => false,
                ]
            ]
        ];

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalPendingOrders',
            'totalReservations',
            'totalPendingReservations',
            'totalCustomers',
            'chartData'
        ));
    }
}
