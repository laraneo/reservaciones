<?php

use App\Draw;
use App\Event;
use App\Package;
use Illuminate\Database\Seeder;

class CreateDrawsSeeder extends Seeder
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
                'title' => 'Cancha 1', 
                'description' => '<br>', 
                'price' => 0, 
                'category_id' => 4, 
                'photo_id' => 24, 
                'duration' => 10,
                'category_type' => 1,
            ],
            [ 
                'title' => 'Cancha 2', 
                'description' => '<br>', 
                'price' => 0, 
                'category_id' => 4, 
                'photo_id' => 24, 
                'duration' => 10,
                'category_type' => 1,
            ],
            [ 
                'title' => 'Cancha 3', 
                'description' => '<br>', 
                'price' => 0, 
                'category_id' => 4, 
                'photo_id' => 24, 
                'duration' => 10,
                'category_type' => 1,
            ],
        ];
        foreach ($data as $element) {
            Package::create([
                'title' => $element['title'], 
                'description' => $element['description'], 
                'price' => $element['price'], 
                'category_id' => $element['category_id'], 
                'photo_id' => $element['photo_id'], 
                'duration' => $element['duration'],
            ]);
        }
    }
}
