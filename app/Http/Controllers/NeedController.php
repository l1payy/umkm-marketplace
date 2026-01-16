<?php

namespace App\Http\Controllers;

use App\Models\Need;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class NeedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $needs = Need::with('user')
            ->where('status', 'open')
            ->latest()
            ->paginate(12);

        return view('home', compact('needs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('needs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required','string','max:255'],
            'description' => ['required','string'],
            'budget_min' => ['nullable','numeric','min:0'],
            'budget_max' => ['nullable','numeric','min:0'],
            'reference_image' => ['nullable','image','max:2048'],
        ]);

        $path = null;
        if ($request->hasFile('reference_image')) {
            $path = $request->file('reference_image')->store('references', 'public');
        }

        $need = Need::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'budget_min' => $validated['budget_min'] ?? null,
            'budget_max' => $validated['budget_max'] ?? null,
            'reference_image_path' => $path,
            'status' => 'open',
        ]);

        return redirect()->route('needs.show', $need)->with('status', 'Kebutuhan berhasil diposting');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $need = Need::with(['user','offers.user'])->findOrFail($id);
        return view('needs.show', compact('need'));
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
