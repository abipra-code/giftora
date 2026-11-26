@extends('layouts.app')

@section('title', 'Admin Kelola Produk — Giftora')

@section('content')
<section class="max-w-6xl mx-auto px-6 py-12">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-serif font-semibold text-[#18181B]">Manajemen Produk Hampers</h1>
            <p class="text-xs text-[#575752] mt-1">
                PT Anugerah Pratama &middot; Panel Admin CRUD &middot; Login sebagai: <span class="font-medium text-[#18181B]">{{ auth()->user()->name ?? 'Admin' }}</span>
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.products.create') }}" class="px-4 py-2 text-xs font-medium text-white bg-[#3F5239] rounded-lg hover:bg-[#2F3E2A] transition">
                + Tambah Produk
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-3.5 py-2 text-xs font-medium text-red-700 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg transition">
                    Keluar Admin
                </button>
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-lg bg-[#3F5239]/10 border border-[#3F5239]/30 text-xs text-[#2F3E2A]">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-[#E4E4DE] rounded-xl overflow-x-auto shadow-sm">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-[#E4E4DE] bg-[#F2F2EE] text-xs uppercase text-[#575752]">
                <tr>
                    <th class="px-4 py-3 w-16">Foto</th>
                    <th class="px-4 py-3">Produk</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3 text-right">Harga</th>
                    <th class="px-4 py-3 text-right">Stok</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E4E4DE]">
                @forelse ($products as $product)
                    <tr class="hover:bg-[#FAFAF8] transition">
                        <td class="px-4 py-3">
                            <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded-lg border border-[#E4E4DE] bg-gray-50">
                        </td>
                        <td class="px-4 py-3 font-medium text-[#18181B]">{{ $product->name }}</td>
                        <td class="px-4 py-3 text-[#575752]">{{ $product->category->name }}</td>
                        <td class="px-4 py-3 text-right tabular-nums font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-right tabular-nums">{{ $product->stock }}</td>
                        <td class="px-4 py-3 text-right space-x-2 text-xs">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-[#3F5239] hover:underline font-medium">Ubah</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-700 hover:underline font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-xs text-[#71716A]">
                            Belum ada produk yang ditambahkan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
