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
                'content'   =>  'Trị giá 500.000 VND',
                'level'     =>  1,
                'number'    =>  1
            ],
            [
                'content'   =>  'Trị giá 300.000 VND',
                'level'     =>  2,
                'number'    =>  2
            ],
            [
                'content'   =>  'Trị giá 200.000 VND',
                'level'     =>  3,
                'number'    =>  3
            ]
        ];

        foreach ($arr as $prize) {
            Prize::create($prize);
        }
    }
}
