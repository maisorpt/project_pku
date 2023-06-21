<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('salary_types')->delete();

        $data = [
            ['salary_amount' => 'Kurang dari Rp 500.000'],
            ['salary_amount' => 'Rp 500.000 - Rp 1.000.000'],
            ['salary_amount' => 'Rp 1.000.000 - Rp 2.000.000'],
            ['salary_amount' => 'Rp 2.000.000 - Rp 5.000.000'],
            ['salary_amount' => 'Rp 5.000.000 - Rp 10.000.000'],
            ['salary_amount' => 'Lebih dari Rp 10.000.000'],
        ];

        DB::table('salary_types')->insert($data);

    }
}
