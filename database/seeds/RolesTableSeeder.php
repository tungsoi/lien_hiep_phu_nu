<?php

use Illuminate\Database\Seeder;

use Brazzer\Admin\Auth\Database\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();

        Role::create([
            'name'  =>  'Administrator',
            'slug'  =>  'administrator'
        ]);

        Role::create([
            'name'  =>  'Guest',
            'slug'  =>  'guest'
        ]);
    }
}
