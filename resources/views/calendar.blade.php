{{-- <!DOCTYPE html> --}}
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> --}}
    {{-- <head> --}}
        {{-- <meta charset="utf-8"> --}}
        {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}
        {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

        {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}

        <!-- Fonts -->
        {{-- <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap"> --}}

        <!-- Scripts -->
        {{-- @vite(['resources/css/app.css',
        'resources/js/app.js',
        'resources/js/flatpickr.js']) --}}

        <!-- Styles -->
        {{-- @livewireStyles --}}
    {{-- </head> --}}
    {{-- <body class="font-sans antialiased"> --}}
        {{-- コンポーネント読み込み --}}
<x-calendar-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            予約カレンダー
        </h2>
    </x-slot>


    <div class="py-4">
        <div class="event-calendar border border-red-400 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @livewire('calendar')
            </div>
        </div>
    </div>
</x-calendar-layout>
        {{-- @livewireScripts
    </body>
</html> --}}