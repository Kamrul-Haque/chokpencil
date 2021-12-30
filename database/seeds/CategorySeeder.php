<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new \App\Category();
        $category->name = "Physics";
        $category->save();

        $category = new \App\Category();
        $category->name = "Chemistry";
        $category->save();

        $category = new \App\Category();
        $category->name = "Biology";
        $category->save();

        $category = new \App\Category();
        $category->name = "Computer Science";
        $category->save();
    }
}
