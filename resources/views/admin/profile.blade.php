@extends('admin.layouts.app')

@section('title', 'Profil')

@section('content')
    <div class="flex-1 overflow-y-auto px-8 pt-6 pb-6">
        <div class="space-y-6">
            <div class="flex flex-col bg-white/30 backdrop-blur-lg rounded-xl shadow-lg p-6">
                <div class="bg-gradient-to-r from-[#05C1FF]/20 to-[#0FA3FF]/20 rounded-lg shadow-lg p-6">
                    <div class="">
                        <h1 class="text-2xl lg:text-3xl font-bold text-[#0B8BDB] mb-2">Profil Anda</h1>
                        <p class="text-sm text-[#0B8BDB] lg:text-base">Lihat atau perbarui informasi anda.</p>
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
                        <li>Pastikan email tidak sama dengan admin lainnya.</li>
                        <li>Pastikan username yang akan diganti tidak sama dengan admin lainnya.</li>
                        <li>Pastikan besar file foto profil anda tidak lebih besar dari 2MB.</li>
                    </ul>

                    <!-- Form Update -->
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

                        <form action="{{ route('admin.profile.update', Auth::user()->uuid) }}" method="POST"
                            enctype="multipart/form-data">
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
                                            required autocomplete="name" value="{{ Auth::user()->name }}">
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
                                            required autocomplete="email" value="{{ Auth::user()->email }}">
                                    </div>
                                </div>

                                <!-- Username -->
                                <div>
                                    <label for="username" class="text-gray-500 font-medium text-sm">Username</label>
                                    <div class="relative">
                                        <i class="fa fa-id-card absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                                        <input placeholder="Masukkan Username Anda" type="text" name="username"
                                            id="username"
                                            class="text-sm w-full h-14 pl-12 placeholder:text-gray-300 border bg-gray-50 border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0FA3FF] transition duration-300 ease-in-out rounded-md shadow-sm"
                                            required autocomplete="username" value="{{ Auth::user()->username }}">
                                    </div>
                                </div>

                                <!-- Profile Photo -->
                                <div x-data="{ preview: '{{ $user->avatar ? asset('storage/avatars/' . $user->avatar) : '' }}' }" x-init="preview = '{{ $user->avatar ? asset('storage/avatars/' . $user->avatar) : '' }}'">
                                    <label for="avatar" class="text-gray-500 font-medium text-sm">Foto Profil</label>

                                    <!-- Preview Image -->
                                    <div class="mb-3">
                                        <template x-if="preview">
                                            <img :src="preview"
                                                class="w-24 h-24 object-cover rounded-full border bg-gray-50 border-gray-300 shadow-sm">
                                        </template>
                                    </div>

                                    <!-- File Input -->
                                    <div
                                        class="relative flex items-center border bg-gray-50 border-gray-300 rounded-md shadow-sm">
                                        <i class="fa fa-camera text-gray-300 absolute left-4"></i>
                                        <input type="file" name="avatar" id="avatar" accept="image/*"
                                            @change="let file = $event.target.files[0]; 
                                                    if (file) { 
                                                        let reader = new FileReader(); 
                                                        reader.onload = e => preview = e.target.result; 
                                                        reader.readAsDataURL(file); 
                                                    }"
                                            class="text-sm w-full h-14 pl-12 pr-4 text-gray-500 border-none focus:ring-0
                                                file:mt-2.5 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 
                                                file:bg-gradient-to-r file:from-[#05C1FF] file:to-[#0FA3FF] file:hover:bg-gradient-r file:hover:from-[#0092C2] file:hover:to-[#006BAD] file:text-white file:cursor-pointer file:font-medium">
                                    </div>
                                </div>

                                <!-- Current Password -->
                                <div>
                                    <label for="password" class="text-gray-500 font-medium text-sm">Password</label>
                                    <div class="relative">
                                        <i class="fa fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                                        <input wire:model="password" placeholder="Masukkan Password Untuk Konfirmasi"
                                            type="password" name="current_password" id="current_password"
                                            class="text-sm w-full h-14 pl-12 pr-12 placeholder:text-gray-300 border bg-gray-50 border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0FA3FF] transition duration-300 ease-in-out rounded-md shadow-sm"
                                            required autocomplete="off">
                                        <i
                                            class="fa fa-eye absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 cursor-pointer togglePassword"></i>
                                    </div>
                                </div>

                                {{-- 
                                <!-- Role -->
                                <div>
                                    <label for="role" class="text-gray-500 font-medium text-sm">Pilih Role</label>
                                    <div class="relative">
                                        <i
                                            class="fa fa-user-shield absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
                                        <select placeholder="Pilih Role Anda" type="select" name="role" id="role"
                                            class="text-sm w-full h-14 pl-12 pr-12 text-gray-500 placeholder:text-gray-300 border bg-gray-50 border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0FA3FF] transition duration-300 ease-in-out rounded-md shadow-sm"
                                            required autocomplete="off" 
                                            onchange="this.classList.remove('text-gray-300'); this.classList.add('text-gray-700');">
                                            <option value="admin" {{ Auth::user()->role === 'admin' ? 'selected' : '' }}>
                                                Admin</option>
                                            <option value=""
                                                {{ Auth::user()->role === '' ? 'selected' : '' }}>Panitia</option>
                                        </select>
                                    </div>
                                </div> --}}


                                <!-- Update Admin Button -->
                                <div class="mt-6">
                                    <button type="submit"
                                        class="mt-8 w-full px-6 py-4 bg-gradient-to-r from-[#05C1FF] to-[#0FA3FF] hover:bg-gradient-r hover:from-[#0092C2] hover:to-[#006BAD] transform duration-100 ease-in-out text-white rounded-xl transition-colors flex items-center justify-center gap-3">
                                        <span class="font-semibold">Simpan</span>
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
                <!-- Change Password Admin Button -->
                <div class="flex flex-col items-center lg:items-start lg:text-left w-full max-w-lg">
                    <a href="{{ route('admin.mgmt.edit_password', Auth::user()->uuid) }}"
                        class="mt-4 w-full px-6 py-4 bg-[#FFB300] hover:bg-[#C78D04] text-white rounded-xl transition-colors flex items-center justify-center gap-3">
                        <span class="font-semibold">Ganti Password</span>
                        <i class="fa-solid fa-key"></i>
                    </a>
                </div>
            </div>
        </div>

    @endsection
