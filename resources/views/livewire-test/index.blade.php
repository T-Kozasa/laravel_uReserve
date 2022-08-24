<html>
    <head>
        @livewireStyles
    </head>
    <body>
        @if (session()->has('message'))
        <div class="">
            {{ session('message') }}
        </div>
        @endif
        livewireテスト
        @livewire('counter')
        @livewireScripts
    </body>
</html>