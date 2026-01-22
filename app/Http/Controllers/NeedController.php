<?php

namespace App\Http\Controllers;

use App\Models\Need;
use App\Models\Product;
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
            ->take(15)
            ->get();

        $products = Product::with('user')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->latest()
            ->take(20)
            ->get();

        $categoryList = [
            ['name' => 'Handphone', 'icon' => 'bx-mobile-alt'],
            ['name' => 'Laptop', 'icon' => 'bx-laptop'],
            ['name' => 'Elektronik', 'icon' => 'bx-devices'],
            ['name' => 'Aksesoris', 'icon' => 'bx bx-diamond'],
            ['name' => 'Baju', 'icon' => 'bx-closet'],
            ['name' => 'Sepatu', 'icon' => 'bx-walk'],
            ['name' => 'Makanan', 'icon' => 'bx-bowl-hot'],
            ['name' => 'Minuman', 'icon' => 'bx-drink'],
            ['name' => 'Jasa', 'icon' => 'bx-briefcase-alt-2'],
            ['name' => 'Otomotif', 'icon' => 'bx-car'],
            ['name' => 'Alat Musik', 'icon' => 'bx-music'],
            ['name' => 'Jam Tangan', 'icon' => 'bx-time-five'],
            ['name' => 'Lainnya', 'icon' => 'bx-grid-alt'],
        ];

        return view('home', compact('needs', 'products', 'categoryList'));
    }

    public function latest()
    {
        $needs = Need::with('user')
            ->where('status', 'open')
            ->latest()
            ->paginate(12);
        return view('needs.latest', compact('needs'));
    }

    public function mine()
    {
        $needs = Need::with('user')->where('user_id', Auth::id())->latest()->paginate(12);
        return view('needs.mine', compact('needs'));
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
        $need = Need::where('user_id', Auth::id())->findOrFail($id);
        return view('needs.edit', compact('need'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $need = Need::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'title' => ['required','string','max:255'],
            'description' => ['required','string'],
            'budget_min' => ['nullable','numeric','min:0'],
            'budget_max' => ['nullable','numeric','min:0'],
            'reference_image' => ['nullable','image','max:2048'],
            'status' => ['required','in:open,closed'],
        ]);

        $path = $need->reference_image_path;
        if ($request->hasFile('reference_image')) {
            if ($path) {
                Storage::disk('public')->delete($path);
            }
            $path = $request->file('reference_image')->store('references', 'public');
        }

        $need->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'budget_min' => $validated['budget_min'] ?? null,
            'budget_max' => $validated['budget_max'] ?? null,
            'reference_image_path' => $path,
            'status' => $validated['status'],
        ]);

        return redirect()->route('needs.show', $need)->with('status', 'Kebutuhan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $need = Need::where('user_id', Auth::id())->findOrFail($id);
        if ($need->reference_image_path) {
            Storage::disk('public')->delete($need->reference_image_path);
        }
        $need->delete();
        return redirect()->route('needs.mine')->with('status', 'Kebutuhan berhasil dihapus');
    }
}
