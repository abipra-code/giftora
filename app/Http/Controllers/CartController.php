<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cart = session()->get('cart', []);
        
        $subtotal = 0;
        $totalItems = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            $totalItems += $item['quantity'];
        }

        return view('public.cart', compact('cart', 'subtotal', 'totalItems'));
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        $requestedQty = max(1, (int) $request->input('quantity', 1));

        if ($product->stock <= 0) {
            return back()->with('error', 'Maaf, stok produk ' . $product->name . ' sedang habis.');
        }

        $cart = session()->get('cart', []);
        $currentQty = isset($cart[$product->id]) ? (int) $cart[$product->id]['quantity'] : 0;

        if ($currentQty >= $product->stock) {
            return back()->with('warning', 'Jumlah di keranjang sudah mencapai stok maksimal (' . $product->stock . ' pcs).');
        }

        $newQty = $currentQty + $requestedQty;
        $message = 'Produk ' . $product->name . ' berhasil dimasukkan ke keranjang!';
        $messageType = 'success';

        if ($newQty > $product->stock) {
            $newQty = $product->stock;
            $message = 'Jumlah disesuaikan dengan stok tersedia (maksimal ' . $product->stock . ' pcs).';
            $messageType = 'warning';
        }

        $cart[$product->id] = [
            'id'            => $product->id,
            'name'          => $product->name,
            'slug'          => $product->slug,
            'price'         => $product->price,
            'stock'         => $product->stock,
            'image_path'    => $product->image_path,
            'category_name' => $product->category->name ?? 'Hampers',
            'quantity'      => $newQty,
        ];

        session()->put('cart', $cart);

        return back()->with($messageType, $message);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $quantity = (int) $request->input('quantity', 1);
        $cart = session()->get('cart', []);

        if (!isset($cart[$product->id])) {
            return back();
        }

        if ($quantity <= 0) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
            return back()->with('success', 'Produk dihapus dari keranjang.');
        }

        if ($quantity > $product->stock) {
            $cart[$product->id]['quantity'] = $product->stock;
            session()->put('cart', $cart);
            return back()->with('warning', 'Jumlah produk ' . $product->name . ' disesuaikan dengan batas stok maksimal (' . $product->stock . ' pcs).');
        }

        $cart[$product->id]['quantity'] = $quantity;
        session()->put('cart', $cart);

        return back()->with('success', 'Kuantitas keranjang berhasil diperbarui.');
    }

    public function remove(Product $product): RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Produk ' . $product->name . ' berhasil dihapus dari keranjang.');
    }

    public function clear(): RedirectResponse
    {
        session()->forget('cart');
        return back()->with('success', 'Keranjang belanja telah dikosongkan.');
    }
}
