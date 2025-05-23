@extends('admin.layouts.app')

@section('title', 'Update Staf')

@section('content')
    <div class="flex-1 overflow-y-auto px-8 pt-6 pb-6">
        <div class="space-y-6">
            <div class="flex flex-col bg-white/30 backdrop-blur-lg rounded-xl shadow-lg p-6">
                <div class="bg-gradient-to-r from-[#05C1FF]/20 to-[#0FA3FF]/20 rounded-lg shadow-lg p-6">
                    <div class="">
                        <h1 class="text-2xl lg:text-3xl font-bold text-[#0B8BDB] mb-2">Update Data Staf</h1>
                        <p class="text-sm text-[#0B8BDB] lg:text-base">Masukkan informasi staf terbaru dengan lengkap dan
                            akurat untuk memperbarui data yang ada.</p>
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
                        <li>Pastikan email tidak sama dengan staf lainnya.</li>
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

                        <form action="{{ route('staff.mgmt.update', $staff->uuid) }}" method="POST" onsubmit="validateForm(event)"
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
                                            id="name" value="{{ $staff->name }}"
                                            class="text-sm w-full h-14 pl-12 placeholder:text-gray-300 border bg-gray-50 border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0FA3FF] transition duration-300 ease-in-out rounded-md shadow-sm"
                                            required autocomplete="name">
                                    </div>
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="text-gray-500 font-medium text-sm">Email</label>
                                    <div class="relative">
                                        <i
                                            class="fa fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                                        <input wire:model="email" placeholder="Masukkan Email" type="email" name="email"
                                            id="email" value="{{ $staff->email }}"
                                            class="text-sm w-full h-14 pl-12 placeholder:text-gray-300 border bg-gray-50 border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0FA3FF] transition duration-300 ease-in-out rounded-md shadow-sm"
                                            required autocomplete="email">
                                    </div>
                                </div>

                                <!-- Phone Number -->
                                <div>
                                    <label for="phone" class="text-gray-500 font-medium text-sm">Nomor Telepon</label>
                                    <div class="relative">
                                        <i class="fa fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                                        <input wire:model="phone" placeholder="Masukkan Nomor Telepon" type="phone"
                                            name="phone" id="phone" value="{{ $staff->phone }}"
                                            class="text-sm w-full h-14 pl-12 placeholder:text-gray-300 border bg-gray-50 border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0FA3FF] transition duration-300 ease-in-out rounded-md shadow-sm"
                                            required autocomplete="phone">
                                    </div>
                                </div>

                                <!-- Photo -->
                                <div x-data="{ preview: '{{ $staff->image ? asset('storage/images/' . $staff->image) : '' }}' }" x-init="preview: '{{ $staff->image ? asset('storage/images/' . $staff->image) : '' }}'">
                                    <label for="image" class="text-gray-500 font-medium text-sm">Foto</label>

                                    <!-- Preview Image -->
                                    <div class="mb-3">
                                        <template x-if="preview">
                                            <img :src="preview"
                                                class="w-[360px] h-[360px] object-cover border border-gray-300 shadow-sm">
                                        </template>
                                    </div>

                                    <!-- File Input -->
                                    <div
                                        class="relative flex items-center border bg-gray-50 border-gray-300 rounded-md shadow-sm">
                                        <i class="fa fa-camera text-gray-300 absolute left-4"></i>
                                        <input type="file" name="image" id="image" accept="image/*"
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

                                <!-- Position -->
                                <div>
                                    <label for="position_id" class="text-gray-500 font-medium text-sm">Pilih Posisi Bidang</label>
                                    <div class="relative">
                                        <i class="fa fa-briefcase absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                                        <select placeholder="Pilih Posisi" type="select" name="position_id"
                                            id="position_id"
                                            class="text-sm w-full h-14 pl-12 pr-12 placeholder:text-gray-300 border bg-gray-50 border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0FA3FF] transition duration-300 ease-in-out rounded-md shadow-sm"
                                            required autocomplete="off">
                                            @if ($positions->count() <= 0)
                                                <option value="" disabled selected>Tidak Ada Data Posisi, Buat
                                                    Terlebih Dahulu!</option>
                                            @endif
                                            <option value="" disabled selected>Pilih Posisi</option>
                                            @foreach ($positions as $position)
                                                <option value="{{ $position->id }}"
                                                    {{ $staff->position_id == $position->id ? 'selected' : '' }}>
                                                    {{ $position->position_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- ID Number -->
                                <div>
                                    <label for="id_number" class="text-gray-500 font-medium text-sm">Nomor Identitas</label>
                                    <div class="relative">
                                        <i
                                            class="fa fa-id-card-clip absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                                        <input placeholder="Masukkan Nomor Identitas" type="text" name="id_number"
                                            id="id_number" value="{{ $staff->id_number }}"
                                            class="text-sm w-full h-14 pl-12 placeholder:text-gray-300 border bg-gray-50 border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0FA3FF] transition duration-300 ease-in-out rounded-md shadow-sm"
                                            required autocomplete="id_number">
                                    </div>
                                </div>

                                <!-- Sex -->
                                <div>
                                    <label for="sex" class="text-gray-500 font-medium text-sm">Pilih Jenis
                                        Kelamin</label>
                                    <div class="relative">
                                        <i
                                            class="fa fa-venus-mars absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                                        <select placeholder="Pilih Jenis Kelamin" type="select" name="sex"
                                            id="sex"
                                            class="text-sm w-full h-14 pl-12 pr-12 text-gray-300 placeholder:text-gray-300 border bg-gray-50 border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0FA3FF] transition duration-300 ease-in-out rounded-md shadow-sm"
                                            required autocomplete="off"
                                            onchange="this.classList.remove('text-gray-300'); this.classList.add('text-gray-700');">
                                            <option value="" disabled @selected(old('sex', $staff->sex) === null)>Pilih Jenis
                                                Kelamin</option>
                                            <option value="pria" @selected(old('sex', $staff->sex) === 'pria')>Pria</option>
                                            <option value="wanita" @selected(old('sex', $staff->sex) === 'wanita')>Wanita</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Update Admin Button -->
                                <div class="mt-6 w-full flex flex-column gap-4">
                                    <a href="{{ route('staff.mgmt') }}"
                                        class="mt-8 w-full px-6 py-4 bg-gray-400/80 hover:bg-gray-500/80 text-white rounded-lg transition-colors flex items-center justify-center gap-3">
                                        <span class="font-semibold">Kembali</span>
                                    </a>
                                    <button type="submit"
                                        class="cursor-pointer mt-8 w-full px-6 py-4 bg-gradient-to-r from-[#05C1FF] to-[#0FA3FF] hover:bg-gradient-r hover:from-[#0092C2] hover:to-[#006BAD] text-white rounded-lg transition-colors flex items-center justify-center gap-3">
                                        <span class="font-semibold">Perbarui</span>
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
