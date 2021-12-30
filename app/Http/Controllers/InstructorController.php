<?php

namespace App\Http\Controllers;

use App\Instructor;
use App\Mail\AccountCreationMail;
use App\Notifications\AccountVerified;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InstructorController extends Controller
{
    public function index()
    {
        $instructors = Instructor::paginate();
        return view('Instructor.index',compact('instructors'));
    }

    public function create()
    {
        return view('Instructor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
           'name'=>'required',
           'email'=>'required|email|unique:users',
           'password'=>'required|min:8|confirmed',
           'password_confirmation'=>'required',
           'designation'=>'required',
           'department'=>'required',
           'institution'=>'required',
           'phone'=>'required|digits:10|unique:instructors',
           'about'=>'nullable|string|min:5',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $password = Str::uuid()->toString();
        $user->password = Hash::make($password);

        if ($user->save())
        {
            $role = Role::where('title', 'instructor')->first();

            if($role)
                $user->roles()->sync($role, false);

            $instructor = new Instructor();
            $instructor->user_id = $user->id;
            $instructor->UUID = str::uuid()->toString();
            $instructor->qualification = $request->qualification;
            $instructor->designation = $request->designation;
            $instructor->department = $request->department;
            $instructor->institution = $request->institution;
            $instructor->phone = $request->phone;
            $instructor->address = $request->address;
            $instructor->about = $request->about;
            $instructor->save();
        }

        Mail::to($user->email)->send(new AccountCreationMail($user, $password));

        return redirect()->route('admin.instructor.index')->with('toast_success','Created Successfully');
    }

    public function show(Instructor $instructor)
    {
        $instructor = Instructor::find($instructor->id);
        return view('Instructor.show', compact('instructor'));
    }

    public function edit(Instructor $instructor)
    {
        $instructor = Instructor::find($instructor->id);
        return view('Instructor.edit', compact('instructor'));
    }

    public function update(Request $request, Instructor $instructor)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'.$instructor->user->id,
            'designation'=>'required',
            'department'=>'required',
            'institution'=>'required',
            'phone'=>'required|digits:10|unique:instructors,phone,'.$instructor->id,
        ]);

        $instructor = Instructor::find($instructor->id);
        $instructor->designation = $request->designation;
        $instructor->department = $request->department;
        $instructor->institution = $request->institution;
        $instructor->phone = $request->phone;
        $instructor->address = $request->address;
        $instructor->about = $request->about;

        if ($instructor->save())
        {
            $user = $instructor->user;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
        }

        return redirect()->route('admin.instructor.index')->with('toast_info','Updated Successfully');
    }

    public function destroy(Instructor $instructor)
    {
        $instructor = Instructor::find($instructor->id);
        $instructor->delete();

        return redirect('instructor')->with('toast_error','Record Deleted');
    }

    public function verify(Instructor $instructor)
    {
        $instructor->is_verified = true;
        $instructor->save();

        $instructor->user->notify(new AccountVerified());

        return redirect()->route('admin.instructor.index')->with('toast_info', 'Instructor Account Verified');
    }
}
