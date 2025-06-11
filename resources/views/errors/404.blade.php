@extends('layouts.app')

@section('title', 'Halaman Tidak Ditemukan')

@section('content')
    <section id="404" class="overflow-hidden bg-gradient-to-b from-[#FAFAFA] from-50% to-[#ECECEC]">
        <div class="flex flex-col items-center justify-center h-screen text-center gap-6 px-4">
            <div class="transition-all duration-500 ease-in-out">
                <img src="{{ asset('image/rafiki-error.png') }}" alt="Ilustrasi"
                    class="w-full max-w-[300px] mx-auto object-contain" />
            </div>
            <div class="flex flex-col gap-4 max-w-[350px] lg:max-w-[450px]">
                <h2 class="text-7xl lg:text-7xl font-extrabold text-gray-700 leading-tight">
                    404
                </h2>
                <p class="text-gray-500 lg:text-lg leading-relaxed">
                    Kesalahan: Halaman yang Anda cari tidak ditemukan.
                </p>
            </div>
            <a href="{{ url('/') }}" class="text-blue-500 hover:underline">Kembali ke Beranda</a>
        </div>
    </section>
@endsection
