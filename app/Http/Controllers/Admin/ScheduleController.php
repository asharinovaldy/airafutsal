<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fields;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ScheduleController extends Controller
{
    //
    public function index(Request $request){
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
        return view('admin.booking', compact('fields', 'orders', 'date', 'field'));
    }

    public function mySchedules()
    {
        $schedule = Order::all();
        $fields = Fields::all();
        return view('admin.schedules', compact('schedule', 'fields'));
    }

    public function data()
    {
        $schedule = Order::all();
        return DataTables::of($schedule)
            ->addIndexColumn()
            ->editColumn('action', function ($schedule) {
                return '<form action="' . route('user.schedules.delete', $schedule->id) . '" method="POST">
                    <a href="' . route('admin.edit', [$schedule->prefix]) . '" class="btn btn-primary" title="Detail">Detail</a>
                    ' . csrf_field() . '
                    ' . method_field("DELETE") . '
                    <button title="Delete" type="submit" class="btn btn-danger" onclick="return confirm(\'Are you sure?\')"> Delete </button>
                </form>';
            })
            ->make(true);
    }

    public function edit($prefix){
        $order = Order::where('prefix', $prefix)->first();
        $price_field = Fields::select('price')->where('id', $order->field_id)->first();

        return view('admin.edit', compact('order', 'price_field'));
    }
}
