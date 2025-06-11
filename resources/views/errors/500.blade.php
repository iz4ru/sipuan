@extends('layouts.app')

@section('title', 'Server Internal Error')

@section('content')
    <section id="500" class="overflow-hidden bg-gradient-to-b from-[#FAFAFA] from-50% to-[#ECECEC]">
        <div class="flex flex-col items-center justify-center h-screen text-center gap-6 px-4">
            <div class="transition-all duration-500 ease-in-out">
                <img src="{{ asset('image/rafiki-error.png') }}" alt="Ilustrasi"
                    class="w-full max-w-[300px] mx-auto object-contain" />
            </div>
            <div class="flex flex-col gap-4 max-w-[350px] lg:max-w-[450px]">
                <h2 class="text-7xl lg:text-7xl font-extrabold text-gray-700 leading-tight">
                    500
                </h2>
                <p class="text-gray-500 lg:text-lg leading-relaxed">
                    Kesalahan: Terjadi kesalahan internal pada server. Kami mohon maaf atas ketidaknyamanan ini.
                </p>
            </div>
        </div>
    </section>
@endsection