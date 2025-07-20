<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalMyOrders = $user->orders()->count();
        $totalMyPendingOrders = $user->orders()->where('status', 'Pending')->count();
        $totalMyCompletedOrders = $user->orders()->where('status', 'Selesai')->count();
        $totalMyReservations = $user->reservations()->count();
        $totalMyPendingReservations = $user->reservations()->where('status', 'Pending')->count();
        $totalMyConfirmedReservations = $user->reservations()->where('status', 'Dikonfirmasi')->count();
        $totalMySpent = $user->orders()->sum('total_amount');

        $monthlySpend = $user->orders()
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(total_amount) as total_spent')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $labels = [];
        $spentData = [];

        $startMonth = Carbon::now()->subMonths(5)->startOfMonth();
        $endMonth = Carbon::now()->startOfMonth();

        while ($startMonth->lte($endMonth)) {
            $monthKey = $startMonth->format('Y-m');
            $labels[] = $startMonth->format('M Y');
            $spentData[] = $monthlySpend->get($monthKey)->total_spent ?? 0;
            $startMonth->addMonth();
        }

        $chartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Total Pengeluaran (Rp)',
                    'data' => $spentData,
                    'borderColor' => '#0d6efd',
                    'tension' => 0.4,
                    'fill' => false,
                ]
            ]
        ];

        return view('user.dashboard', compact(
            'totalMyOrders',
            'totalMyPendingOrders',
            'totalMyCompletedOrders',
            'totalMyReservations',
            'totalMyPendingReservations',
            'totalMyConfirmedReservations',
            'totalMySpent',
            'chartData'
        ));
    }
}
