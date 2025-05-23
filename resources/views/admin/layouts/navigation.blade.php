<!-- resources/views/admin/layouts/navigation.blade.php -->

<!-- Navigation -->
@if (Auth::user()->role == 'admin')
    <nav class="flex-1 overflow-y-auto">
        <ul class="">
            <li>
                <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')"
                    class="flex items-center gap-3 px-6 py-3 border-white">
                    <i class="fa-solid fa-home"></i>
                    <span class="font-semibold">Dasbor Utama</span>
                </x-nav-link>
            </li>
            <li>
                <x-nav-link href="{{ route('admin.mgmt') }}" :active="request()->routeIs([
                    'admin.mgmt',
                    'admin.mgmt.create',
                    'admin.mgmt.edit',
                    'admin.mgmt.edit_password',
                ])"
                    class="flex items-center gap-3 px-6 py-3 border-white">
                    <i class="fa-solid fa-users-gear"></i>
                    <span class="font-semibold">Manajemen Admin</span>
                </x-nav-link>
            </li>
            <li>
                <x-nav-link href="{{ route('staff.mgmt') }}" :active="request()->routeIs(['staff.mgmt', 'staff.mgmt.create'])"
                    class="flex items-center gap-3 px-6 py-3 border-white">
                    <i class="fa-solid fa-user-group"></i>
                    <span class="font-semibold">Manajemen Staf</span>
                </x-nav-link>
            </li>
            {{-- <li>
                <x-nav-link href="{{ route('voter') }}" :active="request()->routeIs(['voter', 'voter.create', 'voter.show', 'voter.show.import'])"
                    class="flex items-center gap-3 px-6 py-3 border-white">
                    <i class="fa-solid fa-user-check"></i>
                    <span class="font-semibold">Data Peserta Terpilih</span>
                </x-nav-link>
            </li> --}}
            <li>
                <x-nav-link href="{{ route('position') }}" :active="request()->routeIs(['position', 'position.edit'])"
                    class="flex items-center gap-3 px-6 py-3 border-white">
                    <i class="fa-solid fa-list"></i>
                    <span class="font-semibold">Data Posisi</span>
                </x-nav-link>
            </li>
            <li>
                <x-nav-link href="{{ route('admin.logs') }}" :active="request()->routeIs('admin.logs')"
                    class="flex items-center gap-3 px-6 py-3 border-white">
                    <i class="fa-solid fa-history"></i>
                    <span class="font-semibold">Log Admin</span>
                </x-nav-link>
            </li>
        </ul>
    </nav>
    </div>
@endif

<!-- Overlay for mobile when sidebar is open -->
<div id="sidebarOverlay"
    class="overflow-y-auto fixed inset-0 drop-shadow-xl bg-black/5 bg-opacity-20 z-20 hidden md:hidden"
    onclick="closeSidebar()"></div>
