<?php

use App\Event;

use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 
                'description' => 'Evento Tipo Sorteo',
                'updated_at' => '2019-09-09 13:24:19',
                'created_at' => '2019-09-09 13:24:19',
                'time1' => '11:00:00',
                'time2' => '12:00:00',
                'date' => '2021-04-27 10:30:09',
                'event_type' => 2
            ]
        ];
        foreach ($data as $element) {
            Event::create([
                'description' => $element['description'],
                'updated_at' => $element['updated_at'],
                'created_at' => $element['created_at'],
                'time1' => $element['time1'],
                'time2' => $element['time2'],
                'date' => $element['date'],
                'event_type' => $element['event_type'],
            ]);
        }
    }
}
