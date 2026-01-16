<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('items')->where('user_id', Auth::id())->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->filled('product_direct') || $request->filled('offer_direct')) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => 'pending',
                'total' => 0,
            ]);

            if ($request->filled('product_direct')) {
                $productId = (int) $request->input('product_direct');
                $price = optional(\App\Models\Product::find($productId))->price ?? 0;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => 1,
                    'price' => $price,
                ]);
                $order->update(['total' => $price]);
            } else {
                $offerId = (int) $request->input('offer_direct');
                $price = optional(\App\Models\Offer::find($offerId))->price ?? 0;
                OrderItem::create([
                    'order_id' => $order->id,
                    'offer_id' => $offerId,
                    'quantity' => 1,
                    'price' => $price,
                ]);
                $order->update(['total' => $price]);
            }
        } else {
            $cart = Cart::with('items')->firstOrCreate(['user_id' => Auth::id()]);
            if ($cart->items->isEmpty()) {
                return back()->with('status', 'Keranjang kosong');
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => 'pending',
                'total' => $cart->items->sum(fn($i) => $i->price * $i->quantity),
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'offer_id' => $item->offer_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);
            }

            $cart->items()->delete();
        }

        $order->update(['status' => 'completed']);

        return redirect()->route('orders.index')->with('status', 'Checkout berhasil, pesanan completed');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
