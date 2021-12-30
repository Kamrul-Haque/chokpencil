<?php

namespace App\Http\Controllers;

use App\Mail\AccountCreationMail;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $students = User::doesntHave('admin')->doesntHave('instructor')->paginate();

        return view('Student.index', compact('students'));
    }

    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users',
            'study_level'=>'required',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $password = Str::uuid()->toString();
        $user->password = Hash::make($password);
        $user->study_level = $request->study_level;

        if ($user->save())
        {
            $role = Role::where('title', 'student')->first();

            if($role)
                $user->roles()->sync($role, false);
        }

        Mail::to($user->email)->send(new AccountCreationMail($user, $password));

        return redirect()->route('admin.user.index')->with('toast_success', 'Created Successfully');
    }

    public function edit(User $user)
    {
        return view('Student.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users,email,'.$user->id,
            'study_level'=>'required',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->study_level = $request->study_level;
        $user->save();

        return redirect()->route('profile')->with('toast_info', 'Updated Successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.user.index')->with('toast_error', 'Record Deleted');
    }
}
