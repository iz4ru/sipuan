@extends('admin.layouts.app')

@section('title', 'Detail Staff')

@section('content')
    <div class="flex-1 overflow-y-auto px-8 pt-6 pb-6">
        <div class="space-y-6">
            <div class="flex flex-col bg-white/30 backdrop-blur-lg rounded-xl shadow-lg p-6">
                <div class="bg-gradient-to-r from-[#05C1FF]/20 to-[#0FA3FF]/20 rounded-lg shadow-lg p-6">
                    <div class="">
                        <h1 class="text-2xl lg:text-3xl font-bold text-[#0B8BDB] mb-2">Detail Staff</h1>
                        <p class="text-sm text-[#0B8BDB] lg:text-base">Lihat detail dari staff untuk melihat penilaian dan
                            komentar yang masuk.</p>
                    </div>
                </div>
                <hr class="rounded border-t-2 border-[#B8B8B8]/50 my-8 mx-6">

                <a href="{{ route('staff.mgmt') }}"
                    class=" w-1/2 lg:w-1/4 px-6 py-4 bg-gray-400/80 hover:bg-gray-500/80 text-white rounded-xl transition-colors flex items-center justify-center gap-3">
                    <span class="font-semibold">Kembali</span>
                </a>
            </div>
        </div>

        <div class="space-y-6">
            <div class="flex flex-col bg-white/30 backdrop-blur-lg rounded-xl shadow-lg mt-6">
                <!-- Staff Section -->
                <section id="Staff">
                    <div class="lg:py-8">
                        <div class="max-w-7xl mx-auto px-4">
                            <!-- Header -->
                            <div class="text-center mb-8">
                                <h2 class="text-3xl font-bold text-gray-700 mt-6 mb-2">Detail Staff</h2>
                                <p class="text-gray-600">

                                </p>
                            </div>

                            <div class="flex flex-col lg:flex-row w-full gap-4 px-4 md:px-8">

                                <!-- Staff Card -->
                                <div
                                    class="shadow-lg flex flex-col gap-5 bg-white/50 backdrop-blur-lg w-full lg:w-1/4 py-8 px-6 mb-4 rounded-xl items-center justify-center text-center">
                                    <div class="relative w-[240px] h-[240px] lg:w-[200px] lg:h-[200px]">
                                        <img src="{{ Storage::url('images/' . $staff->image) }}" alt=""
                                            class="w-full h-full object-cover rounded-xl shadow-lg">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-[#0FA3FF]/50 from-0% to-50% to-transparent opacity-50 rounded-xl pointer-events-none">
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-center justify-center gap-1">
                                        <p class="text-gray-700 text-xl font-bold">{{ $staff->name }}</p>
                                        <p class="text-gray-500 text-base">{{ $staff->position->position_name }}</p>
                                        <p class="text-gray-500 text-base">{{ $staff->id_number }}</p>
                                    </div>

                                    <hr class="w-1/2 border-t border-gray-300" />
                                    <p class="text-gray-500 text-sm">Rating Pelayanan Staf</p>
                                    <div class="flex gap-2 items-center justify-center text-[#FFD32C]">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($staff->rate_results_avg_rate >= $i)
                                                {{-- full star --}}
                                                <i class="fa-solid fa-star fa-xl"></i>
                                            @elseif ($staff->rate_results_avg_rate >= $i - 0.5)
                                                {{-- half star --}}
                                                <i class="fa-solid fa-star-half-stroke fa-xl"></i>
                                            @else
                                                {{-- empty star --}}
                                                <i class="fa-regular fa-star fa-xl text-[#FFD32C]"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <div>
                                        <p class="text-gray-500 font-bold">
                                            {{ number_format($staff->rate_results_avg_rate, 1) ?? '0.0' }} dari
                                            {{ $staff->rate_results_count }} ulasan
                                        </p>
                                    </div>
                                    <hr class="w-1/2 border-t border-gray-300" />

                                    <!-- QR Code Section -->
                                    <div class="flex flex-col items-center gap-4 mt-2">
                                        <img id="qrImg"
                                            class="w-32 h-32 object-contain rounded-lg shadow-lg border border-gray-300" />
                                        <div class="flex flex-row relative gap-2 items-center justify-center">
                                            <i class="fa-solid fa-qrcode text-gray-400"></i>
                                            <p class="text-gray-400 text-sm">Scan untuk memberikan ulasan</p>
                                        </div>
                                    </div>
                                    <script>
                                        const url = @json(url('/rate', ['uuid' => $staff->uuid]));
                                        QRCode.toDataURL(url, {
                                            width: 128
                                        }, function(err, dataUrl) {
                                            if (err) {
                                                console.error("QR ERROR:", err);
                                                return;
                                            }
                                            document.getElementById('qrImg').src = dataUrl;
                                        });
                                    </script>
                                </div>

                                <div
                                    class="shadow-lg flex flex-col gap-4 bg-white/40 backdrop-blur-lg w-full lg:w-3/4 py-8 px-6 mb-4 rounded-xl items-start justify-start">
                                    <h2 class="font-semibold text-lg text-gray-700">Tag yang didapatkan:</h2>
                                    <div class="flex flex-wrap gap-2 items-start justify-start">
                                        @foreach ($tags as $tag)
                                            <div
                                                class="px-4 py-1.5 rounded-full transition-colors text-sm font-medium select-none bg-[#05C1FF] text-white shadow-md">
                                                <p class="text-center justify-center">{{ $tag->tag_name }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                    <h2 class="font-semibold text-lg text-gray-700">Komentar yang didapatkan:</h2>
                                </div>

                            </div>

                        </div>
                    </div>
                </section>
            </div>
        </div>


    @endsection
