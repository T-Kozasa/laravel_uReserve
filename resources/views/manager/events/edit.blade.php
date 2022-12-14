<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            イベントの編集
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

                    <form method="POST" action="{{ route('events.update', ['event' => $event -> id]) }}">
                        @csrf
                        @method('put')
                        {{-- イベント名タブ --}}
                        <div>
                            <x-jet-label for="event_name" value="予約番号" />
                            <x-jet-input id="event_name" class="block mt-1 w-full" type="text" name="event_name" value="{{$event->name}}" required autofocus />
                        </div>

                        {{-- textarea.blade.phpの中身を反映 --}}
                        {{-- 詳細を記入するボックスの設置 --}}
                        {{-- <div>
                            <x-jet-label for="information" value="イベントの詳細" />
                            <x-textarea row="3" id="information" name="information" class="block mt-1 w-full">{{$event->information}}</x-textarea>
                        </div> --}}
                        
                        {{-- 各タブのサイズ設定 --}}
                        <div class="md:flex justify-between">
                        {{-- イベント日付・開始時間・終了時間タブの用意 --}}
                            <div class="mt-4">
                                <x-jet-label for="event_date" value="イベント日付" />
                                <x-jet-input id="event_date" class="block mt-1 w-full" type="text" name="event_date" value="{{$eventDate}}" required  />
                            </div>
                            

                            <div class="mt-4">
                                <x-jet-label for="start_time" value="開始時間" />
                                <x-jet-input id="start_time" class="block mt-1 w-full" type="text" name="start_time" value="{{$startTime}}" required/>
                            </div>

                            <div class="mt-4">
                                <x-jet-label for="end_time" value="終了時間" />
                                <x-jet-input id="end_time" class="block mt-1 w-full" type="text" name="end_time" value="{{$endTime}}" required />
                            </div>
                        </div>
                        {{-- 定員数、表示非表示、登録ボタンの設置 --}}
                        <div class="md:flex justify-between item-end">
                            <div class="mt-4">
                                <x-jet-label for="max_people" value="定員数" />
                                <x-jet-input id="max_people" class="block mt-1 w-full" type="number" name="max_people" value="{{$event->max_people}}" required />
                            </div>
                            <div class="mt-12 flex space-x-4 justify-around">
                                <input type="radio" name="is_visible" value="1" @if($event->is_visible === 1 ){ checked } @endif  />表示
                                <input type="radio" name="is_visible" value="0" @if($event->is_visible === 0 ){ checked } @endif />非表示
                            </div>
                           
                        </div>
                        <div>
                            <x-jet-label for="information" value="カルテ" class="mt-5"/>
                            <x-textarea row="3" id="information" name="information" class="block mt-1 w-full">{{$event->information}}</x-textarea>
                        </div>
                        <x-jet-button class="ml-1 mt-5">
                                更新する
                        </x-jet-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
