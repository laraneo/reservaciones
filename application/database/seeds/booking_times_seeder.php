<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class booking_times_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('booking_times')->insert([
            'id' => 1,
            'day' => __('backend.mon'),
            'opening_time' => "08:00 AM",
            'closing_time' => "08:00 PM",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('booking_times')->insert([
            'id' => 2,
            'day' => __('backend.tue'),
            'opening_time' => "08:00 AM",
            'closing_time' => "08:00 PM",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('booking_times')->insert([
            'id' => 3,
            'day' => __('backend.wed'),
            'opening_time' => "08:00 AM",
            'closing_time' => "08:00 PM",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('booking_times')->insert([
            'id' => 4,
            'day' => __('backend.thu'),
            'opening_time' => "08:00 AM",
            'closing_time' => "08:00 PM",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('booking_times')->insert([
            'id' => 5,
            'day' => __('backend.fri'),
            'opening_time' => "08:00 AM",
            'closing_time' => "08:00 PM",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('booking_times')->insert([
            'id' => 6,
            'day' => __('backend.sat'),
            'opening_time' => "08:00 AM",
            'closing_time' => "08:00 PM",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('booking_times')->insert([
            'id' => 7,
            'day' => __('backend.sun'),
            'opening_time' => "08:00 AM",
            'closing_time' => "08:00 PM",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
