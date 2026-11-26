@extends('layouts.app')

@section('title', 'Tentang Kami — PT Anugerah Pratama | Giftora')

@section('content')
<section class="max-w-6xl mx-auto px-6 py-16">
    <div class="grid lg:grid-cols-12 gap-12 items-start">
        {{-- Kolom Kiri: Tentang Perusahaan --}}
        <div class="lg:col-span-7">
            <div class="flex items-center gap-3 mb-4">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full border border-[#D1D1C7] text-xs font-semibold text-[#575752] tracking-wider">
                    AP
                </span>
                <span class="text-xs font-medium text-[#71716A]">Tentang Perusahaan</span>
            </div>

            <h1 class="text-3xl md:text-4xl font-serif font-semibold text-[#18181B] tracking-tight">
                PT Anugerah Pratama
            </h1>

            <div class="mt-6 space-y-4 text-sm md:text-base text-[#3F3F3E] leading-relaxed">
                <p>
                    <strong>Giftora</strong> merupakan merek UMKM hampers dan gift box eksklusif di bawah naungan <strong>PT Anugerah Pratama</strong> &mdash; nama perusahaan yang diambil dari inisial huruf pertama pendirinya, <strong>Abi Prasetio (A.P.)</strong>.
                </p>
                <p class="text-[#575752]">
                    Kami berfokus mengkurasi produk pangan artisan, kopi dan teh Nusantara, lilin aromaterapi, serta kerajinan keramik dari pelaku UMKM lokal agar tampil dalam kemasan kotak kado yang rapi, aman dikirim antarkota, dan siap mencerminkan identitas penerima maupun perusahaan Anda.
                </p>
            </div>

            <hr class="border-[#E4E4DE] my-8">

            <div class="grid sm:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-sm font-semibold text-[#18181B]">01. Kurasi Produk UMKM</h3>
                    <p class="mt-2 text-xs text-[#575752] leading-relaxed">
                        Setiap item melewati uji rasa, ketahanan kemasan, dan keselarasan visual sebelum masuk ke dalam katalog Giftora.
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-[#18181B]">02. Kustomisasi Korporat</h3>
                    <p class="mt-2 text-xs text-[#575752] leading-relaxed">
                        Mendukung pemasangan pita warna khusus, kartu ucapan bermerek, hingga cetak embos logo perusahaan untuk pemesanan massal.
                    </p>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Testimoni --}}
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white border border-[#E4E4DE] rounded-xl p-6 shadow-sm">
                <p class="text-xs font-medium text-[#71716A]">Testimoni Mitra &amp; Pelanggan</p>
                <blockquote class="mt-3 text-sm text-[#18181B] leading-relaxed">
                    &ldquo;Kami memesan 120 box Executive Brew dari PT Anugerah Pratama untuk apresiasi klien akhir tahun. Pengemasan tiba utuh di Surabaya dan Jakarta dengan embos logo yang sangat rapi.&rdquo;
                </blockquote>
                <p class="mt-4 text-xs text-[#71716A]">
                    Rangga Mahendra &middot; Head of People, PT Sinar Karsa Mandiri
                </p>
            </div>

            <div class="bg-white border border-[#E4E4DE] rounded-xl p-6 shadow-sm">
                <p class="text-xs font-medium text-[#71716A]">Pengiriman Hari Raya</p>
                <blockquote class="mt-3 text-sm text-[#18181B] leading-relaxed">
                    &ldquo;Raya Serenity Bamboo Hamper menjadi favorit keluarga besar tahun ini. Kue keringnya autentik dan keranjang bambunya masih terpakai di ruang tamu.&rdquo;
                </blockquote>
                <p class="mt-4 text-xs text-[#71716A]">
                    Nadia Kusuma &middot; Pelanggan Personal, Bandar Lampung
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
