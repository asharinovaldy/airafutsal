<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Fields;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class ScheduleController extends Controller
{
    //
    public function index(Request $request)
    {
        // get fields data
        $fields  = Fields::all();

        // get request from input
        $date = $request->query('date');
        $field = $request->query('fields');

        // get current date
        $currentDate = Carbon::now()->format('Y-m-d');

        // if form is filled, then return the eloquent
        if (!empty($date) && !empty($field)) {
            $orders = Order::where('booking_date', $date)->where('field_id', $field)->get();
        } else {
            // return null if form is empty
            $orders = null;
        }

        // return to view, bring several variable with compact function
        return view('user.schedule', compact('fields', 'orders', 'date', 'field'));
    }

    public function mySchedules()
    {
        $schedule = Order::where('user_id', Auth::user()->id)->get();
        $fields = Fields::all();
        return view('user.myschedule', compact('schedule', 'fields'));
    }

    public function data()
    {
        $schedule = Order::where('user_id', Auth::user()->id)->get();
        return DataTables::of($schedule)
            ->addIndexColumn()
            ->editColumn('action', function ($schedule) {
                return '<form action="' . route('user.schedules.delete', $schedule->id) . '" method="POST">
                    <a href="' . route('user.schedules.edit', [$schedule->prefix, $schedule->id]) . '" class="btn btn-primary" title="Edit"><i class="fas fa-pen"></i></a>
                    ' . csrf_field() . '
                    ' . method_field("DELETE") . '
                    <button title="Delete" type="submit" class="btn btn-link" onclick="return confirm(\'Are you sure?\')"> <i class="fas fa-trash"></i> </button>
                </form>';
            })
            ->make(true);
    }

    public function checkAvailabilityField(Request $request)
    {
        // dd($request->booking_time);
        $order = Order::where('booking_date', $request->booking_date)->get();
        // $order = Order::where('booking_date', $request->booking_date)->get()->count();
        return response()->json($order, 200);
    }

    public function store(Request $request)
    {
        // get time begin
        $time_begin = Carbon::parse($request->booking_time);

        // get duration
        $duration = $request->duration;

        // create end time according duration
        $time_end = date("H:i", strtotime($time_begin) + 60 * 60 * $duration);

        // parsing
        $time_end_parse =
            Carbon::parse($time_end);

        // array for storing the value of booking time
        $actual_time = [];

        // if duration 1 hour, then fill array actual time same as time begin
        if ($duration == 1) {
            $actual_time[] = $time_begin->toTimeString('minutes');
        } else {
            // if duration more then 1 hour, fill the array with looping time
            for ($i = $time_begin; $i < $time_end_parse; $i->addHour()) {
                $actual_time[] = $i->toTimeString('minutes');
            }
        }


        // dd(json_encode($actual_time));


        // validate form
        $request->validate([
            'field' => 'string|required',
            'booking_name' => 'string|required',
            'booking_name' => 'string|required',
            'duration' => 'numeric|required|min:1',
            'booking_date' => 'date|required'
        ]);

        $order = new Order();

        $order->prefix = Str::random(5);
        $order->field_id = $request->field;
        $order->user_id = Auth::user()->id;
        $order->name = $request->booking_name;
        $order->booking_time = json_encode($actual_time);
        $order->duration = $request->duration;
        $order->booking_date = $request->booking_date;

        $order->save();

        return redirect()->route('user.my-schedules');
    }

    public function edit(Request $request)
    {
    }

    public function destroy(Request $request)
    {
    }
}
