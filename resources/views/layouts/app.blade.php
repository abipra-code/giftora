<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Giftora — Curated Hampers & Gift Box | PT Anugerah Pratama')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,400..600;1,6..72,400..600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-serif { font-family: 'Newsreader', serif; }
    </style>
</head>
<body class="bg-[#FAFAF8] text-[#18181B] antialiased flex flex-col min-h-screen">
    {{-- Header --}}
    <header class="border-b border-[#E4E4DE] bg-[#FAFAF8]/95 sticky top-0 z-30 backdrop-blur">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between gap-8">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 text-xl font-serif font-semibold tracking-tight whitespace-nowrap shrink-0">
                <svg class="w-7 h-7 text-[#3F5239]" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.6">
                    <rect x="4" y="10" width="24" height="18" rx="2"/>
                    <path d="M4 15h24M16 10v18"/>
                    <path d="M16 10c-3.5 0-6-2-6-4.2C10 4 12 3 14 4.5L16 10Zm0 0c3.5 0 6-2 6-4.2C22 4 20 3 18 4.5L16 10Z"/>
                </svg>
                <span>Giftora</span>
            </a>

            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-[#575752]">
                <a href="{{ route('home') }}"
                   class="hover:text-[#18181B] transition whitespace-nowrap py-1 {{ request()->routeIs('home') ? 'text-[#18181B] font-semibold border-b-2 border-[#18181B]' : '' }}">
                    Katalog
                </a>
                <a href="{{ route('about') }}"
                   class="hover:text-[#18181B] transition whitespace-nowrap py-1 {{ request()->routeIs('about') ? 'text-[#18181B] font-semibold border-b-2 border-[#18181B]' : '' }}">
                    Tentang Kami
                </a>
                <a href="{{ route('admin.products.index') }}"
                   class="hover:text-[#18181B] transition whitespace-nowrap py-1 {{ request()->is('admin*') ? 'text-[#18181B] font-semibold border-b-2 border-[#18181B]' : '' }}">
                    Kelola Admin
                </a>
            </nav>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('admin.products.create') }}" class="px-3.5 py-2 text-xs font-medium text-white bg-[#3F5239] rounded-lg hover:bg-[#2F3E2A] whitespace-nowrap shrink-0 transition">
                        + Tambah Produk
                    </a>
                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" title="Keluar dari Admin" class="px-3 py-2 text-xs font-medium text-red-700 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg whitespace-nowrap transition">
                            Keluar
                        </button>
                    </form>
                @else
                    @php
                        $cartItems = session('cart', []);
                        $cartCount = array_sum(array_column($cartItems, 'quantity'));
                    @endphp
                    <a href="{{ route('cart.index') }}"
                       class="flex items-center gap-2 px-4 py-2 text-xs font-medium text-white bg-[#374632] hover:bg-[#2A3726] rounded-lg whitespace-nowrap shrink-0 transition shadow-sm {{ request()->routeIs('cart.index') ? 'ring-2 ring-[#3F5239] ring-offset-2' : '' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span>Keranjang ({{ $cartCount }})</span>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="border-t border-[#E4E4DE] bg-[#FAFAF8] mt-20">
        <div class="max-w-6xl mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                {{-- Kolom Kiri --}}
                <div class="md:col-span-5">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 text-lg font-serif font-semibold tracking-tight text-[#18181B]">
                        <svg class="w-5 h-5 text-[#3F5239]" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.6">
                            <rect x="4" y="10" width="24" height="18" rx="2"/>
                            <path d="M4 15h24M16 10v18"/>
                            <path d="M16 10c-3.5 0-6-2-6-4.2C10 4 12 3 14 4.5L16 10Zm0 0c3.5 0 6-2 6-4.2C22 4 20 3 18 4.5L16 10Z"/>
                        </svg>
                        <span>Giftora</span>
                    </a>
                    <p class="mt-3 text-xs text-[#575752] leading-relaxed max-w-sm">
                        Studio kurasi hampers dan gift box UMKM Indonesia oleh <strong>PT Anugerah Pratama</strong> (Abi Prasetio).
                    </p>
                </div>

                {{-- Kolom Tengah: Navigasi --}}
                <div class="md:col-span-4">
                    <h4 class="text-xs font-semibold text-[#18181B]">Navigasi Situs</h4>
                    <ul class="mt-3 space-y-2 text-xs text-[#575752]">
                        <li>
                            <a href="{{ route('home') }}" class="hover:text-[#18181B] transition">Katalog Hampers</a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}" class="hover:text-[#18181B] transition">Tentang PT Anugerah Pratama</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.products.index') }}" class="hover:text-[#18181B] transition">Panel Admin CRUD</a>
                        </li>
                    </ul>
                </div>

                {{-- Kolom Kanan: Info PT --}}
                <div class="md:col-span-3 flex md:justify-end">
                    <div class="flex items-start gap-3">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full border border-[#D1D1C7] text-[11px] font-semibold text-[#575752] shrink-0">
                            AP
                        </span>
                        <div>
                            <p class="text-xs font-semibold text-[#18181B]">PT Anugerah Pratama</p>
                            <p class="text-[11px] text-[#71716A]">Bandar Lampung &middot; Indonesia</p>
                            <p class="text-[11px] text-[#71716A] mt-0.5">&copy; 2026 Giftora</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
