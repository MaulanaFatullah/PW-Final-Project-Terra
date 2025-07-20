<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderUserController extends Controller
{
    public function index()
    {
        // dd(Auth::user());
        $orders = Auth::user()->orders()->with('orderItems.menu')->latest()->get();
        return view('user.orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($request) {
            $totalAmount = 0;
            $orderItemsData = [];

            foreach ($request->items as $item) {
                $menu = Menu::find($item['menu_id']);
                if ($menu && $menu->is_available) {
                    $itemPrice = $menu->price * $item['quantity'];
                    $totalAmount += $itemPrice;
                    $orderItemsData[] = [
                        'menu_id' => $menu->id,
                        'quantity' => $item['quantity'],
                        'price_at_order' => $menu->price,
                    ];
                } else {
                    abort(400, 'Item menu tidak valid atau tidak tersedia.');
                }
            }

            $order = Auth::user()->orders()->create([
                'order_date' => now(),
                'total_amount' => $totalAmount,
                'status' => 'Pending',
                'notes' => $request->notes,
            ]);

            foreach ($orderItemsData as $itemData) {
                $order->orderItems()->create($itemData);
            }
        });

        return redirect()->route('orders-user.index')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function show(Order $orders_user)
    {
        $orders_user->load('orderItems.menu');
        return response()->json($orders_user);
    }

    public function update(Request $request, Order $orders_user)
    {
        $request->validate([
            'status' => 'required|string|in:Cancelled',
        ]);

        if ($request->status === 'Cancelled' && $orders_user->status === 'Pending') {
            $orders_user->update(['status' => 'Cancelled']);
            return redirect()->route('orders-user.index')->with('success', 'Pesanan berhasil dibatalkan!');
        }

        return redirect()->route('orders-user.index')->with('error', 'Pesanan tidak dapat dibatalkan.');
    }
}
