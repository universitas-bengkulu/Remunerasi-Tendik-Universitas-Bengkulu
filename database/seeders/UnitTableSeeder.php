<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        foreach (range(1,10) as $index) {
            DB::table('units')->insert([
                'nm_unit'    =>  $faker->name(),
                'tingkatan' =>  $faker->randomElement(['unversitas','lembaga','fakultas']),
                'slug'    =>  Str::slug($faker->name()),
            ]);
        }
    }
}
