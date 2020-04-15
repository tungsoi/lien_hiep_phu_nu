<?php

use Illuminate\Database\Seeder;
use App\Models\WeekPrize;
use App\Models\MemberExam;

class WeekPrizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MemberExam::truncate();
        for ($i = 0; $i < 3000; $i++) {
            MemberExam::create([
                'user_id'   =>  $i,
                'week_id'   =>  1,
                'answer'    =>  'test',
                'people_number' =>  rand(1450, 1550),
                'result'    =>  rand(0, 1)
            ]);
        }

    }
}
