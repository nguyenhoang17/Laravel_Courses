<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('courses')-> truncate();
        
        $courses = [
            [
                'name' => 'minh',
                'category_id' => 1,
                'staff_id' => 2,
                'image' => 'hi',
                'video' => 'video',
                'type' => 3,
                'file'=> 'min.doc',
                'key' => 'min',
                'start_time' => '2017-12-31',
                'end_time' => '2017-12-31',
                'description' => 'minh cute',
                'status' => 1,
                'is_featured' => 4,
                'publiced_at' => '2017-12-31',
                'price' => 200000
            ],
            [
                'name' => 'php',
                'category_id' => 2,
                'staff_id' => 1,
                'image' => 'hi',
                'video' => 'video',
                'type' => 9,
                'file'=> 'min.doc',
                'key' => 'min',
                'start_time' => '2017-12-31',
                'end_time' => '2017-12-31',
                'description' => 'quỳnh cute hihi',
                'status' => 0,
                'is_featured' => 7,
                'publiced_at' => '2017-12-31',
                'price' => 3000000
            ],
            [
                'name' => 'frontend',
                'category_id' => 1,
                'staff_id' => 1,
                'image' => 'lolo',
                'video' => 'siu nhan',
                'type' => 3,
                'file'=> 'min.doc',
                'key' => 'bwm',
                'start_time' => '2017-12-31',
                'end_time' => '2017-12-31',
                'description' => 'minh cute hì hì',
                'status' => 0,
                'is_featured' => 12,
                'publiced_at' => '2017-12-31',
                'price' => 345500000
            ],
            [
                'name' => 'php',
                'category_id' => 2,
                'staff_id' => 2,
                'image' => 'lolo',
                'video' => 'siu nhan',
                'type' => 2,
                'file'=> 'min.doc',
                'key' => 'bwm',
                'start_time' => '2017-12-31',
                'end_time' => '2017-12-31',
                'description' => 'minh cute hì hì',
                'status' => 0,
                'is_featured' => 19,
                'publiced_at' => '2017-12-31',
                'price' => 345500000
            ],
            [
                'name' => 'lol',
                'category_id' => 1,
                'staff_id' => 2,
                'image' => 'lolo',
                'video' => 'siu nhan',
                'type' => 8,
                'file'=> 'min.doc',
                'key' => 'bwm',
                'start_time' => '2017-12-31',
                'end_time' => '2017-12-31',
                'description' => 'minh cute hì hì',
                'status' => 0,
                'is_featured' => 99,
                'publiced_at' => '2017-12-31',
                'price' => 345500000
            ],
            [
                'name' => 'min',
                'category_id' => 1,
                'staff_id' => 2,
                'image' => 'lolo',
                'video' => 'siu nhan',
                'type' => 3,
                'file'=> 'min.doc',
                'key' => 'bwm',
                'start_time' => '2017-12-31',
                'end_time' => '2017-12-31',
                'description' => 'minh cute hì hì',
                'status' => 0,
                'is_featured' => 12,
                'publiced_at' => '2017-12-31',
                'price' => 345500000
            ],
            [
                'name' => 'huhu',
                'category_id' => 2,
                'staff_id' => 2,
                'image' => 'lolo',
                'video' => 'siu nhan',
                'type' => 3,
                'file'=> 'min.doc',
                'key' => 'bwm',
                'start_time' => '2017-12-31',
                'end_time' => '2017-12-31',
                'description' => 'minh cute hì hì',
                'status' => 0,
                'is_featured' => 12,
                'publiced_at' => '2017-12-31',
                'price' => 345500000
            ],
        ];

        foreach($courses as $course)
        {
            DB:: table('courses')-> insert($course); 
        }
    }
}
