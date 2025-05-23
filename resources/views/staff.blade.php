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

                        <form action="{{ route('search.staff') }}" method="GET">
                            <div class="my-8 relative w-full flex justify-center">
                                <div class="relative flex items-center gap-4 w-[400px] lg:w-[750px]">
                                    <!-- Label -->
                                    <label for="search" class="text-sm font-semibold text-gray-600 whitespace-nowrap">
                                        Cari Staf:
                                    </label>

                                    <!-- Input Group -->
                                    <div class="relative flex-1">
                                        <i class="fa fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                                        <input placeholder="Masukkan Nama Staf" type="search" name="search" id="search"
                                            value="{{ request('search') }}"
                                            class="w-full h-12 pl-12 placeholder:text-sm placeholder:text-gray-300 border bg-gray-50 border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0FA3FF] transition duration-300 ease-in-out rounded-lg shadow-sm"
                                            autofocus autocomplete="search">
                                    </div>
                                </div>
                            </div>
                        </form>

                        @if ($staffs->count() <= 0)
                            <div class="flex items-center justify-center">
                                <p>Tidak ada data staf yang ditemukan.</p>
                            </div>
                        @endif

                        <div class="my-12 max-w-6xl">
                            <div class="grid lg:grid-cols-3 md:grid-cols-2 gap-12 items-center justify-center">
                                @foreach ($staffs as $staff)
                                    <div class="flex flex-col items-center justify-center">

                                        <div class="hover:scale-103 transition-transform duration-100 ease-in-out">
                                            <div class="relative w-[320px] h-[320px] lg:w-[320px] lg:h-[320px]">
                                                <img src="{{ Storage::url('images/' . $staff->image) }}" alt=""
                                                    class="w-full h-full object-cover rounded-t-xl shadow-lg">
                                                <div
                                                    class="absolute inset-0 bg-gradient-to-t from-[#0FA3FF]/50 from-0% to-50% to-transparent opacity-50 rounded-t-xl pointer-events-none">
                                                </div>
                                            </div>

                                            <div
                                                class="shadow-lg flex flex-col gap-1 bg-white/30 backdrop-blur-lg w-full max-w-[320px] py-6 px-6 rounded-b-xl items-center justify-center text-center">
                                                <p class="text-gray-700 text-xl font-bold">{{ $staff->name }}</p>
                                                </p>
                                                <p class="text-gray-500 text-base">{{ $staff->position->position_name }}</p>
                                                <p class="text-gray-500 text-base">{{ $staff->id_number }}</p>
                                                <hr class="w-1/2 border-t border-gray-300 my-4" />
                                                <p class="text-gray-500 text-sm">Rating Pelayanan Staf</p>
                                                <div
                                                    class="flex gap-2 items-center justify-center text-[#FFD32C] w-10 h-10">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($staff->rate_results_avg_rate >= $i)
                                                            {{-- full star --}}
                                                            <i class="fa-solid fa-star fa-xl"></i>
                                                        @elseif ($staff->rate_results_avg_rate >= $i - 0.5)
                                                            {{-- half star --}}
                                                            <i class="fa-solid fa-star-half-stroke fa-xl"></i>
                                                        @else
                                                            {{-- empty star --}}
                                                            <i class="fa-solid fa-star fa-xl text-gray-400"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <div>
                                                    <p class="text-gray-500 font-bold">
                                                        {{ number_format($staff->rate_results_avg_rate, 1) ?? '0.0' }} dari
                                                        {{ $staff->rate_results_count }} ulasan
                                                    </p>
                                                </div>
                                                <a href="{{ route('rate', $staff->uuid) }}"
                                                    class="mt-4 button bg-gradient-to-r from-[#05C1FF] to-[#0FA3FF] text-[#FAFAFA] justify-center px-12 py-3 rounded-md text-sm font-bold hover:bg-gradient-r hover:from-[#0092C2] hover:to-[#006BAD] transition-colors flex items-center gap-1 sm:gap-2">
                                                    Beri Nilai Pelayanan
                                                    <i class="fa-solid fa-chevron-right fa-sm sm:fa-md"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach


                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full flex justify-center mb-16 lg:mb-0">
                @include('layouts.pagination', ['paginator' => $staffs])
            </div>

        </section>

        @include('layouts.footer')

    </div>


@endsection
