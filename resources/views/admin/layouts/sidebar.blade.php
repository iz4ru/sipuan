<!-- resources/views/admin/layouts/sidebar.blade.php -->

<!-- Sidebar -->
<div class="flex h-screen relative z-10">
    <!-- Sidebar with Glassmorphism - Fixed position -->
    <div id="sidebar"
        class="fixed w-72 select-none h-screen rounded-xl bg-white-30 backdrop-blur-lg text-white flex flex-col shadow-lg z-30 transform transition-transform duration-300 ease-in-out sidebar-cloak">
        <!-- Logo -->
        <div class="p-10 flex items-center border-b border-white/10">
            <div class="w-10 h-10 flex items-center justify-center rounded">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#05C1FF" class="size-8">
                    <path fill-rule="evenodd"
                        d="M9 4.5a.75.75 0 0 1 .721.544l.813 2.846a3.75 3.75 0 0 0 2.576 2.576l2.846.813a.75.75 0 0 1 0 1.442l-2.846.813a3.75 3.75 0 0 0-2.576 2.576l-.813 2.846a.75.75 0 0 1-1.442 0l-.813-2.846a3.75 3.75 0 0 0-2.576-2.576l-2.846-.813a.75.75 0 0 1 0-1.442l2.846-.813A3.75 3.75 0 0 0 7.466 7.89l.813-2.846A.75.75 0 0 1 9 4.5ZM18 1.5a.75.75 0 0 1 .728.568l.258 1.036c.236.94.97 1.674 1.91 1.91l1.036.258a.75.75 0 0 1 0 1.456l-1.036.258c-.94.236-1.674.97-1.91 1.91l-.258 1.036a.75.75 0 0 1-1.456 0l-.258-1.036a2.625 2.625 0 0 0-1.91-1.91l-1.036-.258a.75.75 0 0 1 0-1.456l1.036-.258a2.625 2.625 0 0 0 1.91-1.91l.258-1.036A.75.75 0 0 1 18 1.5ZM16.5 15a.75.75 0 0 1 .712.513l.394 1.183c.15.447.5.799.948.948l1.183.395a.75.75 0 0 1 0 1.422l-1.183.395c-.447.15-.799.5-.948.948l-.395 1.183a.75.75 0 0 1-1.422 0l-.395-1.183a1.5 1.5 0 0 0-.948-.948l-1.183-.395a.75.75 0 0 1 0-1.422l1.183-.395c.447-.15.799-.5.948-.948l.395-1.183A.75.75 0 0 1 16.5 15Z"
                        clip-rule="evenodd" />
                </svg>

                <!-- Logo Image -->
                {{-- <img src="{{ asset('img/logo.png') }}" alt="Wevoting Logo" class="w-8 h-8"> --}} <!-- Change this for image logo-->
            </div>
            <span
            class="bg-gradient-to-r from-[#05C1FF] to-[#0FA3FF] inline-block text-transparent bg-clip-text font-black text-4xl ml-2">SIPUAN</span>
        </div>
