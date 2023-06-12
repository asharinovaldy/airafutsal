<?php

namespace Database\Seeders;

use App\Models\Fields;
use Illuminate\Database\Seeder;

class FieldsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $field = [

            [
                'field_name' => 'Lapangan 1',
                'price_weekdays' => 150000,
                'price_weekends' => 180000,
                'price' => 150000,
            ],
            [
                'field_name' => 'Lapangan 2',
                'price_weekdays' => 150000,
                'price_weekends' => 180000,
                'price' => 150000,
            ]
        ];

        foreach ($field as $key => $value) {
            Fields::create($value);
        }
    }
}
