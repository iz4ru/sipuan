@extends('admin.layouts.app')

@section('title', 'Dasbor Utama')

@section('content')
    <!-- Dashboard Content - Scrollable -->
    <div class="flex-1 overflow-y-auto px-8 pt-6 pb-6">
        <div class="space-y-6">

            <!-- Alerts -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible relative text-sm py-2 px-4 bg-green-100 text-green-500 border border-green-500 rounded-md opacity-0 transition-opacity duration-150 ease-in-out"
                    role="alert" id="successAlert">
                    <i class="fa fa-circle-check absolute left-4 top-1/2 -translate-y-1/2"></i>
                    <p class="ml-6">{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible relative text-sm py-2 px-4 bg-red-100 text-red-500 border border-red-500 rounded-md opacity-0 transition-opacity duration-150 ease-in-out"
                role="alert" id="errorAlert">
                <i class="fa fa-circle-exclamation absolute left-4 top-1/2 -translate-y-1/2"></i>
                    <ul class="list-none m-0 p-0">
                        @foreach ($errors->all() as $error)
                            <li class="ml-6">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Staf TU -->
                <div class="bg-white/30 backdrop-blur-lg rounded-xl shadow-lg p-6 hover:scale-105 transition-transform duration-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="w-12 h-12 mb-4 bg-[#0FA3FF]/20 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-users fa-xl text-[#0FA3FF]"></i>
                            </div>
                            <h3 class="text-3xl font-bold text-gray-700">40</h3>
                            <p class="text-gray-500 text-sm lg:text-base">Total Staf</p>
                        </div>
                    </div>
                </div>

                <!-- Total Pemberian Rating -->
                <div class="bg-white/30 backdrop-blur-lg rounded-xl shadow-lg p-6 hover:scale-105 transition-transform duration-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="w-12 h-12 mb-4 bg-[#0FA3FF]/20 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-hand-holding-hand fa-xl text-[#0FA3FF]"></i>
                            </div>
                            <h3 class="text-3xl font-bold text-gray-700">101</h3>
                            <p class="text-gray-500 text-sm lg:text-base">Total Pemberian Rating</p>
                        </div>
                    </div>
                </div>

                <!-- Total Rata-rata Rating Staf -->
                <div class="bg-white/30 backdrop-blur-lg rounded-xl shadow-lg p-6 hover:scale-105 transition-transform duration-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="w-12 h-12 mb-4 bg-[#0FA3FF]/20 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-star fa-xl text-[#0FA3FF]"></i>
                            </div>
                            <h3 class="text-3xl font-bold text-gray-700">4.4</h3>
                            <p class="text-gray-500 text-sm lg:text-base">Total Rata-rata Rating Staf</p>
                        </div>
                    </div>
                </div>
                
                <!-- Total Komentar Masuk -->
                <div class="bg-white/30 backdrop-blur-lg rounded-xl shadow-lg p-6 hover:scale-105 transition-transform duration-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="w-12 h-12 mb-4 bg-[#0FA3FF]/20 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-message fa-xl text-[#0FA3FF]"></i>
                            </div>
                            <h3 class="text-3xl font-bold text-gray-700">209</h3>
                            <p class="text-gray-500 text-sm lg:text-base">Total Komentar Masuk</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    @endsection
