@extends('layouts.app')

@section('title', 'Lihat Staff')

@section('content')

    <div class="min-h-screen flex flex-col max-w-full">

        @include('layouts.navigation')

        <!-- Search Staff Section -->
        <section id="search-staff"
            class="pt-20 lg:py-20 overflow-hidden bg-gradient-to-b from-[#FAFAFA] from-50% to-[#ECECEC]">
            <div class="py-4 lg:px-24 lg:py-6">
                <div class="flex items-center gap-6 px-8 py-4">
                    <a href="/#catalog" class="text-gray-600 hover:text-gray-800 transition-colors items-center flex gap-2">
                        <i class="fa-solid fa-chevron-left"></i>
                        <span class="text-sm font-semibold">Kembali</span>
                    </a>
                </div>
            </div>
            <div class="px-4 mx-auto w-full flex justify-center items-center">
                <div class="flex flex-col px-4 items-center gap-16 lg:gap-56 transition-transform duration-500 ease-in-out">
                    <!-- Center Content -->
                    <div class="text-center">
                        <h2 class="text-2xl lg:text-4xl font-bold text-gray-700 leading-tight">
                            Cari Nama Staf
                        </h2>
                        <div class="mt-4">
                            <p class="text-gray-500 text-base leading-relaxed mx-auto lg:text-lg w-[400px]">
                                Tidak perlu berlama-lama untuk mencari seorang staf, Anda dapat mencarinya!~
                            </p>
                        </div>

                        <div class="mt-4 relative w-full flex justify-center">
                            <div class="relative w-[400px] lg:w-[750px]">
                                <i class="fa fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                            <input placeholder="Masukkan Nama Staf" type="search" name="search" id="search"
                                value="{{ old('search') }}"
                                class="w-full h-14 pl-12 placeholder:text-gray-300 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0FA3FF] transition duration-300 ease-in-out rounded-full shadow-sm"
                                required autofocus autocomplete="search">
                            </div>
                        </div>

                        <div class="my-12 max-w-6xl">
                            <div class="grid lg:grid-cols-3 md:grid-cols-2 gap-12 items-center justify-center">
                                <div class="flex flex-col items-center justify-center">
                                    <img src="https://placehold.co/320x320?text=&font=Poppins" alt=""
                                        class="rounded-t-xl w-full max-w-[320px] shadow-xl" />
                                    <div
                                        class="shadow-xl flex flex-col gap-1 bg-white/30 backdrop-blur-lg w-full max-w-[320px] py-6 px-6 rounded-b-xl items-center justify-center text-center">
                                        <p class="text-gray-700 text-xl font-bold">Anita Faiziyah, S.Kom
                                        </p>
                                        <p class="text-gray-500 text-base">Administrasi TIK</p>
                                        <p class="text-gray-500 text-base">12300111</p>
                                        <hr class="w-1/2 border-t border-gray-300 my-4" />
                                        <p class="text-gray-500 text-sm">Rating Pelayanan Staf</p>
                                        <div class="flex gap-2 items-center justify-center text-[#FFD32C] w-10 h-10">
                                            <i class="fa-solid fa-star fa-xl"></i>
                                            <i class="fa-solid fa-star fa-xl"></i>
                                            <i class="fa-solid fa-star fa-xl"></i>
                                            <i class="fa-solid fa-star fa-xl"></i>
                                            <i class="fa-solid fa-star fa-xl text-gray-500"></i>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 font-bold">4.0 <span class="font-normal">dari</span> 50
                                                ulasan</p>
                                        </div>
                                        <a href="{{ route('rate') }}"
                                            class="mt-4 button bg-gradient-to-r from-[#05C1FF] to-[#0FA3FF] text-[#FAFAFA] justify-center px-12 py-3 rounded-md text-sm font-bold hover:bg-gradient-r hover:from-[#0092C2] hover:to-[#006BAD] transition-colors flex items-center gap-1 sm:gap-2">
                                            Beri Nilai Pelayanan
                                            <i class="fa-solid fa-chevron-right fa-sm sm:fa-md"></i>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('layouts.footer')

    </div>


@endsection
