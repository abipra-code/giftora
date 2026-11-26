<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::withCount('products')->orderBy('name')->get();

        $query = Product::with('category');

        if ($request->filled('kategori')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->string('kategori'));
            });
        }

        if ($request->filled('q')) {
            $keyword = $request->string('q');
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('contents_summary', 'like', "%{$keyword}%");
            });
        }

        $products = $query->latest()->get();

        return view('public.index', compact('categories', 'products'));
    }

    public function about(): View
    {
        return view('public.about');
    }

    public function show(string $slug): View
    {
        $product = Product::with('category')->where('slug', $slug)->firstOrFail();

        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(3)
            ->get();

        return view('public.show', compact('product', 'relatedProducts'));
    }
}
