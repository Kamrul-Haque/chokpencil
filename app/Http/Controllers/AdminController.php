<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Mail\AccountCreationMail;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::paginate();
        return view('Admin.index', compact('admins'));
    }

    public function create()
    {
        return view('Admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
           'name'=>'required|string|min:5',
           'email'=>'required|email|unique:users',
           'employee_id'=>'required|integer|unique:admins',
           'job_title'=>'required|string',
           'phone'=>'required|digits:10|unique:admins',
           'dob'=>'required|date|before:01-01-2000',
           'nid'=>'required|digits_between:10,13|unique:admins',
           'address'=>'nullable|string|min:5',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $password = Str::uuid()->toString();
        $user->password = Hash::make($password);

        if ($user->save())
        {
            $role = Role::where('title', 'admin')->first();

            if($role)
                $user->roles()->sync($role, false);

            $admin = new Admin;
            $admin->user_id = $user->id;
            $admin->employee_id = $request->employee_id;
            $admin->job_title = $request->job_title;
            $admin->phone = $request->phone;
            $admin->dob = $request->dob;
            $admin->nid = $request->nid;
            $admin->address = $request->address;
            $admin->save();
        }

        Mail::to($user->email)->send(new AccountCreationMail($user, $password));

        return redirect()->route('admin.admin.index')->with('toast_success','Created Successfully');
    }

    public function edit(Admin $admin)
    {
        $admin = Admin::find($admin->id);
        return view('Admin.edit', compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name'=>'required|string|min:5',
            'email'=>'required|email|unique:users,email,'.$admin->user->id,
            'employee_id'=>'required|integer|unique:admins,employee_id,'.$admin->id,
            'job_title'=>'required|string',
            'phone'=>'required|digits:10|unique:admins,phone,'.$admin->id,
            'dob'=>'required|date|before:01-01-2000',
            'nid'=>'required|digits_between:10,13|unique:admins,nid,'.$admin->id,
            'address'=>'nullable|string|min:5',
        ]);

        $admin = Admin::find($admin->id);
        $admin->employee_id = $request->employee_id;
        $admin->job_title = $request->job_title;
        $admin->phone = $request->phone;
        $admin->dob = $request->dob;
        $admin->nid = $request->nid;
        $admin->address = $request->address;

        if ($admin->save())
        {
            $user = $admin->user;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
        }

        return redirect()->route('admin.admin.index')->with('toast_info','Updated Successfully');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();

        return redirect()->route('admin.admin.index')->with('toast_error','Record Deleted');
    }
}
