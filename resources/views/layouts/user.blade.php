<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body>
    <div class="min-h-screen bg-gray-50">
        @include('partials.user-header')

        <main>
            {{ $slot }}
        </main>

        {{-- @include('partials.user-footer') --}}
    </div>

    @livewireScripts
    @fluxScripts
</body>
</html>