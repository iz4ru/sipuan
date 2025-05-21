@extends('admin.layouts.app')

@section('title', 'Update Admin')

@section('content')
    <div class="flex-1 overflow-y-auto px-8 pt-6 pb-6">
        <div class="space-y-6">
            <div class="flex flex-col bg-white/30 backdrop-blur-lg rounded-xl shadow-lg p-6">
                <div class="bg-gradient-to-r from-[#05C1FF]/20 to-[#0FA3FF]/20 rounded-lg shadow-lg p-6">
                    <div class="">
                        <h1 class="text-2xl lg:text-3xl font-bold text-[#0B8BDB] mb-2">Update Data Admin</h1>
                        <p class="text-sm text-[#0B8BDB] lg:text-base">Lihat, perbarui informasi admin yang terdaftar dalam sistem.</p>
                    </div>
                </div>
                <hr class="rounded border-t-2 border-[#B8B8B8]/50 my-8 mx-6">

                <div class="flex flex-col items-center lg:items-start lg:text-left">
                    <!-- Teks dengan ikon -->
                    <div class="flex items-center gap-2 text-sm lg:text-base text-[#0B8BDB] mb-4">
                        <i class="fa fa-keyboard"></i>
                        <span>Silahkan untuk memasukkan data yang harus diisi.</span>
                    </div>

                    <ul class="text-sm list-disc pl-5 mb-8">
                        <li>Pastikan email tidak sama dengan admin atau panitia lainnya.</li>
                        <li>Pastikan username yang akan diganti tidak sama dengan admin atau panitia lainnya.</li>
                    </ul>

                    <!-- Form Pendaftaran -->
                    <div class="w-full max-w-lg">

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

                        <form action="{{ route('admin.mgmt.update', $user->uuid) }}" method="POST"
                            onsubmit="validateForm(event)">
                            @csrf
                            @method('PUT')
                            <div class="space-y-4">

                                <!-- Name -->
                                <div>
                                    <label for="name" class="text-gray-500 font-medium text-sm">Nama</label>
                                    <div class="relative">
                                        <i class="fa fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                                        <input wire:model="name" placeholder="Masukkan Nama" type="text" name="name"
                                            id="name"
                                            class="text-sm w-full h-14 pl-12 placeholder:text-gray-300 border bg-gray-50 border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0FA3FF] transition duration-300 ease-in-out rounded-md shadow-sm"
                                            required autocomplete="name" value="{{ $user->name }}">
                                    </div>
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="text-gray-500 font-medium text-sm">Email</label>
                                    <div class="relative">
                                        <i
                                            class="fa fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                                        <input wire:model="email" placeholder="Masukkan Email" type="email" name="email"
                                            id="email"
                                            class="text-sm w-full h-14 pl-12 placeholder:text-gray-300 border bg-gray-50 border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0FA3FF] transition duration-300 ease-in-out rounded-md shadow-sm"
                                            required autocomplete="email" value="{{ $user->email }}">
                                    </div>
                                </div>

                                <!-- Username -->
                                <div>
                                    <label for="username" class="text-gray-500 font-medium text-sm">Username</label>
                                    <div class="relative">
                                        <i class="fa fa-id-card absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                                        <input placeholder="Username Akan Diisi Otomatis" type="text" name="username"
                                            id="username"
                                            class="text-sm w-full h-14 pl-12 placeholder:text-gray-300 border bg-gray-50 border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0FA3FF] transition duration-300 ease-in-out rounded-md shadow-sm"
                                            required autocomplete="username" value="{{ $user->username }}"  >
                                    </div>
                                </div>

                                <!-- Role -->
                                <div>
                                    <label for="role" class="text-gray-500 font-medium text-sm">Pilih Role</label>
                                    <div class="relative">
                                        <i
                                            class="fa fa-user-shield absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                                        <select placeholder="Pilih Role Anda" type="select" name="role" id="role"
                                            class="text-sm w-full h-14 pl-12 pr-12 text-gray-500 placeholder:text-gray-300 border bg-gray-100 border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0FA3FF] transition duration-300 ease-in-out rounded-md shadow-sm"
                                            required autocomplete="off" disabled
                                            onchange="this.classList.remove('text-gray-300'); this.classList.add('text-gray-700');">
                                            <option value="" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Update Admin Button -->
                                <div class="mt-6 w-full flex flex-column gap-4">
                                    <a href="{{ route('admin.mgmt') }}" class="mt-8 w-full px-6 py-4 bg-gray-400/80 hover:bg-gray-500/80 text-white rounded-lg transition-colors flex items-center justify-center gap-3">
                                        <span class="font-semibold">Kembali</span>
                                    </a>
                                    <button type="submit"
                                        class="cursor-pointer mt-8 w-full px-6 py-4 bg-gradient-to-r from-[#05C1FF] to-[#0FA3FF] hover:bg-gradient-r hover:from-[#0092C2] hover:to-[#006BAD] text-white rounded-lg transition-colors flex items-center justify-center gap-3">
                                        <span class="font-semibold">Simpan</span>
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        @endsection
