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
        DB::table('my_classes')->delete();
        $ct = ClassType::pluck('id')->all();

        $data = [
            ['name' => 'Baby', 'class_type_id' => $ct[2]],
            ['name' => 'Top', 'class_type_id' => $ct[2]],
            ['name' => 'P1', 'class_type_id' => $ct[2]],
            ['name' => 'P2', 'class_type_id' => $ct[3]],
            ['name' => 'P3', 'class_type_id' => $ct[3]],
            ['name' => 'P4', 'class_type_id' => $ct[4]],
            ['name' => 'p5', 'class_type_id' => $ct[4]],
            ['name' => 'P6', 'class_type_id' => $ct[5]],
            ['name' => 'P7', 'class_type_id' => $ct[5]],
            ['name' => 'P8', 'class_type_id' => $ct[5]],
        ];

        DB::table('my_classes')->insert($data);
    }
}
