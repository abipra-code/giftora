@extends('layouts.app')

@section('title', 'Keranjang Belanja — Giftora')

@section('content')
<section class="max-w-6xl mx-auto px-6 py-12">
    <div class="flex items-center justify-between border-b border-[#E4E4DE] pb-5 mb-8">
        <div>
            <h1 class="text-3xl font-serif font-semibold text-[#18181B]">Keranjang Belanja</h1>
            <p class="text-xs text-[#575752] mt-1">Kelola pilihan hampers pilihan Anda sebelum memesan</p>
        </div>
        <a href="{{ route('home') }}" class="text-xs font-medium text-[#3F5239] hover:text-[#2F3E2A] flex items-center gap-1.5 transition">
            <span>&larr;</span> Lanjut Belanja
        </a>
    </div>

    {{-- Flash Notifications --}}
    @if (session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-800 flex items-center justify-between">
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if (session('warning'))
        <div class="mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 text-xs text-amber-800 flex items-center justify-between">
            <span>{{ session('warning') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-xs text-red-700 flex items-center justify-between">
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if (empty($cart) || count($cart) === 0)
        {{-- Keranjang Kosong --}}
        <div class="bg-white border border-[#E4E4DE] rounded-2xl p-12 text-center max-w-lg mx-auto my-10 shadow-sm">
            <span class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-[#FAFAF8] border border-[#E4E4DE] text-[#71716A] mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </span>
            <h2 class="text-xl font-serif font-semibold text-[#18181B]">Keranjang Belanja Masih Kosong</h2>
            <p class="mt-2 text-xs text-[#575752] leading-relaxed max-w-sm mx-auto">
                Anda belum menambahkan kurasi hampers ke keranjang. Jelajahi ragam bingkisan eksklusif kami sekarang.
            </p>
            <div class="mt-6">
                <a href="{{ route('home') }}" class="inline-block px-5 py-2.5 text-xs font-semibold text-white bg-[#3F5239] hover:bg-[#2F3E2A] rounded-lg transition shadow-sm">
                    Lihat Katalog Hampers
                </a>
            </div>
        </div>
    @else
        <div class="grid lg:grid-cols-12 gap-10 items-start">
            {{-- Daftar Produk di Keranjang --}}
            <div class="lg:col-span-8 space-y-4">
                <div class="bg-white border border-[#E4E4DE] rounded-2xl overflow-hidden shadow-sm divide-y divide-[#E4E4DE]">
                    @foreach ($cart as $item)
                        @php
                            $itemSubtotal = $item['price'] * $item['quantity'];
                            $isMaxStock = $item['quantity'] >= $item['stock'];
                        @endphp
                        <div class="p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5">
                            {{-- Info Produk --}}
                            <div class="flex items-center gap-4 min-w-0">
                                <a href="{{ route('products.show', $item['slug']) }}" class="w-20 h-20 rounded-xl bg-[#F2F2EE] border border-[#E4E4DE] overflow-hidden shrink-0 block">
                                    <img src="{{ asset($item['image_path']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                </a>
                                <div class="min-w-0">
                                    <span class="text-[11px] uppercase tracking-wider text-[#3F5239] font-semibold block">
                                        {{ $item['category_name'] }}
                                    </span>
                                    <a href="{{ route('products.show', $item['slug']) }}" class="text-sm font-semibold text-[#18181B] hover:text-[#3F5239] transition truncate block">
                                        {{ $item['name'] }}
                                    </a>
                                    <p class="text-xs text-[#575752] mt-0.5">
                                        Rp {{ number_format($item['price'], 0, ',', '.') }} / box
                                    </p>
                                    <p class="text-[11px] text-amber-700 mt-1 flex items-center gap-1 font-medium">
                                        <span>Stok tersedia: <strong>{{ $item['stock'] }}</strong></span>
                                        @if ($isMaxStock)
                                            <span class="bg-amber-100 text-amber-800 px-1.5 py-0.5 rounded text-[10px]">(Maksimal tercapai)</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            {{-- Quantity Stepper & Subtotal --}}
                            <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto pt-3 sm:pt-0 border-t sm:border-t-0 border-[#E4E4DE]">
                                {{-- Form Update Quantity --}}
                                <div class="flex items-center border border-[#E4E4DE] rounded-lg overflow-hidden bg-[#FAFAF8]">
                                    {{-- Minus Button --}}
                                    <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="quantity" value="{{ $item['quantity'] - 1 }}">
                                        <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center text-sm font-semibold text-[#575752] hover:bg-gray-100 transition"
                                                title="Kurangi kuantitas">
                                            &minus;
                                        </button>
                                    </form>

                                    {{-- Direct Input --}}
                                    <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="number"
                                               name="quantity"
                                               value="{{ $item['quantity'] }}"
                                               min="1"
                                               max="{{ $item['stock'] }}"
                                               onchange="this.form.submit()"
                                               class="w-12 h-8 text-center text-xs font-semibold bg-white border-x border-[#E4E4DE] focus:outline-none"
                                               title="Maksimal {{ $item['stock'] }}">
                                    </form>

                                    {{-- Plus Button --}}
                                    <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                        <button type="submit"
                                                @if ($isMaxStock) disabled @endif
                                                class="w-8 h-8 flex items-center justify-center text-sm font-semibold transition {{ $isMaxStock ? 'text-gray-300 cursor-not-allowed bg-gray-50' : 'text-[#575752] hover:bg-gray-100' }}"
                                                title="{{ $isMaxStock ? 'Stok maksimal telah tercapai' : 'Tambah kuantitas' }}">
                                            +
                                        </button>
                                    </form>
                                </div>

                                {{-- Subtotal --}}
                                <div class="text-right min-w-[100px]">
                                    <p class="text-sm font-semibold text-[#18181B] tabular-nums">
                                        Rp {{ number_format($itemSubtotal, 0, ',', '.') }}
                                    </p>
                                </div>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('cart.remove', $item['id']) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="p-1.5 text-gray-400 hover:text-red-600 transition"
                                            title="Hapus produk dari keranjang"
                                            onclick="return confirm('Hapus {{ $item['name'] }} dari keranjang?');">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Action Bawah Keranjang --}}
                <div class="flex items-center justify-between pt-2">
                    <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Kosongkan semua produk di keranjang?');">
                        @csrf
                        <button type="submit" class="text-xs text-red-600 hover:text-red-700 hover:underline">
                            Kosongkan Keranjang
                        </button>
                    </form>
                    <a href="{{ route('home') }}" class="text-xs text-[#575752] hover:text-[#18181B] underline">
                        + Tambah Produk Lain
                    </a>
                </div>
            </div>

            {{-- Ringkasan Pesanan (Order Summary) --}}
            <div class="lg:col-span-4">
                <div class="bg-white border border-[#E4E4DE] rounded-2xl p-6 shadow-sm sticky top-24 space-y-5">
                    <h2 class="text-base font-serif font-semibold text-[#18181B] border-b border-[#E4E4DE] pb-3">
                        Ringkasan Pesanan
                    </h2>

                    <div class="space-y-3 text-xs text-[#575752]">
                        <div class="flex items-center justify-between">
                            <span>Total Jumlah Box</span>
                            <span class="font-semibold text-[#18181B] tabular-nums">{{ $totalItems }} box</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>Kustomisasi Kemasan</span>
                            <span class="text-emerald-700 font-medium">Termasuk Pita &amp; Kartu</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>Estimasi Pengiriman</span>
                            <span class="text-[#71716A]">Dihitung saat konfirmasi</span>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-[#E4E4DE] flex items-center justify-between">
                        <span class="text-sm font-semibold text-[#18181B]">Total Harga</span>
                        <span class="text-lg font-semibold text-[#3F5239] tabular-nums">
                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                        </span>
                    </div>

                    @php
                        // Format pesan WhatsApp untuk pemesanan mudah
                        $waText = "Halo Giftora (PT Anugerah Pratama), saya ingin memesan hampers:%0A";
                        foreach ($cart as $ci) {
                            $waText .= "- {$ci['name']} ({$ci['quantity']} box) @ Rp " . number_format($ci['price'], 0, ',', '.') . "%0A";
                        }
                        $waText .= "%0ATotal Pesanan: Rp " . number_format($subtotal, 0, ',', '.') . "%0AMohon informasi ketersediaan dan pengiriman. Terima kasih!";
                    @endphp

                    <div class="space-y-2 pt-2">
                        <a href="https://wa.me/6281234567890?text={{ $waText }}"
                           target="_blank"
                           class="w-full py-3 px-4 text-xs font-semibold text-white bg-[#3F5239] hover:bg-[#2F3E2A] rounded-xl transition shadow-sm flex items-center justify-center gap-2 text-center">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.969.586 1.761.88 2.796.88 3.179 0 5.767-2.587 5.767-5.766.001-3.182-2.585-5.767-5.767-5.767zm0 10.373c-.927 0-1.748-.266-2.456-.757l-.176-.118-1.58.415.422-1.541-.129-.189c-.588-.863-.898-1.706-.897-2.716 0-2.535 2.062-4.597 4.599-4.597 2.535 0 4.598 2.063 4.598 4.598 0 2.536-2.062 4.597-4.597 4.597zm-6.223 3.627l-.808.212-2-.524 2.115-.554.693.866zm14.192-16.172c-2.313-2.314-5.389-3.589-8.659-3.589-6.744 0-12.231 5.487-12.231 12.231 0 2.155.562 4.258 1.631 6.11l-1.732 6.326 6.471-1.698c1.789.976 3.8 1.492 5.861 1.492 6.744 0 12.231-5.487 12.231-12.231 0-3.27-1.275-6.345-3.59-8.641z"/>
                            </svg>
                            <span>Pesan via WhatsApp</span>
                        </a>
                        <p class="text-[10px] text-center text-[#71716A]">
                            Pemesanan korporat &amp; massal dilayani langsung oleh tim kurasi PT Anugerah Pratama.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>
@endsection
