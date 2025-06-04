<x-layouts.app.header :title="$title ?? null">
    {{-- <div class="absolute inset-0 bg-neutral-900 custom-bg"></div> --}}
    {{-- <video autoplay muted loop playsinline class="bg-video">
        <source src="{{ url('bg-video.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video> --}}
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts.app.header>
