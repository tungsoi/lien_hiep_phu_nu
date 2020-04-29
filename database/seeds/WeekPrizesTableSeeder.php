<?php

use Illuminate\Database\Seeder;
use App\Models\WeekPrize;
use App\Models\MemberExam;
use App\Models\Week;

class WeekPrizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Week::truncate();
        // WeekPrize::truncate();
        // MemberExam::truncate();

        for ($i = 0; $i < 10000; $i++) {
            MemberExam::create([
                'user_id'   =>  rand(1, 2274),
                'week_id'   =>  2,
                'answer'    =>  'test',
                'people_number' =>  rand(4000, 6000),
                'result'    =>  rand(0, 1)
            ]);
        }

    }
}
