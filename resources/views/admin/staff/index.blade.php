@extends('admin.layouts.app')

@section('title', 'Manajemen Staf')

@section('content')
    <div class="flex-1 overflow-y-auto px-8 pt-6 pb-6">
        <div class="space-y-6">
            <div class="flex flex-col bg-white/30 backdrop-blur-lg rounded-xl shadow-lg p-6">
                <div class="bg-gradient-to-r from-[#05C1FF]/20 to-[#0FA3FF]/20 rounded-lg shadow-lg p-6">
                    <div class="">
                        <h1 class="text-2xl lg:text-3xl font-bold text-[#0B8BDB] mb-2">Manajemen Staf</h1>
                        <p class="text-sm text-[#0B8BDB] lg:text-base">Tambahkan data staff atau manajemen staf.
                        </p>
                    </div>
                    @if (Auth::user()->role == 'admin')
                        <div class="shadow-lg w-max mt-4">
                            <a href="{{ route('staff.mgmt.create') }}"
                                class="font-semibold flex items-center gap-3 px-4 py-3 lg:px-6 lg:py-4 bg-gradient-to-r from-[#05C1FF] to-[#0FA3FF] text-white rounded-md hover:bg-gradient-r hover:from-[#0092C2] hover:to-[#006BAD] transform transition duration-100 ease-in-out">
                                <span class="text-sm lg:text-base">Daftarkan Staff</span>
                                <i class="fa-solid fa-user-plus fa-sm lg:fa-md"></i>
                            </a>
                        </div>
                    @endif
                </div>
                <hr class="rounded border-t-2 border-[#B8B8B8]/50 my-8 mx-6">

                <!-- Alerts -->
                @if (session('success'))
                    <div class="mb-8 alert alert-success alert-dismissible relative text-sm py-2 px-4 bg-green-100 text-green-500 border border-green-500 rounded-md opacity-0 transition-opacity duration-150 ease-in-out"
                        role="alert" id="successAlert">
                        <i class="fa fa-circle-check absolute left-4 top-1/2 -translate-y-1/2"></i>
                        <p class="ml-6">{{ session('success') }}</p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-8 alert alert-danger alert-dismissible relative text-sm py-2 px-4 bg-red-100 text-red-500 border border-red-500 rounded-md opacity-0 transition-opacity duration-150 ease-in-out"
                        role="alert" id="errorAlert">
                        <i class="fa fa-circle-exclamation absolute left-4 top-1/2 -translate-y-1/2"></i>
                        <ul class="list-none m-0 p-0">
                            @foreach ($errors->all() as $error)
                                <li class="ml-6">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('staff.mgmt') }}" method="GET">
                    <div class="mb-8 relative w-full flex justify-center">
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


                <div class="overflow-x-auto text-sm">

                    @if ($staffs->count() <= 0)
                        <div class="flex items-center justify-center">
                            <p>Tidak ada data yang ditemukan.</p>
                        </div>
                    @endif

                    <!-- Mobile Carousel View -->
                    <div class="sm:hidden" x-data="staffCarousel()">
                        <!-- Swiper Container -->
                        <div class="w-full mx-auto relative" x-ref="staffSwiper">
                            <!-- Swiper Wrapper -->
                            <div class="swiper-wrapper">
                                @foreach ($staffs as $staff)
                                    <div class="swiper-slide h-auto">
                                        <div class="bg-white/30 backdrop-blur-xl rounded-xl shadow-lg p-6">
                                            <div class="flex justify-center items-center">
                                                <div class="flex flex-col items-center justify-center">
                                                    <!-- Candidate Name and Position -->
                                                    <div class="text-center">
                                                        <h3
                                                            class="text-xl my-1 font-bold text-gray-700 truncate w-full max-w-[320px] mx-auto">
                                                            {{ $staff->name }}</h3>
                                                        <p class="text-gray-500 text-base">
                                                            {{ $staff->as_who }}</p>
                                                        <p class="text-gray-500 text-base">
                                                            {{ $staff->id_number }}</p>
                                                    </div>
                                                    <!-- Image -->
                                                    <div
                                                        class="relative w-[240px] h-[240px] lg:w-[360px] lg:h-[360px] items-center justify-center my-4 bg-[#0FA3FF]/10 hover:bg-[#0FA3FF]/20 backdrop-blur-lg rounded-md transform transition ease-in-out">
                                                        <img src="{{ Storage::url('images/' . $staff->image) }}"
                                                            class="w-[240px] h-[240px] lg:w-[360px] lg:h-[360px] object-cover rounded-lg border border-gray-300 shadow-sm"
                                                            alt="">
                                                    </div>
                                                    <!-- Progress Bar -->
                                                    <div
                                                        class="w-full bg-[#22A06B]/20 hover:bg-[#22A06B] text-[#22A06B] hover:text-white backdrop-blur-lg shadow-md rounded-md p-2 mb-4 flex items-center justify-center gap-2 transform transition ease-in-out">
                                                        <i class="fa-solid fa-chart-bar fa-lg lg:fa-xl"></i>
                                                        <span class="text-base font-semibold">Perolehan Rating:
                                                            {{-- <span class="font-bold">
                                                                @foreach ($votesByCandidate as $votes)
                                                                    @if ($votes['id_candidate'] == $staff->id)
                                                                        {{ $votes['total_votes'] }}
                                                                    @endif
                                                                @endforeach
                                                            </span> --}}
                                                        </span>
                                                    </div>
                                                    <!-- Action Bar -->
                                                    @if (Auth::user()->role == 'admin')
                                                        <div class="grid grid-cols-3 gap-3">
                                                            <a href="{{ route('staff.mgmt.edit', $staff->uuid) }}">
                                                                <div
                                                                    class="cursor-pointer bg-[#1D7AFC]/20 hover:bg-[#1D7AFC] text-[#1D7AFC] hover:text-white backdrop-blur-lg shadow-md rounded-md p-2 mb-3 flex items-center justify-center gap-2 transform transition ease-in-out">
                                                                    <i class="fa-solid fa-pen-to-square fa-md lg:fa-lg"></i>
                                                                    <span class="text-sm font-semibold">Edit</span>
                                                                </div>
                                                            </a>
                                                            <a href="{{ route('staff.mgmt.preview', $staff->uuid) }}">
                                                                <div
                                                                    class="cursor-pointer bg-[#FFB300]/20 hover:bg-[#FFB300] text-[#E5A100] hover:text-white backdrop-blur-lg shadow-md rounded-md p-2 mb-3 flex items-center justify-center gap-2 transform transition ease-in-out">
                                                                    <i class="fa-solid fa-eye fa-md lg:fa-lg"></i>
                                                                    <span class="text-sm font-semibold">Lihat</span>
                                                                </div>
                                                            </a>
                                                            <div x-data="{ open: false }" class="relative">
                                                                <button @click="open = true"
                                                                    class= "cursor-pointer w-full bg-[#E24A36]/20 hover:bg-[#E24A36] text-[#CD311D] hover:text-white backdrop-blur-lg shadow-md rounded-md p-2 mb-3 flex items-center justify-center gap-2 transform transition ease-in-out">
                                                                    <i class="fa-solid fa-trash fa-md lg:fa-lg"></i>
                                                                    <span class="text-sm font-semibold">Hapus</span>
                                                                </button>
                                                                <div x-show="open" x-cloak
                                                                    class="fixed top-0 left-0 w-full h-full inset-0 bg-black/20 rounded-xl flex justify-center items-center z-50">
                                                                </div>
                                                                <div x-show="open"
                                                                    x-transition:enter="transition ease-out duration-100 transform"
                                                                    x-transition:enter-start="opacity-0 scale-95"
                                                                    x-transition:enter-end="opacity-100 scale-100"
                                                                    x-transition:leave="transition ease-in duration-75 transform"
                                                                    x-transition:leave-start="opacity-100 scale-100"
                                                                    x-transition:leave-end="opacity-0 scale-95"
                                                                    @click.away="open = false" x-cloak
                                                                    class="fixed top-0 left-0 w-full h-full rounded-xl flex justify-center items-center z-50">
                                                                    <div
                                                                        class="p-6 w-[80%] lg:w-[540px] bg-white/90 backdrop-blur-lg border-gray-200 rounded-lg shadow-lg items-center justify-center">
                                                                        <div
                                                                            class= "bg-[#E24A36]/20 backdrop-blur-lg py-2 rounded-lg">
                                                                            <h2
                                                                                class="mb-2 text-xl font-bold text-[#E24A36] text-center px-4 translate-y-1">
                                                                                Hapus
                                                                                Data Staf</h2>
                                                                        </div>
                                                                        <hr
                                                                            class="rounded border-t-2 border-[#B8B8B8]/50 my-6 mx-full">
                                                                        <p
                                                                            class="mb-6 font-medium text-gray-600 text-center">
                                                                            Yakin untuk
                                                                            menghapus yang dipilih? <br> Saat ini memilih
                                                                            data
                                                                            dari:<br><span
                                                                                class="font-semibold text-[#0B8BDB]">({{ $staff->name }})</span>
                                                                        </p>
                                                                        <form
                                                                            action="{{ route('staff.mgmt.delete', $staff->uuid) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <div class="mb-6">
                                                                                <label for="password_confirmation"
                                                                                    class="text-gray-500 font-medium text-xs lg:text-sm">Konfirmasi
                                                                                    Password</label>
                                                                                <div class="relative">
                                                                                    <i
                                                                                        class="fa fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                                                                                    <input
                                                                                        placeholder="Masukkan Password User Ini"
                                                                                        type="password"
                                                                                        name="password_confirmation"
                                                                                        id="password_confirmation"
                                                                                        class="text-sm w-full h-14 pl-12 pr-12 placeholder:text-gray-300 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0FA3FF] transition duration-300 ease-in-out rounded-md shadow-sm"
                                                                                        required autocomplete="off">
                                                                                    <i
                                                                                        class="fa fa-eye absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 cursor-pointer togglePassword"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                class="flex flex-row gap-2 justify-between">
                                                                                <button type="button"
                                                                                    @click="open = false"
                                                                                    class="cursor-pointer px-5 py-2.5 bg-gray-400 hover:bg-gray-500 transform duration-100 rounded-lg">
                                                                                    <span
                                                                                        class="text-white font-semibold">Kembali</span>
                                                                                </button>
                                                                                <button type="submit"
                                                                                    class="cursor-pointer px-5 py-2.5 bg-[#E24A36] hover:bg-[#9D2515] transform duration-100 ease-in-out rounded-lg">
                                                                                    <span
                                                                                        class="text-[white] font-semibold">Hapus</span>
                                                                                </button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- Pagination -->
                            <div class="swiper-pagination relative mt-4"></div>
                            <!-- Custom Navigation Buttons -->
                            <div
                                class="custom-swiper-button-prev absolute left-0 top-1/2 transform -translate-y-1/2 z-10 text-[#0B8BDB] w-10 h-10 rounded-full flex items-center justify-center cursor-pointer">
                                <i class="fa-solid fa-chevron-left"></i>
                            </div>
                            <div
                                class="custom-swiper-button-next absolute right-0 top-1/2 transform -translate-y-1/2 z-10 text-[#0B8BDB] w-10 h-10 rounded-full flex items-center justify-center cursor-pointer">
                                <i class="fa-solid fa-chevron-right"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Desktop Grid View -->
                    <div class="hidden sm:grid px-2 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 md:grid-cols-1 gap-6 mb-8">
                        @foreach ($staffs as $staff)
                            <div class="bg-white/30 backdrop-blur-xl rounded-xl shadow-lg p-6">
                                <div class="flex justify-center items-center">
                                    <div class="flex flex-col">
                                        <!-- Candidate Name and Position -->
                                        <div class="text-center">
                                            <h3
                                                class="text-xl my-1 font-bold text-gray-700 truncate w-full max-w-[320px] mx-auto">
                                                {{ $staff->name }}</h3>
                                            <p class="text-gray-500 text-base">{{ $staff->as_who }}
                                            </p>
                                            <p class="text-gray-500 text-base">{{ $staff->id_number }}
                                            </p>
                                        </div>
                                        <!-- Image -->
                                        <div
                                            class="relative items-center justify-center my-4 bg-[#0FA3FF]/10 hover:bg-[#0FA3FF]/20 backdrop-blur-lg rounded-md hover:scale-103 transform transition duration-100 ease-in-out">
                                            <img src="{{ Storage::url('images/' . $staff->image) }}"
                                                class="w-[320px] h-[320px] lg:w-[320px] lg:h-[320px] object-cover rounded-lg border border-gray-300 shadow-sm"
                                                alt="">
                                        </div>
                                        <!-- Progress Bar -->
                                        <div
                                            class="bg-[#22A06B]/20 hover:bg-[#22A06B] text-[#22A06B] hover:text-white backdrop-blur-lg shadow-md rounded-md p-2 flex items-center justify-center gap-2 transform transition ease-in-out">
                                            <i class="fa-solid fa-chart-bar fa-lg lg:fa-xl"></i>
                                            <span class="text-base font-semibold">Perolehan Rating:
                                                {{-- <span class="font-bold">
                                                    @foreach ($votesByCandidate as $votes)
                                                        @if ($votes['id_candidate'] == $staff->id)
                                                            {{ $votes['total_votes'] }}
                                                        @endif
                                                    @endforeach
                                                </span> --}}
                                            </span>
                                        </div>
                                        <!-- Action Bar -->
                                        @if (Auth::user()->role == 'admin')
                                            <div class="grid grid-cols-3 gap-3 mt-4">
                                                <a href="{{ route('staff.mgmt.edit', $staff->uuid) }}">
                                                    <div
                                                        class="cursor-pointer bg-[#1D7AFC]/20 hover:bg-[#1D7AFC] text-[#1D7AFC] hover:text-white backdrop-blur-lg shadow-md rounded-md p-2 mb-3 flex items-center justify-center gap-2 transform transition ease-in-out">
                                                        <i class="fa-solid fa-pen-to-square fa-md lg:fa-lg"></i>
                                                        <span class="text-sm font-semibold">Edit</span>
                                                    </div>
                                                </a>
                                                <a href="{{ route('staff.mgmt.preview', $staff->uuid) }}">
                                                    <div
                                                        class="cursor-pointer bg-[#FFB300]/20 hover:bg-[#FFB300] text-[#E5A100] hover:text-white backdrop-blur-lg shadow-md rounded-md p-2 mb-3 flex items-center justify-center gap-2 transform transition ease-in-out">
                                                        <i class="fa-solid fa-eye fa-md lg:fa-lg"></i>
                                                        <span class="text-sm font-semibold">Lihat</span>
                                                    </div>
                                                </a>
                                                <div x-data="{ open: false }" class="relative">
                                                    <button @click="open = true"
                                                        class= "cursor-pointer w-full bg-[#E24A36]/20 hover:bg-[#E24A36] text-[#CD311D] hover:text-white backdrop-blur-lg shadow-md rounded-md p-2 mb-3 flex items-center justify-center gap-2 transform transition ease-in-out">
                                                        <i class="fa-solid fa-trash fa-md lg:fa-lg"></i>
                                                        <span class="text-sm font-semibold">Hapus</span>
                                                    </button>
                                                    <div x-show="open" x-cloak
                                                        class="fixed top-0 left-0 w-full h-full inset-0 bg-black/20 rounded-xl flex justify-center items-center z-50">
                                                    </div>
                                                    <div x-show="open"
                                                        x-transition:enter="transition ease-out duration-100 transform"
                                                        x-transition:enter-start="opacity-0 scale-95"
                                                        x-transition:enter-end="opacity-100 scale-100"
                                                        x-transition:leave="transition ease-in duration-75 transform"
                                                        x-transition:leave-start="opacity-100 scale-100"
                                                        x-transition:leave-end="opacity-0 scale-95"
                                                        @click.away="open = false" x-cloak
                                                        class="fixed top-0 left-0 w-full h-full rounded-xl flex justify-center items-center z-50">
                                                        <div
                                                            class="p-6 w-[80%] max-w-[540px] bg-white/90 backdrop-blur-lg border-gray-200 rounded-lg shadow-lg items-center justify-center">
                                                            <div class= "bg-[#E24A36]/20 backdrop-blur-lg py-2 rounded-lg">
                                                                <h2
                                                                    class="mb-2 text-xl font-bold text-[#E24A36] text-center px-4 translate-y-1">
                                                                    Hapus
                                                                    Data Staf</h2>
                                                            </div>
                                                            <hr
                                                                class="rounded border-t-2 border-[#B8B8B8]/50 my-6 mx-full">
                                                            <p class="mb-6 font-medium text-gray-600 text-center">Yakin
                                                                untuk
                                                                menghapus yang dipilih? <br> Saat ini memilih data
                                                                dari:<br><span
                                                                    class="font-semibold text-[#0B8BDB]">({{ $staff->name }})</span>
                                                            </p>
                                                            <form action="{{ route('staff.mgmt.delete', $staff->uuid) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <div class="mb-6">
                                                                    <label for="password_confirmation"
                                                                        class="text-gray-500 font-medium text-xs lg:text-sm">Konfirmasi
                                                                        Password</label>
                                                                    <div class="relative">
                                                                        <i
                                                                            class="fa fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                                                                        <input placeholder="Masukkan Password User Ini"
                                                                            type="password" name="password_confirmation"
                                                                            id="password_confirmation"
                                                                            class="text-sm w-full h-14 pl-12 pr-12 placeholder:text-gray-300 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0FA3FF] transition duration-300 ease-in-out rounded-md shadow-sm"
                                                                            required autocomplete="off">
                                                                        <i
                                                                            class="fa fa-eye absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 cursor-pointer togglePassword"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="flex flex-row gap-2 justify-between">
                                                                    <button type="button" @click="open = false"
                                                                        class="cursor-pointer px-5 py-2.5 bg-gray-400 hover:bg-gray-500 transform duration-100 ease-in-out rounded-lg">
                                                                        <span
                                                                            class="text-white font-semibold">Kembali</span>
                                                                    </button>
                                                                    <button type="submit"
                                                                        class="cursor-pointer px-5 py-2.5 bg-[#E24A36] hover:bg-[#9D2515] transform duration-100 ease-in-out rounded-lg">
                                                                        <span
                                                                            class="text-[white] font-semibold">Hapus</span>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <style>
            /* Hide default Swiper navigation buttons */
            .swiper-button-next,
            .swiper-button-prev {
                display: none;
            }
        </style>

        <script>
            // Alpine.js component for the carousel
            function staffCarousel() {
                return {
                    swiper: null,
                    init() {
                        // Initialize Swiper with custom navigation
                        this.swiper = new Swiper(this.$refs.staffSwiper, {
                            slidesPerView: 1,
                            spaceBetween: 30,
                            loop: true,
                            pagination: {
                                el: '.swiper-pagination',
                                clickable: true,
                            },
                            navigation: {
                                nextEl: '.custom-swiper-button-next',
                                prevEl: '.custom-swiper-button-prev',
                            },
                        });
                    }
                }
            }
        </script>
    @endsection
