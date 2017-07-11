<?php

use Illuminate\Database\Seeder;

class CategouiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('categories')->truncate();
        $categories = [
            [
                'name' => 'programming',
                'image' => 'images/cats/pro.jpg',
                'description' => 'programming programming programming programming programming programming programming programming',
            ],
            [
                'name' => 'design',
                'image' => 'images/cats/design.jpg',
                'description' => 'design design design design design design design design design design design design design design design ',
            ],
        ];
        DB::table('categories')->insert($categories);
    }
}
