<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TendikTableSeeder extends Seeder
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
            $name = $faker->name;
            $slug = Str::slug($name, '-');
            DB::table('tendiks')->insert([
                'jabatan_id'    =>  Jabatan::all()->random()->id,
                'unit_id'    =>  Unit::all()->random()->id,
                'user_id_absensi' => $faker->randomElement(['1','2','3','4','5','6','7','8','9','10','11']),
                'nm_lengkap' => $name,
                'slug' => $slug,
                'nip'    =>  $faker->randomNumber(5),
                'pangkat' => $faker->jobTitle,
                'golongan' => $faker->areaCode,
                'jenis_kepegawaian' => $faker->jobTitle,
                'jenis_kelamin' => $faker->randomElement(['L','P']),
                'kedekatan_hukum' => "PNS",
                'no_rekening' => $faker->randomNumber(5),
                'no_npwp' => $faker->randomNumber(5),
                'password'     => bcrypt('password'),
                'status'     => "aktif",
            ]);
        }
    }
}
