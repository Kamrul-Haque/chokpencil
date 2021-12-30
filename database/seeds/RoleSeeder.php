<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->title = "admin";
        $role->save();

        $role = new Role();
        $role->title = "instructor";
        $role->save();

        $role = new Role();
        $role->title = "student";
        $role->save();
    }
}
