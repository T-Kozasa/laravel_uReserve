<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Services\EventService;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = Carbon::today(); 

        $reservedPeople = DB::table('reservations')
        ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
        ->whereNull('canceled_date') 
        ->groupBy('event_id'); 
        // dd($reservedPeople);


        $events = DB::table('events')
        ->leftJoinSub($reservedPeople, 'reservedPeople',
        function($join){
            $join->on('events.id', '=', 'reservedPeople.event_id');
            })
        ->whereDate('start_date', '>=' , $today) // 追加
        ->orderBy('start_date', 'asc') //開始日時順
        ->paginate(10); // 10件ずつ
        // ->get();
        // dd($events);
        
        return view('manager.events.index'
        ,compact('events')
        ); //変数をViewに渡す
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manager.events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEventRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {
        // $check = DB::table('events')
        // ->whereDate('start_date', $request['event_date']) // 日にち
        // ->whereTime('end_date' ,'>',$request['start_time'])
        // ->whereTime('start_date', '<', $request['end_time'])
        // ->exists(); // 存在確認

        // if($check){ // 存在したら
        //     session()->flash('status', 'この時間帯は既に他の予約が存在します。'); 
        //     return view('manager.events.create');
        //     }

        $check = EventService::checkEventDuplication(
            $request['event_date'],
            $request['start_time'],
            $request['end_time']
        );

        // $check = DB::table('events')
        // ->whereDate('start_date', $request['event_date']) // 日にち
        // ->whereTime('end_date' ,'>',$request['start_time'])
        // ->whereTime('start_date', '<', $request['end_time'])
        // ->exists(); // 存在確認

        // dd($check);
        if($check){ // 存在したら
            session()->flash('status', 'この時間帯は既に他の予約が存在します。');
            return view('manager.events.create');
            }
        
        $startDate = EventService::joinDateAndTime(
            $request['event_date'],
            $request['start_time']
        );
        $endDate = EventService::joinDateAndTime(
            $request['event_date'],
            $request['end_time']
        );

        // ddでちゃんとcreate.blade.phpの登録ボタンが稼働するかチェック
        // dd($request);
        // データベースの形上、dateとstarttimeを接続
        // $start = $request['event_date'] . " " . $request['start_time'];
        // Carbonで接続
        // $startDate = Carbon::createFromFormat(
        //     'Y-m-d H:i', $start );

        // $end = $request['event_date'] . " " . $request['end_time'];
            // Carbonで接続
            // $endDate = Carbon::createFromFormat(
            //     'Y-m-d H:i', $end );

        Event::create([
            'name' => $request['event_name'],
            'information' => $request['information'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'max_people' => $request['max_people'],
            'is_visible' => $request['is_visible'],
            ]);

        session()->flash('status', '登録okです');
        return to_route('events.index'); //名前付きルート
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\Event  $event
    //  * @return \Illuminate\Http\Response
    //  */
    public function show(Event $event)
    {
        $event = Event::findOrFail($event->id);
        $users = $event->users;

        $reservations = []; // 連想配列を作成
        foreach($users as $user){
            $reservedInfo = [
                'name' => $user->name,
                'number_of_people' => $user->pivot->number_of_people,
                'canceled_date' => $user->pivot->canceled_date
            ];
            array_push($reservations, $reservedInfo); // 連想配列に追加
        }
        // dd($reservations); 
        // dd($event, $users); 
        $eventDate = $event->eventDate;
        $startTime = $event->startTime;
        $endTime = $event->endTime;
        // dd($eventDate, $startTime, $endTime);
        return view('manager.events.show', compact('event','users','reservations','eventDate', 'startTime', 'endTime'));
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\Event  $event
    //  * @return \Illuminate\Http\Response
    //  */
    public function edit(Event $event)
    {
        $event = Event::findOrFail($event->id);
        $eventDate = $event->editEventDate;
        $startTime = $event->startTime;
        $endTime = $event->endTime;
        // dd($eventDate, $startTime, $endTime);
        return view('manager.events.edit', compact('event','eventDate', 'startTime', 'endTime'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEventRequest  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $check = EventService::countEventDuplication(
            $request['event_date'],
            $request['start_time'],
            $request['end_time']
        );

        if($check > 1){ // 存在したら
            session()->flash('status', 'この時間帯は既に他の予約が存在します。');
            $event = Event::findOrFail($event->id);
            $eventDate = $event->editEventDate;
            $startTime = $event->startTime;
            $endTime = $event->endTime;
            return view('manager.events.edit',
            compact('event','eventDate', 'startTime', 'endTime'));
            }
        
        $startDate = EventService::joinDateAndTime(
            $request['event_date'],
            $request['start_time']
        );
        $endDate = EventService::joinDateAndTime(
            $request['event_date'],
            $request['end_time']
        );

        $event = Event::findOrFail($event->id);
            $event->name = $request['event_name'];
            $event->information = $request['information'];
            $event->start_date = $startDate;
            $event->end_date = $endDate;
            $event->max_people = $request['max_people'];
            $event->is_visible = $request['is_visible'];
            $event->save();

        session()->flash('status', '更新しました');
        return to_route('events.index'); //名前付きルート
    }


    public function past()
    {
        $today = Carbon::today();

        $reservedPeople = DB::table('reservations')
        ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
        ->whereNull('canceled_date') 
        ->groupBy('event_id'); 

        $events = DB::table('events')
        ->leftJoinSub($reservedPeople, 'reservedPeople',
        function($join){
            $join->on('events.id', '=', 'reservedPeople.event_id');
            })
        ->whereDate('start_date', '<', $today )
        ->orderBy('start_date', 'desc')
        ->paginate(10);

        return view('manager.events.past', compact('events'));
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\Event  $event
    //  * @return \Illuminate\Http\Response
    //  */
    public function destroy(Event $event)
    {
        //
    }
}
