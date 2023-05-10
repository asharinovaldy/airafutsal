<?php

namespace App\Http\Controllers;

use App\Models\Fields;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    //
    public function index(Request $request)
    {
        $fields  = Fields::all();
        $date = !empty($request->query('date')) ? $request->query('date') : Carbon::today()->toFormattedDateString();
        $field = $request->query('field');
        $currentDate = Carbon::today()->toFormattedDateString();
        // dd($date);
        if (!empty($date) && !empty($field)) {
            $orders = Order::where('booking_date', $date)->where('field_id', $field);
        } else {
            // $orders = Order::where('booking_date', $currentDate)->get();
            $orders = Order::all();
        }

        return view('schedules', compact('fields', 'orders', 'date', 'field'));
    }
}
