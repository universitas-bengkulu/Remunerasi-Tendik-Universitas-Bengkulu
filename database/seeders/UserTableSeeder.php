<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        foreach (range(1,20) as $index) {
            DB::table('users')->insert([
                'unit_id'    =>  Unit::all()->random()->id,
                'nama_lengkap'    =>  $faker->name(),
                'slug'    =>  Str::slug($faker->name()),
                'password'    =>  bcrypt("password"),
                'email'     =>  $faker->email(),
                'role' =>  $faker->randomElement(['administrator','operator','verifikator','kepegawaian','pimpinan']),
                'status'    =>  $faker->randomElement(['aktif','nonaktif']),
            ]);
        }
    }
}
