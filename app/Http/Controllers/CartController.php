<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Offer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $items = $cart->items()->with(['product','offer'])->get();
        $total = $items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        return view('cart.index', compact('cart','items','total'));
    }

    public function addProduct(Product $product, Request $request)
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $quantity = max(1, (int) $request->input('quantity', 1));
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'price' => $product->price,
        ]);
        return back()->with('status', 'Produk ditambahkan ke keranjang');
    }

    public function addOffer(Offer $offer, Request $request)
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $quantity = max(1, (int) $request->input('quantity', 1));
        CartItem::create([
            'cart_id' => $cart->id,
            'offer_id' => $offer->id,
            'quantity' => $quantity,
            'price' => $offer->price,
        ]);
        return back()->with('status', 'Penawaran dimasukkan ke keranjang');
    }

    public function removeItem(CartItem $item)
    {
        $item->delete();
        return back()->with('status', 'Item dihapus dari keranjang');
    }
}
