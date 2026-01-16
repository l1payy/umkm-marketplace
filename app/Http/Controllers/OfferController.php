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
        ]);

        if (Auth::id() === $need->user_id) {
            return back()->with('status', 'Pemilik kebutuhan tidak dapat mengirim penawaran');
        }

        Offer::create([
            'need_id' => $need->id,
            'user_id' => Auth::id(),
            'description' => $validated['description'],
            'price' => $validated['price'],
        ]);

        return back()->with('status', 'Penawaran berhasil dikirim');
    }
}
