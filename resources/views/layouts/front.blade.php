<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BAC</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/main_style.css') }}" rel="stylesheet">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <style>
        :root {
            --kfu-green: #004858;
            --kfu-light-green: #8DC63F;
            --kfu-beige: #F2EFE6;
            --kfu-dark: #09595F;
            --kuf-gold: #C69A47
        }

        body {
            font-family: "Cairo", sans-serif;
            background-color: #DCDED3;
            color: #333;
            direction: rtl;
            /* Right-to-left direction */
            text-align: right;
        }

        .navbar {
            background-color: var(--kfu-green);
            padding: 0.8rem 1rem;
        }

        .navbar-brand {
            font-weight: 700;
            color: white !important;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            transition: all 0.3s;
        }

        .nav-link:hover {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        .hero-section {
            background: linear-gradient(rgba(0, 104, 55, 0.9), rgba(0, 104, 55, 0.8)), url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80');
            color: white;
            padding: 4rem 0;
            margin-bottom: 3rem;
            text-align: center;
        }

        .kfu-logo {
            height: 80px;
            margin-bottom: 1.5rem;
        }

        .feature-card {
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--kfu-green);
            margin-bottom: 1rem;
        }

        .slider-container {

            max-width: 80%;
            margin: 0 auto;
            position: relative;

        }

        .card-carousel {
            overflow-x: auto;
            /* enables horizontal scroll */
            white-space: nowrap;
            padding: 20px;
            scroll-snap-type: x mandatory;
            /* smooth snapping (optional) */
        }

        .carousel-track {
            display: flex;
            gap: 20px;
            /* space between cards */
        }

        .camp-card {
            flex: 0 0 auto;
            /* prevent shrinking */
            width: 300px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 16px;
            scroll-snap-align: start;
            /* optional snapping */
        }

        .camp-card {
            max-width: 400px;

            background: linear-gradient(12deg, #ffffff 0%, #f1f8ff 100%);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
            text-align: center;
            padding: 30px;
            border: none;
        }

        .camp-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 25px;
            padding-bottom: 15px;
            align-self: center;
            border-bottom: 2px solid var(--secondary-color);
            font-size: 1.8rem;
        }

        .lec-card-title {
            color: var(--kuf-gold);
            font-weight: 600;
            margin-bottom: 25px;

            padding-bottom: 15px;
            border-bottom: 2px solid var(--secondary-color);
            font-size: 20px;
        }

        .detail-item {
            margin-bottom: 20px;
            padding: 15px;
            background-color: rgba(26, 35, 126, 0.05);
            border-radius: 10px;
            border-right: 4px solid var(--secondary-color);
        }

        .detail-label {
            font-weight: 700;
            color: var(--kfu-dark);
            margin-bottom: 5px;
            margin-top: 5px;

            font-size: 16px;
        }

        .detail-value {
            color: black;
            font-size: 15px;
        }

        .date-value {
            color: var(--secondary-color);
            font-weight: 700;
            font-size: 1.4rem;
        }

        .btn-kfu {
            background-color: var(--kfu-green);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 30px;
            transition: all 0.3s;
        }

        .btn-kfu:hover {
            background-color: var(--kfu-light-green);
            color: white;
        }

        .section-title {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 30px;
            text-align: center;
            font-weight: 700;
            color: var(--kfu-green);
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 5px;
            background-color: var(--kuf-gold);
        }

        footer {
            background-color: var(--kfu-dark);
            color: white;
            padding: 3rem 0 1.5rem;
            margin-top: 4rem;
        }

        .social-icon {
            font-size: 1.5rem;
            margin: 0 10px;
            color: white;
            transition: color 0.3s;
        }

        .social-icon:hover {
            color: var(--kfu-light-green);
        }

        @media (max-width: 768px) {
            .navbar-nav {
                text-align: right;
                padding: 0.5rem 0;
            }

            .hero-section {
                padding: 2rem 0;
            }

            .display-4 {
                font-size: 2rem;
            }

        }

        .body {
            background-color: #d8d9d9;
        }


        /* Gradient progress bar (سهل -> صعب) */
        .progress-bar-gradient {
            background: linear-gradient(to right, #f7c948, #00a3a3, #005f73);
        }

        /* Course card styles */
        .course-info-card {
            border-radius: 12px;
            padding: 20px;
        }

        /* Custom chapter item */
        .chapter-item {
            border-radius: 12px;
            margin-bottom: 12px;
            padding: 15px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
        }

        /* Download icon */
        .download-icon {
            background: #0d6d6d;
            color: #fff;
            border-radius: 50%;
            padding: 8px;
            font-size: 14px;
        }

        /* Content request button */
        .btn-request {
            background-color: #0d6d6d;
            color: #fff;
            border-radius: 20px;
            padding: 5px 12px;
            font-size: 13px;
        }

        .btn-request i {
            margin-left: 5px;
            color: #f7c948;
        }

        /* Section headers */
        .section-title {
            font-weight: bold;
            font-size: 16px;
            margin: 15px 0;
        }

        .text-gold {
            color: #c69d00;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen">
        @include('layouts.navBar')

        <!-- Page Heading -->
        {{-- @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset --}}

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
        @include('layouts.Footer')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
< /html>
