@extends('layouts.app')

@section('content')
<section class="max-w-2xl mx-auto px-6 py-12">
    <a href="{{ route('admin.products.index') }}" class="text-xs text-[#575752] hover:text-[#18181B] mb-4 inline-block">&larr; Kembali ke Panel Admin</a>
    <h1 class="text-2xl font-serif font-semibold mb-6">
        {{ isset($product) ? 'Ubah Produk Hampers' : 'Tambah Produk Hampers Baru' }}
    </h1>

    <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-5 bg-white border border-[#E4E4DE] rounded-xl p-6">
        @csrf
        @if (isset($product))
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Kategori</label>
            <select name="category_id" class="w-full border border-[#E4E4DE] rounded-lg px-3 py-2 text-sm">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? '') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <p class="mt-1 text-xs text-red-700">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Nama Produk (Maks. 120 karakter)</label>
            <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" class="w-full border border-[#E4E4DE] rounded-lg px-3 py-2 text-sm">
            @error('name') <p class="mt-1 text-xs text-red-700">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">SKU (Maks. 30 karakter)</label>
                <input type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}" class="w-full border border-[#E4E4DE] rounded-lg px-3 py-2 text-sm">
                @error('sku') <p class="mt-1 text-xs text-red-700">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Harga (Rp)</label>
                <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}" class="w-full border border-[#E4E4DE] rounded-lg px-3 py-2 text-sm">
                @error('price') <p class="mt-1 text-xs text-red-700">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Stok</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 10) }}" class="w-full border border-[#E4E4DE] rounded-lg px-3 py-2 text-sm">
                @error('stock') <p class="mt-1 text-xs text-red-700">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Berat (gram)</label>
                <input type="number" name="weight_grams" value="{{ old('weight_grams', $product->weight_grams ?? 1500) }}" class="w-full border border-[#E4E4DE] rounded-lg px-3 py-2 text-sm">
                @error('weight_grams') <p class="mt-1 text-xs text-red-700">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Ringkasan Isi Gift Box (Maks. 255 karakter)</label>
            <input type="text" name="contents_summary" value="{{ old('contents_summary', $product->contents_summary ?? '') }}" class="w-full border border-[#E4E4DE] rounded-lg px-3 py-2 text-sm">
            @error('contents_summary') <p class="mt-1 text-xs text-red-700">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Deskripsi Lengkap (Maks. 2000 karakter)</label>
            <textarea name="description" rows="4" class="w-full border border-[#E4E4DE] rounded-lg px-3 py-2 text-sm">{{ old('description', $product->description ?? '') }}</textarea>
            @error('description') <p class="mt-1 text-xs text-red-700">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Foto Produk (JPG/PNG/WEBP, Maks. 2MB)</label>
            @if (isset($product) && $product->image_path)
                <div class="mb-3 flex items-center gap-3">
                    <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded-lg border border-[#E4E4DE]">
                    <span class="text-xs text-[#575752]">Foto saat ini. Pilih file di bawah jika ingin menggantinya.</span>
                </div>
            @endif
            <input type="file" name="image" accept="image/*" class="w-full text-sm" {{ isset($product) ? '' : 'required' }}>
            @error('image') <p class="mt-1 text-xs text-red-700">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-[#3F5239] rounded-lg hover:bg-[#2F3E2A]">
            Simpan Produk
        </button>
    </form>
</section>
@endsection
