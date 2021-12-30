<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "ADMIN";
        $user->email = "admin@email.com";
        $user->password = Hash::make("123456789");
        $user->save();

        $user->admin()->create([
           'employee_id'=>10000001,
           'job_title'=>'Admin',
           'phone'=>'123456789',
           'dob'=>'20-09-1994',
           'nid'=>'123456789',
        ]);

        $role = Role::where('title', 'admin')->first();

        if($role)
            $user->roles()->sync($role, false);


        $user = new User();
        $user->name = "INSTRUCTOR";
        $user->email = "instructor@email.com";
        $user->password = Hash::make("123456789");
        $user->save();

        $user->instructor()->create([
           'uuid'=>Str::uuid()->toString(),
           'qualification'=>'Graduate',
           'institution'=>'Institution',
           'department'=>'Department',
           'designation'=>'Lecturer',
           'phone'=>'0123456789',
           'about'=>'20years of experience',
        ]);

        $role = Role::where('title', 'instructor')->first();

        if($role)
            $user->roles()->sync($role, false);


        $user = new User();
        $user->name = "STUDENT";
        $user->email = "student@email.com";
        $user->password = Hash::make("123456789");
        $user->study_level = "Higher Secondary";
        $user->save();

        $role = Role::where('title', 'student')->first();

        if($role)
            $user->roles()->sync($role, false);
    }
}
