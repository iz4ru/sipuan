@extends('layouts.app')

@section('title', 'SIPUAN - Login')

<body class="bg-gradient-to-b from-[#FAFAFA] from-50% to-[#ECECEC] overflow-x-hidden">
    <div class="flex-1 flex flex-col">
        <div class="p-6">
            <div class="flex items-center gap-6 px-8 py-4">
                <a href="/" class="text-gray-600 hover:text-gray-800 transition-colors items-center flex gap-2">
                    <i class="fa-solid fa-chevron-left"></i>
                    <span class="text-sm font-semibold">Kembali</span>
                </a>
            </div>
        </div>

        <div class="flex-1 flex items-center justify-center transform px-4 py-8">
            <div class="w-full max-w-sm">
                <div class="flex flex-col -translate-y-4 items-center justify-center gap-8">
                    <div class="flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#05C1FF" class="size-6">
                            <path fill-rule="evenodd"
                                d="M9 4.5a.75.75 0 0 1 .721.544l.813 2.846a3.75 3.75 0 0 0 2.576 2.576l2.846.813a.75.75 0 0 1 0 1.442l-2.846.813a3.75 3.75 0 0 0-2.576 2.576l-.813 2.846a.75.75 0 0 1-1.442 0l-.813-2.846a3.75 3.75 0 0 0-2.576-2.576l-2.846-.813a.75.75 0 0 1 0-1.442l2.846-.813A3.75 3.75 0 0 0 7.466 7.89l.813-2.846A.75.75 0 0 1 9 4.5ZM18 1.5a.75.75 0 0 1 .728.568l.258 1.036c.236.94.97 1.674 1.91 1.91l1.036.258a.75.75 0 0 1 0 1.456l-1.036.258c-.94.236-1.674.97-1.91 1.91l-.258 1.036a.75.75 0 0 1-1.456 0l-.258-1.036a2.625 2.625 0 0 0-1.91-1.91l-1.036-.258a.75.75 0 0 1 0-1.456l1.036-.258a2.625 2.625 0 0 0 1.91-1.91l.258-1.036A.75.75 0 0 1 18 1.5ZM16.5 15a.75.75 0 0 1 .712.513l.394 1.183c.15.447.5.799.948.948l1.183.395a.75.75 0 0 1 0 1.422l-1.183.395c-.447.15-.799.5-.948.948l-.395 1.183a.75.75 0 0 1-1.422 0l-.395-1.183a1.5 1.5 0 0 0-.948-.948l-1.183-.395a.75.75 0 0 1 0-1.422l1.183-.395c.447-.15.799-.5.948-.948l.395-1.183A.75.75 0 0 1 16.5 15Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span
                            class="bg-gradient-to-r from-[#05C1FF] to-[#0FA3FF] inline-block text-transparent bg-clip-text font-black text-xl sm:text-2xl ml-2">SIPUAN</span>
                    </div>
                    <div class="bg-white/30 backdrop-blur-lg rounded-xl shadow-lg p-8 w-full">
                        <div class="flex flex-col items-center justify-center gap-2 mb-6">
                            <p class="text-gray-700 text-center font-bold text-3xl">Selamat Datang!</p>
                            <p class="text-gray-500 text-center">Masuk ke akun <span class="font-bold">SIPUAN</span>
                                Anda</p>
                        </div>

                        <!-- Login Form -->
                        <div class="">
                            <form action="{{ route('admin.login') }}" method="POST" onsubmit="validateForm(event)">
                                @csrf
                                <div class="space-y-4">
                                    <div class="relative w-full">
                                        <i
                                            class="fa fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                                        <input placeholder="Masukkan Email" type="email" name="email" id="email" value="{{ old('email') }}"
                                            class="text-sm w-full h-14 pl-12 placeholder:text-gray-300 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0FA3FF] transition duration-300 ease-in-out rounded-md shadow-sm"
                                            required autofocus autocomplete="email">
                                    </div>
                                    <div class="relative w-full">
                                        <i
                                            class="fa fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                                        <input placeholder="Masukkan Password" type="password" name="password"
                                            id="password"
                                            class="text-sm w-full h-14 pl-12 pr-12 placeholder:text-gray-300 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0FA3FF] transition duration-300 ease-in-out rounded-md shadow-sm"
                                            required autocomplete="off">
                                        <i class="fa fa-eye absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 cursor-pointer"
                                            id="togglePassword"></i>
                                    </div>

                                <!-- Forgot Password -->
                                <div
                                    class="space-y-4 mt-2 text-sm text-right text-[#05C1FF] hover:text-[#0FA3FF] hover:underline">
                                    <a href="{{ route('admin.login') }}">Lupa Password?</a>
                                </div>

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

                                    <script>
                                        const passwordInput = document.getElementById("password");
                                        const togglePassword = document.getElementById("togglePassword");

                                        togglePassword.addEventListener("click", function() {
                                            if (passwordInput.type === "password") {
                                                passwordInput.type = "text";
                                                this.classList.replace("fa-eye", "fa-eye-slash");
                                            } else {
                                                passwordInput.type = "password";
                                                this.classList.replace("fa-eye-slash", "fa-eye");
                                            }
                                        });
                                    </script>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', () => {
                                            // Fungsi untuk menangani animasi alert
                                            const handleAlertAnimation = (alertId, duration = 2000, transitionDuration = 300) => {
                                                const alert = document.getElementById(alertId);
                                                if (alert) {
                                                    // Fade in
                                                    setTimeout(() => {
                                                        alert.classList.remove('opacity-0');
                                                        alert.classList.add('opacity-100');
                                                    }, 100); // Delay kecil untuk memastikan DOM siap

                                                    // Auto-close setelah durasi tertentu
                                                    setTimeout(() => {
                                                        alert.classList.remove('opacity-100');
                                                        alert.classList.add('opacity-0');
                                                        setTimeout(() => alert.remove(),
                                                            transitionDuration); // Hapus setelah transisi selesai
                                                    }, duration);
                                                }
                                            };

                                            // Terapkan animasi untuk errorAlert dan successAlert
                                            handleAlertAnimation('errorAlert', 2000, 150);
                                            handleAlertAnimation('successAlert', 2000, 150);
                                        });
                                    </script>
                                </div>

                                {{-- <!-- Register First Admin Account -->
                                @if (!$adminExists)
                                    <div class="space-y-4 mt-4">
                                        <a href="{{ route('register.admin') }}" 
                                        class="flex items-center justify-center w-full px-6 py-4 bg-[#22A06B] hover:bg-[#1A754E] text-white rounded-xl transition-colors">
                                            <div class="text-center flex items-center gap-3">
                                                <span class="font-semibold">Registrasi Admin</span>
                                                <i class="fa-solid fa-user-tie"></i>
                                            </div>
                                        </a>
                                    </div>
                                @endif --}}

                                <!-- Login Buttons -->
                                <div class="space-y-4 mt-4">
                                    <button type="submit"
                                        class="cursor-pointer flex items-center justify-center w-full px-6 py-4 bg-gradient-to-r from-[#05C1FF] to-[#0FA3FF] text-[#FAFAFA] hover:bg-gradient-r hover:from-[#0092C2] hover:to-[#006BAD] rounded-lg transition-colors">
                                        <div class="text-center flex items-center gap-3">
                                            <span class="font-semibold">Masuk</span>
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </div>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <footer>
                        <p class="text-gray-500 text-sm"><span class="font-bold">© {{ date('Y') }} SIPUAN
                                &bull;</span> All rights reserved.</p>
                    </footer>
                </div>
            </div>
        </div>
    </div>
</body>
