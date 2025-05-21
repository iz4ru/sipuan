<!-- resources/views/admin/layouts/header.blade.php -->

<!-- Header -->
<header class="sticky w-full top-0 z-20">
    <div class="px-8 pt-6">
        <div
            class="bg-white/30 backdrop-blur-lg rounded-xl shadow-lg p-3 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <button class="cursor-pointer ml-2 text-gray-600 hover:text-gray-800" id="sidebarToggle">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h1 class="text-base lg:text-xl font-bold text-gray-700">@yield('title', 'Admin')</h1>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-right">
                    <p class="font-medium text-sm lg:text-base text-gray-700 break-words">
                        {{ Auth::user()->name }}</p>
                    <p class="text-xs lg:text-sm text-gray-500">{{ ucwords(Auth::user()->role) }}</p>
                </div>
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="cursor-pointer mr-2 w-10 h-10 bg-gray-200 rounded-full overflow-hidden">
                        <img src="{{ Storage::url('avatars/' . Auth::user()->avatar) }}" alt="Profile"
                        class="w-full h-full object-cover"
                        onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0FA3FF&color=fff'">
                    </button>
                    <!-- Dropdown Menu -->
                    <div x-show="open"
                    x-transition:enter="transition ease-out duration-100 transform"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75 transform"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    @click.away="open = false" 
                    x-cloak
                        class="absolute backdrop-blur-lg right-0 w-48 bg-[#FAFAFA]/90 shadow-lg rounded-lg p-2 z-50 transition transisiton-transform duration-300 ease-in-out">
                        <div class="">
                            <!-- Muat Profil User yang Ada Pada Session -->
                            <a href="{{ route('admin.profile', Auth::user()->uuid) }}" 
                                class="flex items-center gap-4 w-full rounded-md px-4 py-2 text-gray-500 hover:bg-gray-200">
                                <i class="fa-solid fa-user text-gray-500 text-md"></i>
                                <span>Profil</span>
                            </a>
                        </div>
                        <div class="">
                            <form action="{{ route('admin.logout') }}" method="POST"
                                onsubmit="validateForm(event)">
                                @csrf
                                <button action="submit"
                                    class="cursor-pointer flex items-center gap-4 w-full rounded-md px-4 py-2 text-gray-500 hover:bg-gray-200">
                                    <i class="fa-solid fa-right-from-bracket text-gray-500 text-md"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>