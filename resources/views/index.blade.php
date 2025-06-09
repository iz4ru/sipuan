@extends('layouts.app')

@section('title', 'SIPUAN - Sistem Kepuasan Layanan')

@section('content')

    <!-- Main Container -->
    <div class="min-h-screen flex flex-col max-w-full">

        @include('layouts.navigation')

        <!-- Hero Section -->
        <section id="hero" class="pt-20 lg:py-40 overflow-hidden bg-gradient-to-b from-[#FAFAFA] from-50% to-[#ECECEC]">
            <div class="px-4 md:max-w-7xl mx-auto w-full flex justify-center items-center">
                <div
                    class="flex flex-col px-4 lg:flex-row items-center justify-between gap-16 lg:gap-56 transition-transform duration-500 ease-in-out">
                    <!-- Left Content -->
                    <div class="lg:max-w-[600px] py-8">
                        <h1 class="text-4xl lg:text-5xl font-bold text-gray-700 leading-tight">
                            Selamat Datang di<br />
                            <span
                                class="bg-gradient-to-r from-[#05C1FF] to-[#0FA3FF] inline-block text-transparent bg-clip-text font-black">
                                SIPUAN <span class="text-gray-700 italic">!</span>
                            </span>
                        </h1>
                        <div class="mt-4">
                            <p class="text-gray-500 text-lg leading-relaxed max-w-[350px] lg:max-w-[400px]">
                                <span class="font-bold">SIPUAN</span> adalah Sistem Kepuasan Layanan yang dirancang
                                untuk memantau dan meningkatkan kualitas layanan dengan mudah dan efisien.
                            </p>
                        </div>
                    </div>

                    <!-- Right Image -->
                    <div
                        class="lg:flex-1 transform -translate-y-16 lg:translate-y-0 lg:translate-x-0 transition-all duration-500 ease-in-out">
                        <img src="{{ asset('image/rafiki.png') }}" alt="Ilustrasi"
                            class="w-full max-w-[500px] mx-auto object-contain" />
                    </div>
                </div>
            </div>
        </section>

        <!-- Best of the Month Section -->
        <section id="best-of-the-month" class="lg:pb-20 overflow-hidden bg-[#ECECEC]">
            <div class="px-4 md:max-w-7xl mx-auto w-full flex justify-center items-center">
                <div class="flex flex-col px-4 items-center gap-16 lg:gap-56 transition-transform duration-500 ease-in-out">
                    <div class="py-8 text-center max-w-[350px] lg:max-w-[450px]">
                        <h2 class="text-3xl lg:text-4xl font-bold text-gray-700 leading-tight">
                            Best Of The Month
                        </h2>

                        @if ($bestStaff)
                            <div class="mt-4">
                                <p class="text-gray-500 text-lg leading-relaxed mx-auto">
                                    Ini adalah staf terbaik kami pada bulan <span
                                        class="font-bold text-[#0FA3FF]">{{ $now->translatedFormat('F Y') }}</span>
                                </p>
                            </div>
                            <div
                                class="transform hover:scale-120 transition duration-300 text-[#FAFAFA] bg-gradient-to-r from-[#05C1FF] to-[#0FA3FF] rounded-full w-16 h-16 flex items-center justify-center mt-8 mx-auto">
                                <i class="fa-solid fa-trophy fa-2xl sm:fa-xl"></i>
                            </div>
                            <div class="mt-8">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="relative w-[320px] h-[320px]">
                                        <img src="{{ Storage::url('images/' . $bestStaff->staff->image) }}"
                                            alt="{{ $bestStaff->staff->name }}"
                                            class="w-full h-full object-cover rounded-t-xl shadow-lg">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-[#0FA3FF]/50 to-transparent opacity-50 rounded-t-xl pointer-events-none">
                                        </div>
                                    </div>
                                    <div
                                        class="shadow-xl flex flex-col gap-2 bg-white/30 backdrop-blur-lg w-full max-w-[320px] py-6 px-6 rounded-b-xl items-center justify-center text-center">
                                        <div class="flex flex-col items-center justify-center gap-1">
                                            <p class="text-gray-700 text-xl font-bold">{{ $bestStaff->staff->name }}</p>
                                            <p class="text-gray-500 text-base">
                                                {{ $bestStaff->staff->position->position_name }}</p>
                                            <p class="text-gray-500 text-base">{{ $bestStaff->staff->id_number }}</p>
                                        </div>
                                        <hr class="w-1/2 border-t border-gray-300" />
                                        <p class="text-gray-500 text-sm">Rating Pelayanan Staf Bulan Ini</p>
                                        <div class="flex gap-2 items-center justify-center text-[#FFD32C] w-10 h-10">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="fa-solid fa-star fa-xl {{ $i <= round($bestStaff->avg_rating) ? '' : 'text-gray-400' }}"></i>
                                            @endfor
                                        </div>
                                        <div>
                                            <p class="text-gray-500 font-bold">
                                                {{ number_format($bestStaff->avg_rating, 1) }} <span
                                                    class="font-normal">dari</span> {{ $bestStaff->total_rating }} ulasan
                                                <span class="text-[#0FA3FF]"> bulan ini</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mt-8">
                                <div class="flex flex-col items-center justify-center gap-4">
                                    <div
                                        class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center text-gray-400">
                                        <i class="fa-solid fa-star-half-stroke fa-2xl"></i>
                                    </div>
                                    <p class="text-gray-500 text-lg leading-relaxed mx-auto">
                                        Belum ada staf terbaik untuk bulan <span
                                            class="font-bold">{{ $now->translatedFormat('F Y') }}</span>
                                    </p>
                                    <p class="text-sm text-gray-400">Ayo beri rating untuk staf agar muncul di sini!</p>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </section>

        <!-- Catalog Section -->
        <section id="catalog" class="overflow-hidden bg-gradient-to-b from-[#ECECEC] from-50% to-[#DDDDDD]">
            <div class="px-4 md:max-w-7xl mx-auto w-full flex justify-center items-center">
                <div class="flex flex-col px-4 items-center transition-transform duration-500 ease-in-out w-full">
                    <!-- Center Content -->
                    <div class="py-8 text-center max-w-[350px] lg:max-w-[450px]">
                        <h2 class="text-3xl lg:text-4xl font-bold text-gray-700 leading-tight">
                            Saran Anda Sangat Berarti Bagi Kami!
                        </h2>
                        <div class="mt-4">
                            <p class="text-gray-500 text-lg leading-relaxed mx-auto">
                                <span class="font-bold">SIPUAN</span> menghargai setiap saran dan masukan dari Anda,
                                demi pelayanan kami yang lebih baik lagi.
                            </p>
                        </div>
                    </div>
                    
                    <div class="transition-all duration-500 ease-in-out">
                        <img src="{{ asset('image/rafiki-3.png') }}" alt="Ilustrasi"
                            class="w-full max-w-[500px] mx-auto object-contain" />
                    </div>

                </div>
            </div>
        </section>

        <!-- Catalog Section -->
        <section id="catalog" class="pb-20 overflow-hidden bg-[#DDDDDD]">
            <div class="px-4 md:max-w-7xl mx-auto w-full flex flex-col justify-center items-center gap-16">
                <div class="flex flex-col px-4 items-center transition-transform duration-500 ease-in-out w-full">
                    <!-- Center Content -->
                    <div class="py-8 text-center max-w-[350px] lg:max-w-[450px]">
                        <h2 class="text-3xl lg:text-4xl font-bold text-gray-700 leading-tight">
                            Punya Lebih Banyak Pertanyaan?
                        </h2>
                        <div class="mt-4">
                            <p class="text-gray-500 text-lg leading-relaxed mx-auto">
                                <span class="font-bold">SIPUAN</span> menyediakan kontak khusus untuk dihubungi
                                langsung oleh Anda. Hubungi kami di:
                            </p>
                        </div>
                    </div>
                    <div class="mt-4 grid lg:grid-cols-2 gap-8 items-center justify-center">
                        <div
                            class="flex flex-col gap-4 items-center justify-center text-center bg-white/30 backdrop-blur-lg w-[360px] h-[180px] rounded-xl">
                            <div class="flex gap-2 items-center justify-center text-[#05C1FF] w-10 h-10">
                                <i class="fa-solid fa-phone fa-xl"></i>
                            </div>
                            <p class="text-gray-700 text-2xl font-bold">(+62) 851 8333 0000</p>
                            <p class="text-gray-500 text-sm">Hubungi kami melalui telepon</p>
                        </div>
                        <div
                            class="flex flex-col gap-4 items-center justify-center text-center bg-white/30 backdrop-blur-lg w-[360px] h-[180px] rounded-xl">
                            <div class="flex gap-2 items-center justify-center text-[#05C1FF] w-10 h-10">
                                <i class="fa-solid fa-envelope fa-xl"></i>
                            </div>
                            <p class="text-gray-700 text-2xl font-bold">infosipuan@gmail.com</p>
                            <p class="text-gray-500 text-sm">Hubungi kami melalui email</p>
                        </div>
                    </div>
                </div>
                <a href="#" class="text-gray-500 hover:text-gray-700 text-sm font-semibold">KEMBALI KE ATAS</a>
            </div>
        </section>

        @include('layouts.footer')

    </div>

@endsection
