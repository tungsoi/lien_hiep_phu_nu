<?php

use Illuminate\Database\Seeder;
use App\Models\Prize;

class PrizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Prize::truncate();
        $arr = [
            [
                'content'   =>  'Trị giá 5.000.000 VND',
                'level'     =>  1,
                'number'    =>  1
            ],
            [
                'content'   =>  'Trị giá 3.000.000 VND',
                'level'     =>  2,
                'number'    =>  2
            ],
            [
                'content'   =>  'Trị giá 2.000.000 VND',
                'level'     =>  3,
                'number'    =>  3
            ],
            [
                'content'   =>  'Trị giá 1.000.000 VND',
                'level'     =>  4,
                'number'    =>  5
            ]
        ];

        foreach ($arr as $prize) {
            Prize::create($prize);
        }
    }
}
