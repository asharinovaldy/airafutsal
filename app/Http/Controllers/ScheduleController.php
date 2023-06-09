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
        return view('schedules', compact('fields', 'orders', 'date', 'field'));
    }
}
