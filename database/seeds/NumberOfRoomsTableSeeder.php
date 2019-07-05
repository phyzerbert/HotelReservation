<?php

use Illuminate\Database\Seeder;
use App\Models\NumberOfRoom;

class NumberOfRoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NumberOfRoom::create([
            'min' => 1,
            'max' => 2,
        ]);
        
        NumberOfRoom::create([
            'min' => 3,
            'max' => 4,
        ]);
        
        NumberOfRoom::create([
            'min' => 5,
            'max' => 6,
        ]);
        
        NumberOfRoom::create([
            'min' => 7,
            'max' => 8,
        ]);

    }
}
