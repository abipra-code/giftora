@extends('layouts.app')

@section('title', 'Masuk Panel Admin — Giftora')

@section('content')
<section class="max-w-md mx-auto px-6 py-16">
    <div class="bg-white border border-[#E4E4DE] rounded-2xl p-8 shadow-sm">
        <div class="text-center mb-6">
            <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-[#3F5239]/10 text-[#3F5239] mb-3">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
            </span>
            <h1 class="text-2xl font-serif font-semibold text-[#18181B]">Login Admin</h1>
            <p class="text-xs text-[#575752] mt-1">Masuk untuk mengelola produk &amp; katalog Giftora</p>
        </div>

        @if (session('success'))
            <div class="mb-5 p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-xs text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-5 p-3 rounded-lg bg-red-50 border border-red-200 text-xs text-red-700">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[#575752] mb-1.5" for="username">
                    Username
                </label>
                <input type="text"
                       name="username"
                       id="username"
                       value="{{ old('username') }}"
                       required
                       autofocus
                       placeholder="Masukkan username"
                       class="w-full px-3.5 py-2.5 text-sm border border-[#E4E4DE] rounded-lg focus:outline-none focus:border-[#3F5239] focus:ring-1 focus:ring-[#3F5239] transition">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[#575752] mb-1.5" for="password">
                    Kata Sandi
                </label>
                <input type="password"
                       name="password"
                       id="password"
                       required
                       placeholder="••••••••"
                       class="w-full px-3.5 py-2.5 text-sm border border-[#E4E4DE] rounded-lg focus:outline-none focus:border-[#3F5239] focus:ring-1 focus:ring-[#3F5239] transition">
            </div>

            <div class="flex items-center justify-between text-xs pt-1">
                <label class="flex items-center gap-2 cursor-pointer text-[#575752]">
                    <input type="checkbox" name="remember" class="rounded border-[#D1D1C7] text-[#3F5239] focus:ring-[#3F5239]">
                    <span>Ingat saya di perangkat ini</span>
                </label>
            </div>

            <button type="submit"
                    class="w-full py-2.5 px-4 text-sm font-medium text-white bg-[#3F5239] hover:bg-[#2F3E2A] rounded-lg transition shadow-sm font-sans mt-2">
                Masuk ke Panel Admin
            </button>
        </form>
    </div>
</section>
@endsection
