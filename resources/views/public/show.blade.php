@extends('layouts.app')

@section('title', $product->name . ' — Giftora')

@section('content')
<section class="max-w-6xl mx-auto px-6 py-12">
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('home') }}" class="text-xs font-medium text-[#575752] hover:text-[#18181B] flex items-center gap-1.5 transition">
            <span>&larr;</span> Kembali ke Katalog
        </a>
        <a href="{{ route('cart.index') }}" class="text-xs font-medium text-[#3F5239] hover:text-[#2F3E2A] flex items-center gap-1.5 transition">
            <span>Lihat Keranjang &rarr;</span>
        </a>
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-800 flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <a href="{{ route('cart.index') }}" class="font-semibold underline ml-3">Lihat Keranjang</a>
        </div>
    @endif
    @if (session('warning'))
        <div class="mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 text-xs text-amber-800 flex items-center justify-between">
            <span>{{ session('warning') }}</span>
            <a href="{{ route('cart.index') }}" class="font-semibold underline ml-3">Lihat Keranjang</a>
        </div>
    @endif
    @if (session('error'))
        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-xs text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="mt-4 grid lg:grid-cols-2 gap-12 items-start">
        <div class="aspect-[4/3] bg-[#F2F2EE] rounded-2xl overflow-hidden border border-[#E4E4DE] shadow-sm">
            <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
        </div>

        <div>
            <p class="text-xs uppercase tracking-wider text-[#3F5239] font-semibold">
                {{ $product->category->name }} &middot; SKU {{ $product->sku }}
            </p>
            <h1 class="mt-2 text-3xl font-serif font-semibold text-[#18181B]">{{ $product->name }}</h1>
            <p class="mt-4 text-2xl font-semibold tabular-nums text-[#3F5239]">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </p>
            
            <div class="mt-2 flex items-center gap-3 text-xs">
                @if ($product->stock > 0)
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-medium">
                        Stok tersedia: {{ $product->stock }} box
                    </span>
                @else
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-red-100 text-red-800 font-medium">
                        Stok Habis
                    </span>
                @endif
                <span class="text-[#71716A]">&middot;</span>
                <span class="text-[#575752]">Berat {{ $product->weight_grams }} gram</span>
            </div>

            {{-- Form Tambah ke Keranjang --}}
            <div class="mt-6 p-5 bg-white border border-[#E4E4DE] rounded-xl shadow-sm">
                @if ($product->stock > 0)
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="flex items-center gap-4">
                            <div>
                                <label for="quantity" class="block text-xs font-semibold text-[#575752] mb-1">
                                    Jumlah (Maks. {{ $product->stock }})
                                </label>
                                <div class="flex items-center border border-[#E4E4DE] rounded-lg overflow-hidden bg-[#FAFAF8] w-32">
                                    <button type="button"
                                            onclick="let q = document.getElementById('qty-input'); if(q.value > 1) q.value--;"
                                            class="w-10 h-10 flex items-center justify-center text-sm font-semibold text-[#575752] hover:bg-gray-100 transition">
                                        &minus;
                                    </button>
                                    <input type="number"
                                           id="qty-input"
                                           name="quantity"
                                           value="1"
                                           min="1"
                                           max="{{ $product->stock }}"
                                           class="w-12 h-10 text-center text-xs font-semibold bg-white border-x border-[#E4E4DE] focus:outline-none">
                                    <button type="button"
                                            onclick="let q = document.getElementById('qty-input'); if(parseInt(q.value) < {{ $product->stock }}) q.value++;"
                                            class="w-10 h-10 flex items-center justify-center text-sm font-semibold text-[#575752] hover:bg-gray-100 transition">
                                        +
                                    </button>
                                </div>
                            </div>

                            <div class="flex-1 pt-5">
                                <button type="submit"
                                        class="w-full h-10 px-5 text-xs font-semibold text-white bg-[#3F5239] hover:bg-[#2F3E2A] rounded-lg transition shadow-sm flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    <span>Masukkan Keranjang</span>
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="text-center py-2">
                        <button disabled class="w-full py-2.5 text-xs font-semibold text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                            Stok Habis
                        </button>
                        <p class="mt-2 text-[11px] text-[#71716A]">Produk ini sedang tidak tersedia untuk dimasukkan ke keranjang.</p>
                    </div>
                @endif
            </div>

            <div class="mt-6 pt-6 border-t border-[#E4E4DE]">
                <h2 class="text-xs font-semibold uppercase tracking-wider text-[#18181B]">Isi dalam Gift Box</h2>
                <p class="mt-2 text-sm text-[#575752] leading-relaxed">{{ $product->contents_summary }}</p>
            </div>

            <div class="mt-6 pt-6 border-t border-[#E4E4DE]">
                <h2 class="text-xs font-semibold uppercase tracking-wider text-[#18181B]">Deskripsi Produk</h2>
                <p class="mt-2 text-sm text-[#575752] leading-relaxed">{{ $product->description }}</p>
            </div>
        </div>
    </div>

    {{-- Rekomendasi Terkait --}}
    @if (isset($relatedProducts) && $relatedProducts->count() > 0)
        <div class="mt-20 pt-10 border-t border-[#E4E4DE]">
            <h2 class="text-xl font-serif font-semibold text-[#18181B] mb-6">Pilihan Hampers Terkait</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ($relatedProducts as $rel)
                    <a href="{{ route('products.show', $rel->slug) }}" class="group block bg-white border border-[#E4E4DE] rounded-xl overflow-hidden hover:-translate-y-0.5 transition shadow-sm">
                        <div class="aspect-[4/3] bg-[#F2F2EE] overflow-hidden">
                            <img src="{{ asset($rel->image_path) }}" alt="{{ $rel->name }}" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4">
                            <p class="text-[11px] text-[#575752]">{{ $rel->category->name }} &middot; Stok {{ $rel->stock }}</p>
                            <h3 class="mt-1 text-sm font-semibold text-[#18181B] truncate">{{ $rel->name }}</h3>
                            <p class="mt-2 text-sm font-semibold text-[#3F5239] tabular-nums">
                                Rp {{ number_format($rel->price, 0, ',', '.') }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</section>
@endsection
