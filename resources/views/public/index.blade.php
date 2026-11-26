@extends('layouts.app')

@section('content')
<section class="max-w-6xl mx-auto px-6 py-16">
    <div class="grid lg:grid-cols-2 gap-10 items-center">
        <div>
            <p class="text-xs uppercase tracking-widest text-[#3F5239] font-semibold">PT Anugerah Pratama · UMKM Hampers</p>
            <h1 class="mt-3 text-4xl md:text-5xl font-serif font-semibold leading-tight text-[#18181B]">
                Hadiah Kurasi dengan Sentuhan Personal
            </h1>
            <p class="mt-4 text-[#575752] leading-relaxed">
                Giftora di bawah naungan <strong>PT Anugerah Pratama</strong> menghadirkan hampers dan gift box eksklusif yang memadukan produk UMKM lokal terbaik ke dalam kemasan berkelas.
            </p>
        </div>
    </div>
</section>

<section id="katalog" class="max-w-6xl mx-auto px-6 py-12">
    {{-- Notifikasi Flash --}}
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

    {{-- Kategori Filter --}}
    <div class="flex flex-wrap items-center gap-3 mb-8">
        <a href="{{ route('home') }}" class="px-4 py-2 text-xs font-medium rounded-lg border transition {{ !request('kategori') ? 'bg-[#3F5239] text-white border-[#3F5239]' : 'bg-white text-[#575752] border-[#E4E4DE] hover:bg-gray-50' }}">
            Semua Kategori
        </a>
        @foreach ($categories as $category)
            <a href="{{ route('home', ['kategori' => $category->slug]) }}" class="px-4 py-2 text-xs font-medium rounded-lg border transition {{ request('kategori') === $category->slug ? 'bg-[#3F5239] text-white border-[#3F5239]' : 'bg-white text-[#575752] border-[#E4E4DE] hover:bg-gray-50' }}">
                {{ $category->name }} ({{ $category->products_count }})
            </a>
        @endforeach
    </div>

    {{-- Grid Produk --}}
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($products as $product)
            <div class="group bg-white border border-[#E4E4DE] rounded-2xl overflow-hidden hover:-translate-y-0.5 transition shadow-sm flex flex-col justify-between">
                <div>
                    <a href="{{ route('products.show', $product->slug) }}" class="aspect-[4/3] bg-[#F2F2EE] overflow-hidden block">
                        <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </a>
                    <div class="p-5 pb-2">
                        <div class="flex items-center justify-between text-xs text-[#575752]">
                            <span>{{ $product->category->name }}</span>
                            @if ($product->stock > 0)
                                <span class="text-emerald-700 font-medium">Stok {{ $product->stock }}</span>
                            @else
                                <span class="text-red-600 font-medium">Habis</span>
                            @endif
                        </div>
                        <h2 class="mt-2 text-base font-semibold text-[#18181B]">
                            <a href="{{ route('products.show', $product->slug) }}" class="hover:text-[#3F5239] transition">
                                {{ $product->name }}
                            </a>
                        </h2>
                    </div>
                </div>

                <div class="p-5 pt-3 border-t border-[#F2F2EE] flex items-center justify-between gap-3">
                    <p class="text-base font-semibold tabular-nums text-[#3F5239]">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>
                    @if ($product->stock > 0)
                        <form action="{{ route('cart.add', $product) }}" method="POST">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit"
                                    class="px-3 py-1.5 text-xs font-semibold text-white bg-[#3F5239] hover:bg-[#2F3E2A] rounded-lg transition flex items-center gap-1.5 shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span>Keranjang</span>
                            </button>
                        </form>
                    @else
                        <button disabled class="px-3 py-1.5 text-xs font-medium text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                            Habis
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <p class="col-span-3 text-center text-[#575752] py-12">Belum ada produk hampers pada kategori ini.</p>
        @endforelse
    </div>
</section>
@endsection
