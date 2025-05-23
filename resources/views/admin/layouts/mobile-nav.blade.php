<!-- resources/views/admin/layouts/mobile-nav.blade.php -->
<div class="mobile-nav fixed top-0 left-0 w-full z-30 bg-white/30 backdrop-blur-lg shadow-lg">
    <div class="px-4 py-3 flex justify-between items-center">
        <div class="flex items-center">
            <div class="w-8 h-8 flex items-center justify-center rounded">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#05C1FF" class="size-6">
                    <path fill-rule="evenodd"
                        d="M9 4.5a.75.75 0 0 1 .721.544l.813 2.846a3.75 3.75 0 0 0 2.576 2.576l2.846.813a.75.75 0 0 1 0 1.442l-2.846.813a3.75 3.75 0 0 0-2.576 2.576l-.813 2.846a.75.75 0 0 1-1.442 0l-.813-2.846a3.75 3.75 0 0 0-2.576-2.576l-2.846-.813a.75.75 0 0 1 0-1.442l2.846-.813A3.75 3.75 0 0 0 7.466 7.89l.813-2.846A.75.75 0 0 1 9 4.5ZM18 1.5a.75.75 0 0 1 .728.568l.258 1.036c.236.94.97 1.674 1.91 1.91l1.036.258a.75.75 0 0 1 0 1.456l-1.036.258c-.94.236-1.674.97-1.91 1.91l-.258 1.036a.75.75 0 0 1-1.456 0l-.258-1.036a2.625 2.625 0 0 0-1.91-1.91l-1.036-.258a.75.75 0 0 1 0-1.456l1.036-.258a2.625 2.625 0 0 0 1.91-1.91l.258-1.036A.75.75 0 0 1 18 1.5ZM16.5 15a.75.75 0 0 1 .712.513l.394 1.183c.15.447.5.799.948.948l1.183.395a.75.75 0 0 1 0 1.422l-1.183.395c-.447.15-.799.5-.948.948l-.395 1.183a.75.75 0 0 1-1.422 0l-.395-1.183a1.5 1.5 0 0 0-.948-.948l-1.183-.395a.75.75 0 0 1 0-1.422l1.183-.395c.447-.15.799-.5.948-.948l.395-1.183A.75.75 0 0 1 16.5 15Z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <span class="bg-gradient-to-r from-[#05C1FF] to-[#0FA3FF] inline-block text-transparent bg-clip-text font-black text-2xl ml-2">SIPUAN</span>
        </div>
        <div class="flex items-center gap-3">
            <div class="text-right mr-2">
                <p class="font-medium text-sm text-gray-700 break-words">
                    {{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500">{{ ucwords(Auth::user()->role) }}</p>
            </div>
            <button id="mobileMenuToggle" class="cursor-pointer text-gray-600 hover:text-gray-800">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
        </div>
    </div>
    
    <!-- Mobile Navigation Menu -->
    <div id="mobileNavMenu" class="mobile-nav-menu bg-white/90 backdrop-blur-lg shadow-lg">
        @if (Auth::user()->role == 'admin')
            <nav class="py-2">
                <ul class="px-4">
                    <li class="py-2 border-b border-gray-100">
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center gap-3 {{ request()->routeIs('dashboard') ? 'text-[#0FA3FF] font-bold' : 'text-gray-700' }}">
                            <i class="fa-solid fa-home"></i>
                            <span>Dasbor Utama</span>
                        </a>
                    </li>
                    <li class="py-2 border-b border-gray-100">
                        <a href="{{ route('admin.mgmt') }}" 
                           class="flex items-center gap-3 {{ request()->routeIs(['admin.mgmt', 'admin.mgmt.create', 'admin.mgmt.edit', 'admin.mgmt.edit_password']) ? 'text-[#0FA3FF] font-bold' : 'text-gray-700' }}">
                            <i class="fa-solid fa-users-gear"></i>
                            <span>Manajemen Admin</span>
                        </a>
                    </li>
                    <li class="py-2 border-b border-gray-100">
                        <a href="{{ route('staff.mgmt') }}" 
                           class="flex items-center gap-3 {{ request()->routeIs(['staff.mgmt', 'staff.mgmt.create']) ? 'text-[#0FA3FF] font-bold' : 'text-gray-700' }}">
                            <i class="fa-solid fa-user-group"></i>
                            <span>Manajemen Staf</span>
                        </a>
                    </li>
                    <li class="py-2 border-b border-gray-100">
                        <a href="{{ route('position') }}" 
                           class="flex items-center gap-3 {{ request()->routeIs(['position', 'position.edit']) ? 'text-[#0FA3FF] font-bold' : 'text-gray-700' }}">
                            <i class="fa-solid fa-list"></i>
                            <span>Data Posisi</span>
                        </a>
                    </li>
                    <li class="py-2 border-b border-gray-100">
                        <a href="{{ route('admin.logs') }}" 
                           class="flex items-center gap-3 {{ request()->routeIs('admin.logs') ? 'text-[#0FA3FF] font-bold' : 'text-gray-700' }}">
                            <i class="fa-solid fa-history"></i>
                            <span>Log Admin</span>
                        </a>
                    </li>
                    <li class="py-2">
                        <a href="{{ route('admin.profile', Auth::user()->uuid) }}" 
                           class="flex items-center gap-3 text-gray-700">
                            <i class="fa-solid fa-user"></i>
                            <span>Profil</span>
                        </a>
                    </li>
                    <li class="py-2">
                        <form action="{{ route('admin.logout') }}" method="POST" onsubmit="validateForm(event)">
                            @csrf
                            <button action="submit" class="flex items-center gap-3 text-gray-700 w-full text-left">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        @endif
    </div>
</div>

<!-- Spacer to prevent content from being hidden under the fixed navbar -->
<div class="h-16 md:hidden"></div>