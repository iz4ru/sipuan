@extends('admin.layouts.app')

@section('title', 'Data Tag')

@section('content')
    <div class="flex-1 overflow-y-auto px-8 pt-6 pb-6">
        <div class="space-y-6">
            <div class="flex flex-col bg-white/30 backdrop-blur-lg rounded-xl shadow-lg p-6">
                <div class="bg-gradient-to-r from-[#05C1FF]/20 to-[#0FA3FF]/20 rounded-lg shadow-lg p-6">
                    <div class="">
                        <h1 class="text-2xl lg:text-3xl font-bold text-[#0B8BDB] mb-2">Tabel Data Tag</h1>
                        <p class="text-sm text-[#0B8BDB] mb-4 lg:text-base">
                            Kelola data tag dengan mudah serta memperbarui informasi tag secara real-time.
                        </p>
                    </div>
                    <div class="shadow-lg w-max">
                        <a href="{{ route('tag.create') }}"
                            class="font-semibold flex items-center gap-3 px-4 py-3 lg:px-6 lg:py-4 bg-gradient-to-r from-[#05C1FF] to-[#0FA3FF] text-white rounded-md hover:bg-gradient-r hover:from-[#0092C2] hover:to-[#006BAD] transform transition duration-100 ease-in-out">
                            <span class="text-sm lg:text-base">Tambahkan Tag</span>
                            <i class="fa-solid fa-plus fa-sm lg:fa-md"></i>
                        </a>
                    </div>
                </div>
                <hr class="rounded border-t-2 border-[#B8B8B8]/50 my-8 mx-6">

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

                <div class="overflow-x-auto text-sm">
                    <table id="adminTable" class="table-auto w-full border-collapse rounded-lg overflow-hidden shadow-lg">
                        <thead class="bg-[#05C1FF]/20 backdrop-blur-lg border-gray-300">
                            <tr>
                                <th class="whitespace-nowrap text-[#0B8BDB] border border-gray-300 px-4 py-2 text-center">No
                                </th>
                                <th class="whitespace-nowrap text-[#0B8BDB] border border-gray-300 px-4 py-2 text-left">Nama
                                    Tag
                                </th>
                                @if (Auth::user()->role == 'admin')
                                    <th
                                        class="whitespace-nowrap text-[#0B8BDB] border border-gray-300 px-4 py-2 text-center">
                                        Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tags as $tag)
                                <!-- Cek apakah positon dalam session -->
                                <tr class="odd:bg-white even:bg-gray-100">
                                    <td
                                        class="whitespace-nowrap text-gray-600 border border-gray-300 px-4 py-2 text-center">
                                        <span class="flex justify-center">{{ $loop->iteration }}</span>
                                    </td>
                                    <td class="whitespace-nowrap text-gray-600 border border-gray-300 px-4 py-2">
                                        {{ $tag->tag_name }}</td>
                                    @if (Auth::user()->role == 'admin')
                                        <td class="whitespace-nowrap text-gray-600 border border-gray-300 px-4 py-2">
                                            <div class="flex justify-center items-center gap-2">
                                                <a href="{{ route('tag.edit', $tag->id) }}"
                                                    class="cursor-pointer text-[#4A95FD] hover:bg-[#4A95FD] hover:text-white rounded-md px-2 py-1">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <span class="text-gray-300">|</span>
                                                <form action="{{ route('tag.delete', $tag->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        class="cursor-pointer text-[#E24A36] hover:bg-[#E24A36] hover:text-white rounded-md px-2 py-1">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
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
                        "search": "Cari Tag: ",
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
