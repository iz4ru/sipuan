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
                            <div class="flex flex-col lg:flex-row w-full gap-4 px-4 md:px-8">

                                <!-- Staff Card -->
                                <div
                                    class="shadow-lg flex flex-col gap-5 bg-white/50 backdrop-blur-lg w-full lg:w-1/4 py-8 px-6 my-4 rounded-xl items-center justify-start text-center">
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

                                <!-- Statistics Section -->
                                <div
                                    class="shadow-lg flex flex-col gap-4 bg-white/40 backdrop-blur-lg w-full lg:w-3/4 py-8 px-6 my-4 rounded-xl items-start justify-start">

                                    <div class="flex w-full items-center justify-center">
                                        <h2 class="text-3xl font-bold text-[#0FA3FF] mb-2">Akumulasi</h2>
                                    </div>

                                    <div class="flex flex-col w-full items-center justify-center">
                                        <div
                                            class="flex font-semibold text-gray-500 mb-4 gap-2 items-center justify-center">
                                            <i class="fa-solid fa-chart-bar"></i>
                                            <span class="text-gray-300 text-sm">|</span>
                                            <span class="">Statistik Perolehan Tag</span>
                                        </div>
                                        <div id="tagChart" class="w-full"></div>
                                    </div>

                                    @php
                                        $tagNames = $tagCounts->pluck('tag_name');
                                        $tagTotals = $tagCounts->pluck('total');
                                        $colors = ['#1D7AFC', '#FFB300', '#7C3AED', '#EF4444', '#22A06B', '#EC4899'];
                                    @endphp

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const tagNames = @json($tagNames);
                                            const tagTotals = @json($tagTotals);
                                            const colors = @json($colors);

                                            const options = {
                                                series: [{
                                                    name: 'Total Tag',
                                                    data: tagTotals
                                                }],
                                                chart: {
                                                    type: 'bar',
                                                    height: 300,
                                                    width: '100%',
                                                    toolbar: {
                                                        show: false
                                                    },
                                                    background: 'transparent',
                                                    fontFamily: 'inherit'
                                                },
                                                plotOptions: {
                                                    bar: {
                                                        borderRadius: 4,
                                                        distributed: true,
                                                        dataLabels: {
                                                            position: 'top'
                                                        }
                                                    }
                                                },
                                                dataLabels: {
                                                    enabled: true,
                                                    formatter: function(val) {
                                                        return val;
                                                    },
                                                    style: {
                                                        fontSize: '12px',
                                                        fontWeight: 'bold'
                                                    }
                                                },
                                                xaxis: {
                                                    categories: tagNames,
                                                    labels: {
                                                        style: {
                                                            fontSize: '12px'
                                                        }
                                                    }
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Jumlah Tag'
                                                    }
                                                },
                                                colors: colors,
                                                legend: {
                                                    show: false
                                                },
                                                tooltip: {
                                                    y: {
                                                        formatter: function(val) {
                                                            return val + " kali";
                                                        }
                                                    }
                                                }
                                            };

                                            const chart = new ApexCharts(document.querySelector("#tagChart"), options);
                                            chart.render();
                                        });
                                    </script>

                                    <div class="flex flex-col gap-4 mb-8">
                                        <div
                                            class="flex font-semibold text-gray-500 mb-4 gap-2 items-center justify-center">
                                            <i class="fa-solid fa-tag"></i>
                                            <span class="text-gray-300 text-sm">|</span>
                                            <span class="">Tag yang Didapatkan:</span>
                                            <p class="font-semibold text-[#0FA3FF]">{{ $totalTags }}</p>
                                        </div>

                                        <div class="flex flex-wrap gap-2 items-center justify-center">
                                            @foreach ($tagCounts as $tag)
                                                @if ($tag['total'] < 1)
                                                    <div
                                                        class="flex gap-2 justify-center items-center px-4 py-1.5 rounded-full transition-colors text-sm font-medium select-none border-2 border-[#05C1FF] text-white shadow-md">
                                                        <p class="text-center justify-center font-bold text-[#05C1FF]">
                                                            {{ $tag['total'] }}</p>
                                                        <span class="font-bold text-[#05C1FF]">|</span>
                                                        <p class="text-center justify-center text-[#05C1FF]">
                                                            {{ $tag['tag_name'] }}</p>
                                                    </div>
                                                @else
                                                    <div
                                                        class="flex gap-2 justify-center items-center px-4 py-1.5 rounded-full transition-colors text-sm font-medium select-none bg-[#05C1FF] text-white shadow-md">
                                                        <p class="text-center justify-center font-bold">{{ $tag['total'] }}
                                                        </p>
                                                        <span class="font-bold">|</span>
                                                        <p class="text-center justify-center">{{ $tag['tag_name'] }}</p>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        <div
                                            class="flex font-semibold text-gray-500 my-4 gap-2 items-center justify-center">
                                            <i class="fa-solid fa-comment"></i>
                                            <span class="text-gray-300 text-sm">|</span>
                                            <span class="">Komentar yang Didapatkan:</span>
                                            <p class="font-semibold text-[#0FA3FF]">{{ $totalComments }}</p>
                                        </div>

                                        <!-- Comments Section -->
                                        <div class="flex flex-col rounded-xl">
                                            <div class="flex items-center justify-between mb-6">
                                                <div class="flex items-center gap-2">
                                                    <label for="commentsPerPage"
                                                        class="text-sm text-gray-600">Tampilkan:</label>
                                                    <select id="commentsPerPage"
                                                        class="px-3 py-1 border border-gray-300 rounded-md text-sm">
                                                        <option value="5">5 komentar</option>
                                                        <option value="10">10 komentar</option>
                                                        <option value="15">15 komentar</option>
                                                        <option value="20">20 komentar</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Comments Container -->
                                            <div id="commentsContainer" class="space-y-4">
                                                @forelse($initialComments as $comment)
                                                    <div
                                                        class="comment-item bg-white/50 backdrop-blur-sm rounded-lg p-4 border border-gray-200">
                                                        <div class="flex items-start gap-3">
                                                            <div
                                                                class="w-10 h-10 bg-[#0FA3FF] rounded-full flex items-center justify-center text-white font-semibold">
                                                                <i class="fa-solid fa-user"></i>
                                                            </div>
                                                            <div class="flex-1">
                                                                <div class="flex items-center gap-2 mb-2">
                                                                    <span
                                                                        class="font-semibold text-gray-700">Pengguna Anonim</span>
                                                                    <span
                                                                        class="text-xs text-gray-500">{{ $comment['created_at']->diffForHumans() }}</span>
                                                                </div>
                                                                <div class="comment-text-container">
                                                                    @if ($comment['is_long'])
                                                                        <p
                                                                            class="text-gray-600 leading-relaxed comment-preview">
                                                                            {{ $comment['comment_preview'] }}
                                                                        </p>
                                                                        <p
                                                                            class="text-gray-600 leading-relaxed comment-full hidden">
                                                                            {{ $comment['comment'] }}
                                                                        </p>
                                                                        <button
                                                                            class="cursor-pointer read-more-btn text-[#0FA3FF] hover:text-[#0B8BDB] text-sm font-medium mt-2 transition-colors">
                                                                            Lihat selengkapnya
                                                                        </button>
                                                                        <button
                                                                            class="cursor_pointer read-less-btn text-[#0FA3FF] hover:text-[#0B8BDB] text-sm font-medium mt-2 transition-colors hidden">
                                                                            Lihat lebih sedikit
                                                                        </button>
                                                                    @else
                                                                        <p class="text-gray-600 leading-relaxed">
                                                                            {{ $comment['comment'] }}</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="text-center py-8">
                                                        <i
                                                            class="fa-solid fa-comment-slash text-4xl text-gray-300 mb-3"></i>
                                                        <p class="text-gray-500">Belum ada komentar untuk staff ini.</p>
                                                    </div>
                                                @endforelse
                                            </div>

                                            <!-- Load More Button -->
                                            @if ($totalComments > 5)
                                                <div class="text-center mt-6">
                                                    <button id="loadMoreBtn"
                                                        class="px-6 py-3 bg-[#0FA3FF] hover:bg-[#0B8BDB] text-white rounded-lg transition-colors font-semibold">
                                                        <span id="loadMoreText">Muat Lebih Banyak</span>
                                                        <i id="loadMoreIcon" class="fa-solid fa-chevron-down ml-2"></i>
                                                    </button>
                                                </div>
                                            @endif

                                            <!-- Loading Indicator -->
                                            <div id="loadingIndicator" class="text-center mt-4 hidden">
                                                <div class="inline-flex items-center gap-2 text-[#0FA3FF]">
                                                    <i class="fa-solid fa-spinner fa-spin"></i>
                                                    <span>Memuat komentar...</span>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                const staffUuid = '{{ $staff->uuid }}';
                                                const commentsContainer = document.getElementById('commentsContainer');
                                                const loadMoreBtn = document.getElementById('loadMoreBtn');
                                                const loadMoreText = document.getElementById('loadMoreText');
                                                const loadMoreIcon = document.getElementById('loadMoreIcon');
                                                const loadingIndicator = document.getElementById('loadingIndicator');
                                                const commentsPerPageSelect = document.getElementById('commentsPerPage');

                                                let currentPage = 2;
                                                let isLoading = false;
                                                let hasMoreComments = {{ $totalComments > 5 ? 'true' : 'false' }};

                                                // Initialize read more functionality for existing comments
                                                initializeReadMore();

                                                // Handle comments per page change
                                                commentsPerPageSelect.addEventListener('change', function() {
                                                    const perPage = this.value;
                                                    loadComments(1, perPage, true);
                                                });

                                                // Handle load more button click
                                                if (loadMoreBtn) {
                                                    loadMoreBtn.addEventListener('click', function() {
                                                        const perPage = commentsPerPageSelect.value;
                                                        loadComments(currentPage, perPage, false);
                                                    });
                                                }

                                                function initializeReadMore() {
                                                    const readMoreBtns = document.querySelectorAll('.read-more-btn');
                                                    const readLessBtns = document.querySelectorAll('.read-less-btn');

                                                    readMoreBtns.forEach(btn => {
                                                        btn.addEventListener('click', function() {
                                                            const container = this.closest('.comment-text-container');
                                                            const preview = container.querySelector('.comment-preview');
                                                            const full = container.querySelector('.comment-full');
                                                            const readLessBtn = container.querySelector('.read-less-btn');

                                                            preview.classList.add('hidden');
                                                            full.classList.remove('hidden');
                                                            this.classList.add('hidden');
                                                            readLessBtn.classList.remove('hidden');
                                                        });
                                                    });

                                                    readLessBtns.forEach(btn => {
                                                        btn.addEventListener('click', function() {
                                                            const container = this.closest('.comment-text-container');
                                                            const preview = container.querySelector('.comment-preview');
                                                            const full = container.querySelector('.comment-full');
                                                            const readMoreBtn = container.querySelector('.read-more-btn');

                                                            full.classList.add('hidden');
                                                            preview.classList.remove('hidden');
                                                            this.classList.add('hidden');
                                                            readMoreBtn.classList.remove('hidden');
                                                        });
                                                    });
                                                }

                                                function loadComments(page, perPage, reset = false) {
                                                    if (isLoading) return;

                                                    isLoading = true;
                                                    loadingIndicator.classList.remove('hidden');

                                                    if (loadMoreBtn) {
                                                        loadMoreBtn.disabled = true;
                                                        loadMoreText.textContent = 'Memuat...';
                                                        loadMoreIcon.className = 'fa-solid fa-spinner fa-spin ml-2';
                                                    }

                                                    fetch(`/staff-mgmt/details/${staffUuid}/comments?page=${page}&per_page=${perPage}`)
                                                        .then(response => response.json())
                                                        .then(data => {
                                                            if (reset) {
                                                                commentsContainer.innerHTML = '';
                                                                currentPage = 2;
                                                            }

                                                            if (data.comments.length > 0) {
                                                                data.comments.forEach(comment => {
                                                                    const commentElement = createCommentElement(comment);
                                                                    commentsContainer.appendChild(commentElement);
                                                                });

                                                                // Initialize read more for new comments
                                                                initializeReadMore();

                                                                if (!reset) {
                                                                    currentPage = data.nextPage;
                                                                }

                                                                hasMoreComments = data.hasMore;
                                                            } else {
                                                                hasMoreComments = false;
                                                            }

                                                            // Update load more button visibility
                                                            if (loadMoreBtn) {
                                                                if (hasMoreComments) {
                                                                    loadMoreBtn.style.display = 'inline-flex';
                                                                } else {
                                                                    loadMoreBtn.style.display = 'none';
                                                                }
                                                            }

                                                            // Show empty state if no comments
                                                            if (reset && data.comments.length === 0) {
                                                                commentsContainer.innerHTML = `
                        <div class="text-center py-8">
                            <i class="fa-solid fa-comment-slash text-4xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500">Belum ada komentar untuk staff ini.</p>
                        </div>
                    `;
                                                            }
                                                        })
                                                        .catch(error => {
                                                            console.error('Error loading comments:', error);
                                                            alert('Terjadi kesalahan saat memuat komentar.');
                                                        })
                                                        .finally(() => {
                                                            isLoading = false;
                                                            loadingIndicator.classList.add('hidden');

                                                            if (loadMoreBtn) {
                                                                loadMoreBtn.disabled = false;
                                                                loadMoreText.textContent = 'Muat Lebih Banyak';
                                                                loadMoreIcon.className = 'fa-solid fa-chevron-down ml-2';
                                                            }
                                                        });
                                                }

                                                function createCommentElement(comment) {
                                                    const div = document.createElement('div');
                                                    div.className = 'comment-item bg-white/50 backdrop-blur-sm rounded-lg p-4 border border-gray-200';

                                                    const createdAt = new Date(comment.created_at);
                                                    const timeAgo = getTimeAgo(createdAt);

                                                    let commentContent = '';
                                                    if (comment.is_long) {
                                                        commentContent = `
                <div class="comment-text-container">
                    <p class="text-gray-600 leading-relaxed comment-preview">
                        ${comment.comment_preview}
                    </p>
                    <p class="text-gray-600 leading-relaxed comment-full hidden">
                        ${comment.comment}
                    </p>
                    <button class="cursor-pointer read-more-btn text-[#0FA3FF] hover:text-[#0B8BDB] text-sm font-medium mt-2 transition-colors">
                        Lihat selengkapnya
                    </button>
                    <button class="cursor-pointer read-less-btn text-[#0FA3FF] hover:text-[#0B8BDB] text-sm font-medium mt-2 transition-colors hidden">
                        Lihat lebih sedikit
                    </button>
                </div>
            `;
                                                    } else {
                                                        commentContent = `
                <div class="comment-text-container">
                    <p class="text-gray-600 leading-relaxed">${comment.comment}</p>
                </div>
            `;
                                                    }

                                                    div.innerHTML = `
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 bg-[#0FA3FF] rounded-full flex items-center justify-center text-white font-semibold">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="font-semibold text-gray-700">Pengguna Anonim</span>
                        <span class="text-xs text-gray-500">${timeAgo}</span>
                    </div>
                    ${commentContent}
                </div>
            </div>
        `;

                                                    return div;
                                                }

                                                function getTimeAgo(date) {
                                                    const now = new Date();
                                                    const diffInSeconds = Math.floor((now - date) / 1000);

                                                    if (diffInSeconds < 60) return 'Baru saja';
                                                    if (diffInSeconds < 3600) return Math.floor(diffInSeconds / 60) + ' menit yang lalu';
                                                    if (diffInSeconds < 86400) return Math.floor(diffInSeconds / 3600) + ' jam yang lalu';
                                                    if (diffInSeconds < 2592000) return Math.floor(diffInSeconds / 86400) + ' hari yang lalu';
                                                    if (diffInSeconds < 31536000) return Math.floor(diffInSeconds / 2592000) + ' bulan yang lalu';
                                                    return Math.floor(diffInSeconds / 31536000) + ' tahun yang lalu';
                                                }
                                            });
                                        </script>

                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </section>
            </div>
        </div>


    @endsection
