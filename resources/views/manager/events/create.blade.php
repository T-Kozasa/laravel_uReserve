<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            新規登録
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <div class="max-w-2xl mx-auto">
                <x-jet-validation-errors class="mb-4" />

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('events.store') }}">
                    @csrf
                    
                    {{-- イベント名タブ --}}
                    {{-- <div>
                        <x-jet-label for="event_name" value="予約名" />
                        <x-jet-input id="event_name" class="block mt-1 w-full" type="text" name="event_name" :value="old('event_name')" required autofocus />
                    </div> --}}

                    {{-- textarea.blade.phpの中身を反映 --}}
                    {{-- 詳細を記入するボックスの設置 --}}
                    {{-- <div>
                        <x-jet-label for="information" value="予約の詳細" />
                        <x-textarea row="3" id="information" name="information" class="block mt-1 w-full">{{old('information')}}</x-textarea>
                    </div>
                     --}}
                    {{-- 各タブのサイズ設定 --}}
                    <div class="md:flex justify-between">
                    {{-- 日付・開始時間・終了時間タブの用意 --}}
                        <div class="mt-4">
                            <x-jet-label for="event_date" value="イベント日付" />
                            <x-jet-input id="event_date" class="block mt-1 w-full" type="text" name="event_date" required  />
                        </div>
                        

                        <div class="mt-4">
                            <x-jet-label for="start_time" value="開始時間" />
                            <x-jet-input id="start_time" class="block mt-1 w-full" type="text" name="start_time" required/>
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="end_time" value="終了時間" />
                            <x-jet-input id="end_time" class="block mt-1 w-full" type="text" name="end_time" required />
                        </div>
                    </div>
                    {{-- 定員数、表示非表示、登録ボタンの設置 --}}
                    <div class="md:flex justify-between item-end">
                        <div class="mt-4">
                            <x-jet-label for="max_people" value="定員数" />
                            <x-jet-input id="max_people" class="block mt-1 w-full" type="number" name="max_people" required />
                        </div>
                        <div class="flex space-x-4 justify-around mt-12">
                            <input type="radio" name="is_visible" value="1" checked />表示
                            <input type="radio" name="is_visible" value="0" checked />非表示
                        </div>
                        <x-jet-button class="ml-4 mt-10">
                            新規登録
                        </x-jet-button>
                    </div>
                </form>
            </div>




        {{-- @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif --}}

        {{-- <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-jet-button class="ml-4">
                    {{ __('Log in') }}
                </x-jet-button>
            </div>
        </form> --}}





                {{-- 日付 <input type="text" id="event_date" name="event_date">
                開始時間 <input type="text" id="start_time" name="start_time">
                終了時間 <input type="text" id="end_time" name="end_time"> --}}
            </div>
        </div>
    </div>
</x-app-layout>
