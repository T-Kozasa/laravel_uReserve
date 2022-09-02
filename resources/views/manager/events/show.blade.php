<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            イベントの詳細
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

                <form method="get" action="{{ route('events.edit', ['event' => $event->id])}}">
                    {{-- @csrf --}}
                    
                    {{-- イベント名タブ --}}
                    <div>
                        <x-jet-label for="event_name" value="予約番号" />
                        {{$event ->name}}
                    </div>

                    {{-- textarea.blade.phpの中身を反映 --}}
                    {{-- 詳細を記入するボックスの設置 --}}
                    {{-- <div>
                        <x-jet-label for="information" value="予約の詳細" />
                        {!! nl2br(e($event->information)) !!} 
                    </div> --}}
                    
                    {{-- 各タブのサイズ設定 --}}
                    <div class="md:flex justify-between">
                    {{-- イベント日付・開始時間・終了時間タブの用意 --}}
                        <div class="mt-4">
                            <x-jet-label for="event_date" value="予約日" />
                            {{ $event->eventDate }} 
                        </div>
                        

                        <div class="mt-4">
                            <x-jet-label for="start_time" value="開始時間" />
                            {{ $event->startTime }} 
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="end_time" value="終了時間" />
                             {{ $event->endTime }}
                        </div>
                    </div>
                    {{-- 定員数、表示非表示、登録ボタンの設置 --}}
                    <div class="md:flex justify-between item-end">
                        <div class="mt-4">
                            <x-jet-label for="max_people" value="定員数" />
                            {{ $event->max_people }}
                        </div>
                        <div class="flex space-x-4 justify-around mt-8">
                            @if($event->is_visible)
                                表示中
                            @else
                                非表示
                            @endif
                        </div>
                    </div>
                    <div>
                        <x-jet-label for="information" value="カルテ" class="mt-6" />
                        {!! nl2br(e($event->information)) !!}
                    </div>
                    @if($event->eventDate >= \Carbon\Carbon::today()->format('Y年m月d日'))
                        <x-jet-button class="mt-10">
                            編集する
                        </x-jet-button>
                    @endif
                </form>
            </div>
                {{-- 日付 <input type="text" id="event_date" name="event_date">
                開始時間 <input type="text" id="start_time" name="start_time">
                終了時間 <input type="text" id="end_time" name="end_time"> --}}
            </div>
        </div>
    </div>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg"> <div class="max-w-2xl mx-auto">
                @if (!$users->isEmpty())
                予約情報
                <table class="table-auto w-full text-left whitespace-no-wrap">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">予約者名</th>
                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">予約人数</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                        @if(is_null($reservation['canceled_date']))
                        <tr>
                            <td class="px-4 py-3">{{ $reservation['name'] }}</td>
                            <td class="px-4 py-3">{{ $reservation['number_of_people']}}</td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
