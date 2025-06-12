<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Figtree:400,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <link rel="stylesheet" href="//cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Script JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    {{-- <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script> --}}
    <!-- Data Tables -->
    <script src="//cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
    <!-- Chart -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- Swiper -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- QR Code -->
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>

    <title>@yield('title')</title>
</head>

<body class="bg-[#FAFAFA] overflow-x-hidden">

    @yield('content')

</body>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const handleAlertAnimation = (alertId, duration = 2000, transitionDuration = 300) => {
            const alert = document.getElementById(alertId);
            if (alert) {

                setTimeout(() => {
                    alert.classList.remove('opacity-0');
                    alert.classList.add('opacity-100');
                }, 100);

                setTimeout(() => {
                    alert.classList.remove('opacity-100');
                    alert.classList.add('opacity-0');
                    setTimeout(() => alert.remove(),
                        transitionDuration); 
                }, duration);
            }
        };


        handleAlertAnimation('errorAlert', 2000, 150);
        handleAlertAnimation('successAlert', 2000, 150);
    });
</script>

<style>

    .swiper {
        width: 100%;
        padding-bottom: 50px;
    }

    .swiper-slide {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .swiper-button-next,
    .swiper-button-prev {
        color: #05c1ff;
    }

    .swiper-pagination-bullet-active {
        background: #05c1ff;
    }

    @media (max-width: 640px) {

        .swiper-button-next,
        .swiper-button-prev {
            transform: scale(0.8);
        }
    }
</style>

</html>
