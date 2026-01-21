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
                $quantity = max(1, (int) $request->input('quantity', 1));
                $price = optional(\App\Models\Product::find($productId))->price ?? 0;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);
                $order->update(['total' => $price * $quantity]);
            } else {
                $offerId = (int) $request->input('offer_direct');
                $quantity = max(1, (int) $request->input('quantity', 1));
                $price = optional(\App\Models\Offer::find($offerId))->price ?? 0;
                OrderItem::create([
                    'order_id' => $order->id,
                    'offer_id' => $offerId,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);
                $order->update(['total' => $price * $quantity]);
            }
        } else {
            $cart = Cart::with('items')->firstOrCreate(['user_id' => Auth::id()]);
            $selected = collect($request->input('selected', []))->map(fn($v) => (int) $v)->filter();
            $itemsQuery = $cart->items();
            if ($selected->isNotEmpty()) {
                $itemsQuery->whereIn('id', $selected->all());
            }
            $items = $itemsQuery->get();
            if ($items->isEmpty()) {
                return back()->with('status', 'Pilih item yang ingin di-checkout');
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => 'pending',
                'total' => $items->sum(fn($i) => $i->price * $i->quantity),
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'offer_id' => $item->offer_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);
            }

            $cart->items()->whereIn('id', $items->pluck('id'))->delete();
        }

        return redirect()->route('orders.pay', $order)->with('status', 'Silakan pilih metode pembayaran');
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
