<?php

use Illuminate\Database\Seeder;
use App\Models\Member;

class MembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Member::create([
            'mobile_phone'  =>  '0345513889',
            'password'      =>  bcrypt('123456')
        ]);
    }
}
