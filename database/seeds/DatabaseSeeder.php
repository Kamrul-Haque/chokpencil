<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(AdminsTableSeeder::class);
        // $this->call(StudentsTableSeeder::class);
        // $this->call(InstructorsTableSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
    }
}
