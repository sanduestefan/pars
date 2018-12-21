<?php

use Illuminate\Database\Seeder;

class BattlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('battles')->insert([
            'experience' => 2,
            'gold' => 10,
            'life' => 200,
            'damage' => 1,
            'speed' => 2,
            'agility' => 1,
            'armour' => 3,
            'energy' => 5,
            'message' => 'custom message',
            'type' => 2
        ]);

        DB::table('battles')->insert([
            'experience' => 3,
            'gold' => 11,
            'life' => 210,
            'damage' => 2,
            'speed' => 3,
            'agility' => 1,
            'armour' => 1,
            'energy' => 2,
            'message' => 'custom message',
            'type' => 2
        ]);

        DB::table('battles')->insert([
            'experience' => 10,
            'gold' => 30,
            'life' => 50,
            'damage' => 3,
            'speed' => 4,
            'agility' => 5,
            'armour' => 0,
            'energy' => 2,
            'message' => 'custom message',
            'type' => 1
        ]);

        DB::table('battles')->insert([
            'experience' => 20,
            'gold' => 24,
            'life' => 60,
            'damage' => 4,
            'speed' => 5,
            'agility' => 6,
            'armour' => 1,
            'energy' => 3,
            'message' => 'custom message',
            'type' => 1
        ]);

    }


}
