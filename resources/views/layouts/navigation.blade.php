<!-- Navbar -->
<nav
    class="fixed left-0 w-full sm:top-5 sm:left-1/2 sm:transform sm:-translate-x-1/2 sm:w-11/12 sm:max-w-7xl bg-white/30 backdrop-blur-lg sm:rounded-xl px-4 py-4 lg:py-2 flex justify-between items-center shadow-lg z-50">
    <!-- Logo -->
    <div class="flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#05C1FF" class="size-6">
            <path fill-rule="evenodd"
                d="M9 4.5a.75.75 0 0 1 .721.544l.813 2.846a3.75 3.75 0 0 0 2.576 2.576l2.846.813a.75.75 0 0 1 0 1.442l-2.846.813a3.75 3.75 0 0 0-2.576 2.576l-.813 2.846a.75.75 0 0 1-1.442 0l-.813-2.846a3.75 3.75 0 0 0-2.576-2.576l-2.846-.813a.75.75 0 0 1 0-1.442l2.846-.813A3.75 3.75 0 0 0 7.466 7.89l.813-2.846A.75.75 0 0 1 9 4.5ZM18 1.5a.75.75 0 0 1 .728.568l.258 1.036c.236.94.97 1.674 1.91 1.91l1.036.258a.75.75 0 0 1 0 1.456l-1.036.258c-.94.236-1.674.97-1.91 1.91l-.258 1.036a.75.75 0 0 1-1.456 0l-.258-1.036a2.625 2.625 0 0 0-1.91-1.91l-1.036-.258a.75.75 0 0 1 0-1.456l1.036-.258a2.625 2.625 0 0 0 1.91-1.91l.258-1.036A.75.75 0 0 1 18 1.5ZM16.5 15a.75.75 0 0 1 .712.513l.394 1.183c.15.447.5.799.948.948l1.183.395a.75.75 0 0 1 0 1.422l-1.183.395c-.447.15-.799.5-.948.948l-.395 1.183a.75.75 0 0 1-1.422 0l-.395-1.183a1.5 1.5 0 0 0-.948-.948l-1.183-.395a.75.75 0 0 1 0-1.422l1.183-.395c.447-.15.799-.5.948-.948l.395-1.183A.75.75 0 0 1 16.5 15Z"
                clip-rule="evenodd" />
        </svg>
        <span
            class="bg-gradient-to-r from-[#05C1FF] to-[#0FA3FF] inline-block text-transparent bg-clip-text font-black text-xl sm:text-2xl ml-2">SIPUAN</span>
    </div>

    <!-- Navigation Button Group -->
    <div class="flex gap-2 sm:gap-2 ml-auto">
        @if (!Request::is('staff', 'rate'))
            <a href="#catalog"
                class="button bg-[#D9D9D9]/40 text-[#B8B8B8] border-2 border-[#B8B8B8] justify-center backdrop-blur-lg px-6 sm:px-10 py-3 sm:py-3 rounded-md text-xs sm:text-sm font-semibold hover:bg-[#E0E0E0] transition-colors flex items-center gap-1 sm:gap-2">
                Bidang
                <i class="fa-solid fa-chevron-right fa-sm sm:fa-md"></i>
            </a>

            <a href="{{ route('admin.login') }}"
                class="button bg-gradient-to-r from-[#05C1FF] to-[#0FA3FF] text-[#FAFAFA] justify-center px-6 sm:px-10 py-3 sm:py-3 rounded-md text-xs sm:text-sm font-bold hover:bg-gradient-r hover:from-[#0092C2] hover:to-[#006BAD] transition-colors flex items-center gap-1 sm:gap-2">
                Masuk
                <i class="fa-solid fa-chevron-right fa-sm sm:fa-md"></i>
            </a>
        @else
            {{-- Element kosong biar tinggi tetap terjaga --}}
            <div class="h-[44px] sm:h-[48px]"></div>
        @endif
    </div>
</nav>
