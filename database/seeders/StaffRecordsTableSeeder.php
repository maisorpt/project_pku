<?php
namespace Database\Seeders;

use App\Models\ClassType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class MyClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('staff_records')->delete();
        $ct = ClassType::pluck('id')->all();

        $data = [
            ['user_id' => '1'],
            ['user_id' => '2'],
            ];

        DB::table('staff_records')->insert($data);

    }
}
