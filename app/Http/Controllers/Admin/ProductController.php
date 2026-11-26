<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::with('category')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.form', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id'      => ['required', 'integer', 'exists:categories,id'],
            'name'             => ['required', 'string', 'min:3', 'max:120'],
            'sku'              => ['required', 'string', 'max:30', 'unique:products,sku'],
            'price'            => ['required', 'integer', 'min:10000'],
            'stock'            => ['required', 'integer', 'min:0'],
            'weight_grams'     => ['required', 'integer', 'min:100'],
            'contents_summary' => ['required', 'string', 'max:255'],
            'description'      => ['required', 'string', 'max:2000'],
            'image'            => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'required' => 'Kolom :attribute wajib diisi.',
            'max'      => 'Kolom :attribute maksimal :max karakter/KB.',
            'integer'  => 'Kolom :attribute harus berupa angka bulat.',
            'image'    => 'File harus berupa gambar yang valid.',
        ]);

        $path = $request->file('image')->store('products', 'public');

        Product::create([
            'category_id'      => $validated['category_id'],
            'name'             => $validated['name'],
            'slug'             => Str::slug($validated['name']) . '-' . Str::random(4),
            'sku'              => strtoupper($validated['sku']),
            'price'            => $validated['price'],
            'stock'            => $validated['stock'],
            'weight_grams'     => $validated['weight_grams'],
            'contents_summary' => $validated['contents_summary'],
            'description'      => $validated['description'],
            'image_path'       => 'storage/' . $path,
            'is_featured'      => $request->boolean('is_featured'),
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk hampers berhasil ditambahkan.');
    }

    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.form', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'category_id'      => ['required', 'integer', 'exists:categories,id'],
            'name'             => ['required', 'string', 'min:3', 'max:120'],
            'sku'              => ['required', 'string', 'max:30', 'unique:products,sku,' . $product->id],
            'price'            => ['required', 'integer', 'min:10000'],
            'stock'            => ['required', 'integer', 'min:0'],
            'weight_grams'     => ['required', 'integer', 'min:100'],
            'contents_summary' => ['required', 'string', 'max:255'],
            'description'      => ['required', 'string', 'max:2000'],
            'image'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $imagePath = $product->image_path;
        if ($request->hasFile('image')) {
            if (Str::startsWith($imagePath, 'storage/')) {
                Storage::disk('public')->delete(Str::after($imagePath, 'storage/'));
            }
            $stored = $request->file('image')->store('products', 'public');
            $imagePath = 'storage/' . $stored;
        }

        $product->update([
            'category_id'      => $validated['category_id'],
            'name'             => $validated['name'],
            'sku'              => strtoupper($validated['sku']),
            'price'            => $validated['price'],
            'stock'            => $validated['stock'],
            'weight_grams'     => $validated['weight_grams'],
            'contents_summary' => $validated['contents_summary'],
            'description'      => $validated['description'],
            'image_path'       => $imagePath,
            'is_featured'      => $request->boolean('is_featured'),
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk hampers berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if (Str::startsWith($product->image_path, 'storage/')) {
            Storage::disk('public')->delete(Str::after($product->image_path, 'storage/'));
        }
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk hampers berhasil dihapus.');
    }
}
