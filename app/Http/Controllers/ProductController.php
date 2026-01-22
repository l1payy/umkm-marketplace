<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['user', 'detail'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->latest()
            ->paginate(12);
        return view('products.index', compact('products'));
    }

    public function search(Request $request)
    {
        $term = trim((string) $request->input('q', ''));
        if ($term === '') {
            return redirect()->route('products.index');
        }
        $products = Product::with(['user', 'detail'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where(function ($q) use ($term) {
                $q->where('name', 'like', '%'.$term.'%')
                  ->orWhere('description', 'like', '%'.$term.'%')
                  ->orWhere('category', 'like', '%'.$term.'%');
            })
            ->latest()
            ->paginate(12)
            ->appends(['q' => $term]);
        return view('products.index', compact('products'));
    }

    public function mine()
    {
        $products = Product::with('user')->where('user_id', Auth::id())->latest()->paginate(12);
        return view('products.mine', compact('products'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if (!$this->isProfileComplete($user)) {
            return redirect()->route('profile.edit')->with('status', 'Lengkapi Profile Information terlebih dahulu untuk mengupload produk');
        }
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$this->isProfileComplete($user)) {
            return redirect()->route('profile.edit')->with('status', 'Lengkapi Profile Information terlebih dahulu untuk mengupload produk');
        }
        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'category' => ['nullable','string','max:50', Rule::in([
                'Handphone','Laptop','Elektronik','Aksesoris','Baju','Celana','Sepatu','Makanan','Minuman','Jasa','Otomotif','Alat Musik','Jam Tangan'
            ])],
            'description' => ['nullable','string'],
            'price' => ['required','numeric','min:0'],
            'images' => ['nullable','array'],
            'images.*' => ['image','max:4096'],
            'sku' => ['nullable','string','max:255'],
            'material' => ['nullable','string','max:255'],
            'care_label' => ['nullable','string','max:255'],
            'long_description' => ['nullable','string'],
            'specs_keys' => ['nullable','array'],
            'specs_values' => ['nullable','array'],
        ]);

        $path = null;

        $product = Product::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'category' => $validated['category'] ?? null,
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'image_path' => $path,
        ]);

        if ($request->hasFile('images')) {
            $position = 0;
            foreach ($request->file('images') as $file) {
                $stored = $file->store('products', 'public');
                if (!$product->image_path) {
                    $product->image_path = $stored;
                    $product->save();
                }
                \App\Models\ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $stored,
                    'position' => $position++,
                ]);
            }
        }

        $specs = [];
        $keys = $validated['specs_keys'] ?? [];
        $values = $validated['specs_values'] ?? [];
        foreach ($keys as $idx => $k) {
            $k = trim((string)$k);
            $v = isset($values[$idx]) ? trim((string)$values[$idx]) : '';
            if ($k !== '' && $v !== '') {
                $specs[$k] = $v;
            }
        }
        \App\Models\ProductDetail::updateOrCreate(
            ['product_id' => $product->id],
            [
                'sku' => $validated['sku'] ?? null,
                'material' => $validated['material'] ?? null,
                'care_label' => $validated['care_label'] ?? null,
                'specs' => $specs ?: null,
                'long_description' => $validated['long_description'] ?? null,
            ]
        );

        return redirect()->route('products.show', $product)->with('status', 'Produk berhasil dibuat');
    }
    
    private function isProfileComplete($user): bool
    {
        if (!$user) return false;
        $required = [
            trim((string) $user->name) !== '',
            trim((string) $user->email) !== '',
            trim((string) $user->address) !== '',
            trim((string) $user->location) !== '',
            trim((string) $user->phone) !== '',
        ];
        $hasPayout = ($user->payouts()->count() ?? 0) > 0;
        return array_reduce($required, fn($carry, $v) => $carry && $v, true) && $hasPayout;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with(['user','detail','reviews.user'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->findOrFail($id);
        $sellerProductsCount = $product->user ? $product->user->products()->count() : 0;
        $sellerProductIds = $product->user ? $product->user->products()->pluck('id') : collect();
        $sellerAvgRating = $sellerProductIds->isNotEmpty()
            ? \App\Models\Review::whereIn('product_id', $sellerProductIds)->avg('rating')
            : null;
        return view('products.show', [
            'product' => $product,
            'sellerProductsCount' => $sellerProductsCount,
            'sellerAvgRating' => $sellerAvgRating,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::with('detail')->where('user_id', Auth::id())->findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'category' => ['nullable','string','max:50', Rule::in([
                'Handphone','Laptop','Elektronik','Aksesoris','Baju','Celana','Sepatu','Makanan','Minuman','Jasa','Otomotif','Alat Musik','Jam Tangan'
            ])],
            'description' => ['nullable','string'],
            'price' => ['required','numeric','min:0'],
            'image' => ['nullable','image','max:2048'],
            'sku' => ['nullable','string','max:255'],
            'material' => ['nullable','string','max:255'],
            'care_label' => ['nullable','string','max:255'],
            'long_description' => ['nullable','string'],
            'specs_keys' => ['nullable','array'],
            'specs_values' => ['nullable','array'],
        ]);

        $path = $product->image_path;
        if ($request->hasFile('image')) {
            if ($path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($path);
            }
            $path = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $validated['name'],
            'category' => $validated['category'] ?? $product->category,
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'image_path' => $path,
        ]);

        $specs = [];
        $keys = $validated['specs_keys'] ?? [];
        $values = $validated['specs_values'] ?? [];
        foreach ($keys as $idx => $k) {
            $k = trim((string)$k);
            $v = isset($values[$idx]) ? trim((string)$values[$idx]) : '';
            if ($k !== '' && $v !== '') {
                $specs[$k] = $v;
            }
        }

        \App\Models\ProductDetail::updateOrCreate(
            ['product_id' => $product->id],
            [
                'sku' => $validated['sku'] ?? null,
                'material' => $validated['material'] ?? null,
                'care_label' => $validated['care_label'] ?? null,
                'specs' => $specs ?: null,
                'long_description' => $validated['long_description'] ?? null,
            ]
        );

        return redirect()->route('products.show', $product)->with('status', 'Produk berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::where('user_id', Auth::id())->findOrFail($id);
        if ($product->image_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image_path);
        }
        $product->delete();
        return redirect()->route('products.mine')->with('status', 'Produk berhasil dihapus');
    }
}
