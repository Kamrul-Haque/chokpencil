<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Instructor;
use App\Providers\RouteServiceProvider;
use App\Role;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'study_level' => ['required', 'string'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->study_level = $data['study_level'];
        $user->password = Hash::make($data['password']);

        if ($user->save())
        {
            $role = Role::where('title', 'student')->first();

            if($role)
                $user->roles()->sync($role, false);
        }

        return $user;
    }

    public function instructorForm()
    {
        return view('Instructor.create');
    }

    public function instructorCreate(Request $request)
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
        $user->password = Hash::make($request->password);

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

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
