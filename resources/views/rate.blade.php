@extends('layouts.app')

@section('title', 'Lihat Staff')

@section('content')

    <div class="min-h-screen flex flex-col max-w-full">

        @include('layouts.navigation')

        <!-- Search Staff Section -->
        <section id="search-staff"
            class="pt-20 lg:py-20 overflow-hidden bg-gradient-to-b from-[#FAFAFA] from-50% to-[#ECECEC]">
            <div class="py-4 lg:px-24 lg:py-6">
                <div class="flex items-center gap-6 px-8 py-4">
                    <a href="/staff" class="text-gray-600 hover:text-gray-800 transition-colors items-center flex gap-2">
                        <i class="fa-solid fa-chevron-left"></i>
                        <span class="text-sm font-semibold">Kembali</span>
                    </a>
                </div>
            </div>

            <div class="w-full flex justify-center items-center px-4 sm:px-6 lg:px-8">
                <div
                    class="flex flex-col items-center gap-10 lg:gap-16 transition-transform duration-500 ease-in-out w-full max-w-7xl">
                    <!-- Center Content -->
                    <div class="text-center w-full">
                        <h2 class="text-2xl lg:text-4xl font-bold text-gray-700 leading-tight">
                            Beri Nilai Pelayanan Staf
                        </h2>

                        <!-- Alerts -->
                        @if (session('success'))
                            <div class="my-8 alert alert-success alert-dismissible relative text-sm py-2 px-4 bg-green-100 text-green-500 border border-green-500 rounded-md opacity-0 transition-opacity duration-150 ease-in-out"
                                role="alert" id="successAlert">
                                <i class="fa fa-circle-check absolute left-4 top-1/2 -translate-y-1/2"></i>
                                <p class="ml-6">{{ session('success') }}</p>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="my-8 alert alert-danger alert-dismissible relative text-sm py-2 px-4 bg-red-100 text-red-500 border border-red-500 rounded-md opacity-0 transition-opacity duration-150 ease-in-out"
                                role="alert" id="errorAlert">
                                <i class="fa fa-circle-exclamation absolute left-4 top-1/2 -translate-y-1/2"></i>
                                <ul class="list-none m-0 p-0">
                                    @foreach ($errors->all() as $error)
                                        <li class="ml-6">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="my-8 pb-16 lg:pb-0 w-full">
                            <div class="flex flex-col lg:flex-row w-full gap-4 px-4 md:px-8">

                                <!-- Card Kiri - Profil Staff -->
                                <div
                                    class="shadow-lg flex flex-col gap-5 bg-white/30 backdrop-blur-lg w-full lg:w-1/4 py-8 px-6 rounded-xl items-center justify-center text-center">
                                    <div class="relative w-[240px] h-[240px] lg:w-[240px] lg:h-[240px]">
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
                                        const url = @json(url()->current());
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

                                <!-- Card Kanan - Form Penilaian -->
                                <div
                                    class="shadow-lg flex flex-col gap-4 bg-white/40 backdrop-blur-lg w-full lg:w-3/4 py-8 px-6 rounded-xl items-start justify-start">
                                    <p class="text-gray-700 text-lg font-medium text-start">
                                        Hai! Silakan berikan ulasan dan saran untuk saya. Terima kasih! :)
                                    </p>

                                    <form action="{{ route('rate.store', $staff->uuid) }}" method="POST" id="ratingForm"
                                        class="w-full flex flex-col gap-4">
                                        @csrf

                                        <!-- Tag Input Section -->
                                        <div x-data="tagManager" x-init="init()"
                                            class="w-full mt-1 flex flex-col gap-3 font-sans text-gray-800">
                                            <!-- Tag Label & Tag Buttons -->
                                            <div class="flex items-center gap-4">
                                                <p
                                                    class="text-gray-700 mb-2 font-semibold text-left whitespace-nowrap text-lg">
                                                    Tag:</p>
                                                <div class="flex flex-wrap gap-2 items-start justify-start">
                                                    <template x-for="(tag, index) in displayTags" :key="`tag-${index}`">
                                                        <button type="button" @click="toggleTag(tag)"
                                                            class="px-4 py-1.5 rounded-full transition-colors text-sm font-medium select-none cursor-pointer"
                                                            :class="isTagSelected(tag) ?
                                                                'bg-[#05C1FF] text-white shadow-md' :
                                                                (selectedTags.length >= maxTags ?
                                                                    'bg-gray-200 text-gray-400 cursor-not-allowed' :
                                                                    'bg-gray-300 text-gray-700 hover:bg-gray-400 hover:text-white'
                                                                )"
                                                            :disabled="!isTagSelected(tag) && selectedTags.length >= maxTags">
                                                            <span x-text="tag"></span>
                                                        </button>
                                                    </template>

                                                    @if ($tags->count() > 3)
                                                        <!-- Add More Button -->
                                                        <button type="button"
                                                            @click="if(selectedTags.length < maxTags) showModal = true"
                                                            :class="selectedTags.length >= maxTags ?
                                                                'cursor-not-allowed bg-gray-200 text-gray-400' :
                                                                'bg-gray-300 hover:bg-gray-400 text-gray-700'"
                                                            class="px-4 py-1.5 rounded-full transition-colors text-sm font-medium select-none cursor-pointer"
                                                            :disabled="selectedTags.length >= maxTags"
                                                            aria-label="Tambah Tag">
                                                            +
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Hidden inputs for form submission -->
                                            <template x-for="(tag, index) in selectedTags" :key="`selected-${index}`">
                                                <input type="hidden" name="tags[]" :value="tag" />
                                            </template>

                                            <!-- Modal -->
                                            <div x-show="showModal" @click.outside="showModal = false"
                                                class="fixed inset-0 bg-black/20 z-40 flex items-center justify-center rounded-xl"
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                                x-transition:leave="transition ease-in duration-100"
                                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                                style="display: none;">

                                                <div x-transition:enter="transition ease-out duration-150 transform"
                                                    x-transition:enter-start="opacity-0 scale-95"
                                                    x-transition:enter-end="opacity-100 scale-100"
                                                    x-transition:leave="transition ease-in duration-100 transform"
                                                    x-transition:leave-start="opacity-100 scale-100"
                                                    x-transition:leave-end="opacity-0 scale-95"
                                                    class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full z-50 font-sans text-gray-800">

                                                    <h2 class="text-xl font-semibold text-[#05C1FF] mb-4 text-center">Pilih
                                                        Tag Tambahan</h2>

                                                    <div class="flex flex-wrap gap-3 mb-6 justify-center">
                                                        <template x-for="(tag, index) in moreTags" :key="`modal-${index}`">
                                                            <button type="button" @click="toggleTag(tag)"
                                                                class="px-4 py-1.5 rounded-full text-sm font-medium select-none transition-colors"
                                                                :class="selectedTags.length >= maxTags ?
                                                                    'bg-gray-200 text-gray-400 cursor-not-allowed' :
                                                                    'bg-gray-200 hover:bg-[#05C1FF] hover:text-white cursor-pointer'"
                                                                :disabled="selectedTags.length >= maxTags">
                                                                <span x-text="tag"></span>
                                                            </button>
                                                        </template>
                                                    </div>

                                                    <div class="flex justify-center">
                                                        <button type="button" @click="closeModal()"
                                                            class="cursor-pointer px-5 py-2 bg-[#05C1FF] text-white rounded-md hover:bg-[#0494da] text-sm font-semibold select-none focus:outline-none focus:ring-2 focus:ring-[#05C1FF] focus:ring-offset-1 transition">
                                                            Selesai
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Rating -->
                                        <div>
                                            <p class="text-gray-500 mb-2 font-medium text-left">Berikan Nilai Terhadap
                                                Pelayanan</p>
                                            <div x-data="{ rating: 0, hoverRating: 0 }" class="flex gap-2 lg:gap-4 items-center mt-4">
                                                <template x-for="star in 5" :key="star">
                                                    <button type="button" @mouseover="hoverRating = star"
                                                        @mouseleave="hoverRating = 0" @click="rating = star"
                                                        :aria-label="'Beri nilai ' + star"
                                                        class="cursor-pointer text-gray-400 transition-all transform duration-150 ease-in-out hover:scale-110 focus:outline-none"
                                                        :class="{ '!text-[#FFD32C]': star <= (hoverRating || rating) }">
                                                        <i class="fa-solid fa-star text-3xl md:text-4xl"></i>
                                                    </button>
                                                </template>
                                                <span x-show="rating > 0 || hoverRating > 0"
                                                    x-transition:enter="transition ease-out duration-300"
                                                    x-transition:enter-start="opacity-0 scale-90 translate-y-2"
                                                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                                    x-transition:leave="transition ease-in duration-200"
                                                    x-transition:leave-start="opacity-100 scale-100"
                                                    x-transition:leave-end="opacity-0 scale-90"
                                                    x-text="{
        1: '1/5 • 😡 Sangat Buruk',
        2: '2/5 • 😞 Buruk',
        3: '3/5 • 😐 Biasa',
        4: '4/5 • 🙂 Puas',
        5: '5/5 • 🤩 Sangat Puas'
    }[hoverRating || rating]"
                                                    class="text-base lg:text-xl text-gray-500 ml-2 font-bold"></span>
                                                <input type="hidden" name="rate" :value="rating">
                                            </div>
                                        </div>

                                        <!-- Komentar -->
                                        <div class="w-full mt-4">
                                            <p class="text-gray-500 mb-2 font-medium text-left">Berikan Saran atau Komentar
                                                Positif</p>
                                            <div class="relative">
                                                <i class="fa fa-comment absolute left-4 top-4 text-gray-300"></i>
                                                <textarea name="comment" id="comment"
                                                    class="w-full border placeholder:text-gray-300 border-gray-300 rounded-lg pl-12 pr-3 pt-3 pb-3 focus:outline-none focus:ring-2 focus:ring-[#05C1FF] bg-white/70"
                                                    rows="4" placeholder="Sangat Bagus! Pelayanan yang Terbaik"></textarea>
                                            </div>
                                        </div>

                                        <!-- Kontak -->
                                        <div class="w-full border border-gray-200 rounded-lg p-4 bg-white/50 mt-1">
                                            <p class="text-gray-500 font-bold mb-4 text-left">KONTAK</p>
                                            <div class="space-y-2">
                                                <div class="flex items-center gap-2">
                                                    <i class="fa-brands fa-whatsapp text-gray-600"></i>
                                                    <p class="text-gray-700">WhatsApp:
                                                        <a href="{{ $whatsappNumber }}"
                                                            class="text-[#05C1FF] hover:underline">Klik
                                                            Untuk Kirim Pesan</a>
                                                    </p>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <i class="fa-solid fa-envelope text-gray-600"></i>
                                                    <p class="text-gray-700">E-mail:
                                                        <a href="{{ $staffEmail }}"
                                                            class="text-[#05C1FF] hover:underline">Klik
                                                            Untuk Kirim E-mail</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div x-data="{ open: false }" class="w-full flex justify-end mt-2">
                                            <button type="button" @click="open = !open"
                                                class="cursor-pointer mt-2 button bg-gradient-to-r from-[#05C1FF] to-[#0FA3FF] text-[#FAFAFA] justify-center px-8 py-3 rounded-md text-sm font-bold hover:from-[#0092C2] hover:to-[#006BAD] transition-colors flex items-center gap-1 sm:gap-2">
                                                Beri Nilai Pelayanan
                                                <i class="fa-solid fa-chevron-right fa-sm"></i>
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
                                                    <div
                                                        class="bg-gradient-to-r from-[#05C1FF]/20 to-[#0FA3FF]/20 backdrop-blur-lg py-2 rounded-lg">
                                                        <h2
                                                            class="mb-2 text-xl font-bold text-[#0FA3FF] text-center px-4 translate-y-1">
                                                            Konfirmasi Penilaian</h2>
                                                    </div>
                                                    <hr class="rounded border-t-2 border-[#B8B8B8]/50 my-6 mx-full">
                                                    <p class="mb-6 font-medium text-gray-600 text-center">Yakin untuk
                                                        mengirim penilaian ini? Pastikan semua informasi sudah benar sebelum
                                                        mengirim.</p>
                                                    <div class="flex flex-row gap-2 justify-between">
                                                        <button type="button" @click="open = false"
                                                            class="cursor-pointer px-5 py-2.5 bg-gray-400 hover:bg-gray-500 transition-colors rounded-lg">
                                                            <span class="text-white font-semibold">Kembali</span>
                                                        </button>
                                                        <button type="submit" id="submitButton"
                                                            class="cursor-pointer px-5 py-2.5 bg-[#0FA3FF] hover:bg-[#006BAD] transition-colors rounded-lg">
                                                            <span class="text-[white] font-semibold">Konfirmasi</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('layouts.footer')

    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('tagManager', () => ({
                selectedTags: [],
                availableTags: [],
                moreTags: [],
                showModal: false,
                maxTags: 3,

                init() {
                    const allTags = @json($tags->toArray());
                    this.availableTags = allTags.slice(0, 3);
                    this.moreTags = allTags.slice(3);
                },

                get displayTags() {
                    const selectedFromMore = this.selectedTags.filter(tag =>
                        !this.availableTags.includes(tag) && !this.moreTags.includes(tag)
                    );
                    return [...this.availableTags, ...selectedFromMore];
                },

                isTagSelected(tag) {
                    return this.selectedTags.includes(tag);
                },

                toggleTag(tag) {
                    const index = this.selectedTags.indexOf(tag);

                    if (index > -1) {
                        this.selectedTags.splice(index, 1);

                        const allTags = @json($tags->toArray());
                        const originalIndex = allTags.indexOf(tag);
                        if (originalIndex >= 3 && !this.moreTags.includes(tag)) {
                            this.moreTags.push(tag);
                        }
                    } else if (this.selectedTags.length < this.maxTags) {
                        this.selectedTags.push(tag);

                        if (this.moreTags.includes(tag)) {
                            this.moreTags = this.moreTags.filter(t => t !== tag);
                        }

                        if (this.selectedTags.length >= this.maxTags) {
                            setTimeout(() => {
                                this.showModal = false;
                            }, 300);
                        }
                    }
                },

                closeModal() {
                    this.showModal = false;
                }
            }));
        });
    </script>

@endsection
