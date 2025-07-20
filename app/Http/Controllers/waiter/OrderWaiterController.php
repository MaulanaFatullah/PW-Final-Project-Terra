<?php

namespace App\Http\Controllers\waiter;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderWaiterController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'orderItems.menu')->latest()->get();
        return view('waiter.orders.index', compact('orders'));
    }

    public function show(Order $orders_waiter)
    {
        $orders_waiter->load('user', 'orderItems.menu');
        return response()->json($orders_waiter);
    }

    public function update(Request $request, Order $orders_waiter)
    {
        $request->validate([
            'status' => 'required|string|in:Pending,Diproses,Selesai,Cancelled',
        ]);

        $orders_waiter->update(['status' => $request->status]);

        return redirect()->route('orders-waiter.index')->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
