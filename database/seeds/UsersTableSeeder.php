<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('users')->truncate();
        $users = [
            [
                'name' => 'Mohamed Zayed',
                'email' => 'mohamedzayed709@yahoo.com',
                'password' => bcrypt('123123'),
            ],
            [
                'name' => 'Mohamed Luffy',
                'email' => 'mohamedluffy@yahoo.com',
                'password' => bcrypt('123123'),
            ],
        ];
        DB::table('users')->insert($users);
    }
}
