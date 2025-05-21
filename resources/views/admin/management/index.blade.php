@extends('admin.layouts.app')

@section('title', 'Manajemen Admin')

@section('content')

    <div class="flex-1 overflow-y-auto px-8 pt-6 pb-6">
        <div class="space-y-6">
            <div class="flex flex-col bg-white/30 backdrop-blur-lg rounded-xl shadow-lg p-6">
                <div class="bg-gradient-to-r from-[#05C1FF]/20 to-[#0FA3FF]/20 rounded-lg shadow-lg p-6">
                    <div class="">
                        <h1 class="text-2xl lg:text-3xl font-bold text-[#0B8BDB] mb-2">Tabel User Admin</h1>
                        <p class="text-sm text-[#0B8BDB] mb-4 lg:text-base">Daftar user admin yang terdaftar di sistem.</p>
                    </div>
                    <div class="shadow-lg w-max">
                        <a href="{{ route('admin.mgmt.create') }}"
                            class="font-semibold flex items-center gap-3 px-4 py-3 lg:px-6 lg:py-4 bg-gradient-to-r from-[#05C1FF] to-[#0FA3FF] text-white rounded-md hover:bg-gradient-r hover:from-[#0092C2] hover:to-[#006BAD] transform transition duration-100 ease-in-out">
                            <span class="text-sm lg:text-base">Daftarkan Admin</span>
                            <i class="fa-solid fa-user-plus fa-sm lg:fa-md"></i>
                        </a>
                    </div>
                </div>
                <hr class="rounded border-t-2 border-[#B8B8B8]/50 my-8 mx-6">

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

                <div class="overflow-x-auto text-sm">
                    <table id="adminTable" class="table-auto w-full border-collapse rounded-lg overflow-hidden shadow-lg">
                        <thead class="bg-[#05C1FF]/20 backdrop-blur-lg border-gray-300">
                            <tr>
                                <th class="whitespace-nowrap text-[#0B8BDB] border border-gray-300 px-4 py-2 text-center">No
                                </th>
                                <th class="whitespace-nowrap text-[#0B8BDB] border border-gray-300 px-4 py-2 text-left">Nama
                                </th>
                                <th class="whitespace-nowrap text-[#0B8BDB] border border-gray-300 px-4 py-2 text-left">
                                    Username</th>
                                <th class="whitespace-nowrap text-[#0B8BDB] border border-gray-300 px-4 py-2 text-left">
                                    Email</th>
                                <th class="whitespace-nowrap text-[#0B8BDB] border border-gray-300 px-4 py-2 text-left">Role
                                </th>
                                <th class="whitespace-nowrap text-[#0B8BDB] border border-gray-300 px-4 py-2 text-center">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="odd:bg-white even:bg-gray-100">
                                    <td
                                        class="whitespace-nowrap text-gray-600 border border-gray-300 px-4 py-2 text-center">
                                        <span class="flex justify-center">{{ $loop->iteration }}</span>
                                    </td>
                                    <td class="whitespace-nowrap text-gray-600 border border-gray-300 px-4 py-2">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ Storage::url('avatars/' . $user->avatar) }}" alt="Profile"
                                                class="w-10 h-10 rounded-full object-cover"
                                                onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0FA3FF&color=fff'">
                                            <span class="text-gray-300">|</span>
                                            <span>{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap text-gray-600 border border-gray-300 px-4 py-2">
                                        {{ $user->username }}</td>
                                    <td class="whitespace-nowrap text-gray-600 border border-gray-300 px-4 py-2">
                                        {{ $user->email }}</td>
                                    <td class="whitespace-nowrap text-gray-600 border border-gray-300 px-4 py-2">
                                        <span class="flex justify-center">{{ ucwords($user->role) }}</span>
                                    </td>
                                    <td class="whitespace-nowrap text-gray-600 border border-gray-300 px-4 py-2">
                                        <div class="flex justify-center items-center gap-2">
                                            <a href="{{ route('admin.mgmt.edit', $user->uuid) }}"
                                                class="text-[#4A95FD] hover:bg-[#4A95FD] hover:text-white rounded-md px-2 py-1 transform transition duration-100 ease-in-out">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <span class="text-gray-300">|</span>
                                            <a href="{{ route('admin.mgmt.edit_password', $user->uuid) }}"
                                                class="text-[#FFB300] hover:bg-[#FFB300] hover:text-white rounded-md px-2 py-1 transform transition duration-100 ease-in-out">
                                                <i class="fa-solid fa-key"></i>
                                            </a>
                                            <span class="text-gray-300">|</span>
                                            <div x-data="{ open: false }" class="relative">
                                                <button @click="open = !open; console.log('open')"
                                                    class="text-[#E24A36] hover:bg-[#E24A36] hover:text-white cursor-pointer rounded-md px-2 py-1 transform transition duration-100 ease-in-out">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                <div x-show="open" x-cloak
                                                    class="fixed top-0 left-0 w-full h-full inset-0 bg-black/20 rounded-xl flex justify-center items-center z-50">
                                                </div>
                                                <div x-show="open"
                                                    x-transition:enter="transition ease-out duration-100 transform"
                                                    x-transition:enter-start="opacity-0 scale-95"
                                                    x-transition:enter-end="opacity-100 scale-100"
                                                    x-transition:leave="transition ease-in duration-75 transform"
                                                    x-transition:leave-start="opacity-100 scale-100"
                                                    x-transition:leave-end="opacity-0 scale-95" @click.away="open = false"
                                                    x-cloak
                                                    class="fixed top-0 left-0 w-full h-full rounded-xl flex justify-center items-center z-50">
                                                    <div
                                                        class="p-6 w-[360px] lg:w-[540px] bg-white/90 backdrop-blur-lg border-gray-200 rounded-lg shadow-lg items-center justify-center">
                                                        <div class= "bg-[#E24A36]/20 backdrop-blur-lg py-2 rounded-lg">
                                                            <h2
                                                                class="mb-2 text-xl font-bold text-[#E24A36] text-center px-4 translate-y-1">
                                                                Hapus
                                                                Data Admin</h2>
                                                        </div>
                                                        <hr class="rounded border-t-2 border-[#B8B8B8]/50 my-6 mx-full">
                                                        <p class="mb-6 font-medium text-gray-600 text-center">Yakin untuk
                                                            menghapus yang dipilih? <br> Saat ini memilih data
                                                            dari:<br><span
                                                                class="font-semibold text-[#0B8BDB]">({{ $user->name }})</span>
                                                        </p>
                                                        <form action="{{ route('admin.mgmt.delete', $user->uuid) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="mb-6">
                                                                <label for="password_confirmation"
                                                                    class="text-gray-500 font-medium text-xs lg:text-sm">Konfirmasi
                                                                    Password</label>
                                                                <div class="relative">
                                                                    <i
                                                                        class="fa fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                                                                    <input placeholder="Masukkan Password User Ini"
                                                                        type="password" name="password_confirmation"
                                                                        id="password_confirmation"
                                                                        class="text-sm w-full h-14 pl-12 pr-12 placeholder:text-gray-300 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0FA3FF] transition duration-300 ease-in-out rounded-md shadow-sm"
                                                                        required autocomplete="off">
                                                                    <i
                                                                        class="fa fa-eye absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 cursor-pointer togglePassword"></i>
                                                                </div>
                                                            </div>
                                                            <div class="flex flex-row gap-2 justify-between">
                                                                <button type="button" @click="open = false"
                                                                    class="cursor-pointer px-5 py-2.5 bg-gray-400 rounded-lg">
                                                                    <span class="text-white font-semibold">Kembali</span>
                                                                </button>
                                                                <button type="submit"
                                                                    class="cursor-pointer px-5 py-2.5 bg-[#E24A36] rounded-lg">
                                                                    <span class="text-[white] font-semibold">Hapus</span>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#adminTable').DataTable({
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "lengthMenu": [
                        [10, 25, 50, -1],
                        [10, 25, 50, "Semua"]
                    ],
                    "language": {
                        "lengthMenu": "Tampilkan _MENU_ data per halaman",
                        "zeroRecords": "Data tidak ditemukan",
                        "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                        "infoEmpty": "Tidak ada data",
                        "infoFiltered": "(disaring dari _MAX_ total data)",
                        "search": "Cari User: ",
                        "paginate": {
                            "first": "Awal",
                            "last": "Akhir",
                            "next": "❯",
                            "previous": "❮"
                        }
                    },
                    "columnDefs": [{
                            "orderable": false,
                            "targets": -1
                        } // -1 berarti kolom terakhir (Aksi)
                    ],
                });
            });
        </script>

    @endsection
