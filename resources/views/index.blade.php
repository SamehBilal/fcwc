<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style>
        .custom-bg {
            background-color: #313131;
            /* solid black base */
            background-image: radial-gradient(99.7% 118.58% at 47.86% -54.11%,
                    rgba(252, 175, 64, 0.74) 42.73%,
                    rgba(26, 0, 14, 0.54) 77.16%,
                    #000000 100%);
            background-blend-mode: multiply;
        }

        .bg-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
            opacity: 18%;
        }
    </style>
</head>

<body class="custom-bg text-white relative min-h-screen overflow-hidden">
    {{-- <div class="absolute inset-0 bg-black/60 z-[1] pointer-events-none"></div> --}}

    <!-- Background Video -->
    <video autoplay muted loop playsinline class="bg-video">
        <source src="{{ url('bg-video.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Content Overlay -->
    <div class="relative z-10 flex flex-col items-center justify-center p-6 lg:p-8 min-h-screen">
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 border border-white rounded-sm text-sm leading-normal" wire:navigate>
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 border border-white rounded-sm text-sm leading-normal" wire:navigate>
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 border border-white rounded-sm text-sm leading-normal" wire:navigate>
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row">
            <!-- Your main content here -->
            <h1 class="text-3xl font-bold text-center lg:text-left">Welcome to My App</h1>
        </main>
    </div>

</body>

</html>
