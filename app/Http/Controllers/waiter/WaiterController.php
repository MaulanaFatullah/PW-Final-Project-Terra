<?php

namespace App\Http\Controllers\waiter;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WaiterController extends Controller
{
    public function index()
    {
        $newOrders = Order::whereIn('status', ['Pending', 'Diproses'])->latest()->take(5)->get();
        $totalActiveOrders = Order::whereIn('status', ['Pending', 'Diproses'])->count();
        $totalOrdersCompletedToday = Order::where('status', 'Selesai')
            ->whereDate('updated_at', Carbon::today())
            ->count();

        $upcomingReservations = Reservation::whereDate('reservation_date', '>=', Carbon::today())
            ->whereIn('status', ['Pending', 'Dikonfirmasi'])
            ->orderBy('reservation_date')
            ->orderBy('reservation_time')
            ->take(5)
            ->get();
        $totalUpcomingReservations = Reservation::whereDate('reservation_date', '>=', Carbon::today())
            ->whereIn('status', ['Pending', 'Dikonfirmasi'])
            ->count();

        $orderStatusCounts = Order::select('status', \DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $pieChartLabels = array_keys($orderStatusCounts);
        $pieChartData = array_values($orderStatusCounts);
        $pieChartColors = [
            'Pending' => '#ffc107',
            'Diproses' => '#0dcaf0',
            'Selesai' => '#198754',
            'Cancelled' => '#dc3545',
            'Dibatalkan' => '#6c757d',
        ];
        $pieChartBackgroundColors = array_map(function ($status) use ($pieChartColors) {
            return $pieChartColors[$status] ?? '#6c757d';
        }, $pieChartLabels);


        return view('waiter.dashboard', compact(
            'newOrders',
            'totalActiveOrders',
            'totalOrdersCompletedToday',
            'upcomingReservations',
            'totalUpcomingReservations',
            'pieChartLabels',
            'pieChartData',
            'pieChartBackgroundColors'
        ));
    }
}
