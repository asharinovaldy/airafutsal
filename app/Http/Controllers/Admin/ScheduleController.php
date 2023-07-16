<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ball;
use App\Models\Boots;
use App\Models\Fields;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

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
        $boots = Boots::all();
        $balls = Ball::all();
        return view('admin.schedules', compact('schedule', 'fields', 'boots', 'balls'));
    }

    public function data()
    {
        $schedule = Order::all();
        return DataTables::of($schedule)
            ->addIndexColumn()
            ->editColumn('action', function ($schedule) {
                return '<form action="' . route('admin.schedules.delete', $schedule->id) . '" method="POST">
                    <a href="' . route('admin.detail', [$schedule->prefix]) . '" class="btn btn-primary" title="Detail">Detail</a>
                    ' . csrf_field() . '
                    ' . method_field("DELETE") . '
                    <button title="Delete" type="submit" class="btn btn-danger" onclick="return confirm(\'Are you sure?\')"> Delete </button>
                </form>';
            })
            ->make(true);
    }

    public function store(Request $request){
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

        // get data by booking date and field id
        $dataOrder = Order::where('field_id', $request->field)->where('booking_date', $request->booking_date)->get();
        $timeAvailable = [];
        foreach ($dataOrder as $key => $item) {
            $timeAvailable = json_decode($item->booking_time);
        }

        // get price fields
        $field = Fields::select('price')->where('id', $request->field)->first();

         // handle boots if user make an order
         $boot_price = null;
         $ball_price = null;

        if ($request->filled('boots') && $request->filled('balls') ){
            // get value from request
            $boots = Boots::findOrFail($request->boots);
            $balls = Ball::findOrFail($request->balls);
            $quantity_boots = $request->quantity_boots;
            $quantity_balls = $request->quantity_balls;

            // get the price
            $boot_price = $boots->price * $quantity_boots;
            $ball_price = $balls->price * $quantity_balls;

            // set total amount
            $total_amount = ($field->price * $duration) + ($boot_price + $ball_price);

            // update stock
            $update_stock_boots = $boots->stock - (int) $quantity_boots;
            $boots->update(['stock' => $update_stock_boots]);
            $update_stock_balls = $balls->stock - (int) $quantity_balls;
            $balls->update(['stock' => $update_stock_balls]);

        } else if ($request->filled('boots')) {
            // get value from request
            $boots = Boots::findOrFail($request->boots);
            $quantity_boots = $request->quantity_boots;

            // get the price
            $boot_price = $boots->price * $quantity_boots;

            // set total amount
            $total_amount = ($field->price * $duration) + $boot_price;

            // update stock
            $update_stock_boots = $boots->stock - (int) $quantity_boots;
            $boots->update(['stock' => $update_stock_boots]);

        } else if ($request->filled('balls')){
            // get value from request
            $balls = Ball::findOrFail($request->balls);
            $quantity_balls = $request->quantity_balls;

            // get the price
            $ball_price = $balls->price * $quantity_balls;

            // set total amount
            $total_amount = ($field->price * $duration) + $ball_price;

            // update stock
            $update_stock_balls = $balls->stock - (int) $quantity_balls;
            $balls->update(['stock' => $update_stock_balls]);

        } else {
            // total amount = price field * duration
            $total_amount = $field->price * $duration;
        }

        // comparing booking time
        $timeComparison = array_intersect($actual_time, $timeAvailable);

        // if booking time is available, then store the data to database
        if (!$timeComparison) {
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
            $order->boots_id = $request->boots;
            $order->balls_id = $request->balls;
            $order->user_id = Auth::user()->id;
            $order->name = $request->booking_name;
            $order->booking_time = json_encode($actual_time);
            $order->duration = $request->duration;
            $order->booking_date = $request->booking_date;
            $order->total_amount = $total_amount;

            if ($request->payment === 'Transfer'){
                $order->status = 'Pending';
            } else if ($request->payment === 'Cash') {
                $order->status = 'Cash';
            }

            $order->save();

            Alert::success('Success', 'Terimakasih, lapangan telah dibooking. Untuk melanjutkan pembayaran, klik tombol detail di halaman.');
            return redirect()->route('admin.schedules');
        } else {
            // return error message if field is booked
            Alert::error('Error', 'Mohon maaf, jam bermain yang anda booking sudah terisi. Silahkan booking di jam lain');
            return redirect()->route('admin.schedules');
        }
    }

    public function detail($prefix){
        $order = Order::where('prefix', $prefix)->first();
        $price_field = Fields::select('price')->where('id', $order->field_id)->first();

        return view('admin.edit', compact('order', 'price_field'));
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        if($order){
            Alert::success('Success', 'Data Berhasil Dihapus!');
            return redirect()->route('admin.schedules');
        }else{
            Alert::error('Error', 'Data Gagal Dihapus!');
            return redirect()->route('admin.schedules');
        }
    }
}
