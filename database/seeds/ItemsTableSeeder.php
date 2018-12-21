<?php

use Illuminate\Database\Seeder;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            'name' => 'Sword',
            'description' => 'The best sword',
            'damage' => 20,
            'speed' => 30,
            'agility' => 25,
            'life' => 0,
            'image' => 'sword.png',
        ]);
        DB::table('items')->insert([
            'name' => 'Axe',
            'description' => 'The best axe',
            'damage' => 35,
            'speed' => 15,
            'agility' => 15,
            'life' => 10,
            'image' => 'axe.png'
        ]);
        DB::table('items')->insert([
            'name' => 'Mace',
            'description' => 'The best mace',
            'damage' => 40,
            'speed' => 10,
            'agility' => 10,
            'life' => 15,
            'image' => 'mace.png'
        ]);
    }
}

