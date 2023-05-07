<?php

namespace Database\Seeders;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $myTime = Carbon::now();
        //
        $orders = [
            [
                'prefix' => Str::random(5),
                'field_id' => 1,
                'user_id' => 2,
                'boots_id' => null,
                'balls_id' => null,
                'name' => 'JURTI FC',
                'booking_time' => json_encode(['08:00', '09:00']),
                'duration' => 2,
                'booking_date' => $myTime->toDateString(),
                'status' => 'Pending',
            ],
            [
                'prefix' => Str::random(5),
                'field_id' => 1,
                'user_id' => 2,
                'boots_id' => null,
                'balls_id' => null,
                'name' => 'Sipil FC',
                'booking_time' => json_encode(['10:00']),
                'duration' => 2,
                'booking_date' => $myTime->toDateString(),
                'status' => 'Pending',
            ],
        ];

        foreach ($orders as $key => $value) {
            Order::create($value);
        }
    }
}
