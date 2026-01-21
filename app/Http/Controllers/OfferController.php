<?php

namespace App\Http\Controllers;

use App\Models\Need;
use App\Models\Offer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function store(Request $request, Need $need)
    {
        $validated = $request->validate([
            'description' => ['required','string'],
            'price' => ['required','numeric','min:0'],
            'eta_days' => ['required','integer','min:1'],
            'image' => ['nullable','image','max:4096'],
        ]);

        if (Auth::id() === $need->user_id) {
            return back()->with('status', 'Pemilik kebutuhan tidak dapat mengirim penawaran');
        }

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('offers', 'public');
        }

        Offer::create([
            'need_id' => $need->id,
            'user_id' => Auth::id(),
            'description' => $validated['description'],
            'price' => $validated['price'],
            'eta_days' => $validated['eta_days'],
            'image_path' => $path,
        ]);

        return back()->with('status', 'Penawaran berhasil dikirim');
    }
}
