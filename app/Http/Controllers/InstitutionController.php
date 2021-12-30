<?php

namespace App\Http\Controllers;

use App\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class InstitutionController extends Controller
{
    public function index()
    {
        $institutions = Institution::orderBy('name')->paginate(10);
        return view('Institution.index',compact('institutions'));
    }

    public function create()
    {
        return view('Institution.create');
    }

    public function store(Request $request)
    {
        $request->validate([
           'name'=>'required|string|min:5',
           'email'=>'required|email|unique:institutions,email',
           'phone'=>'required|digits:10|unique:institutions,phone',
           'lower_level'=>'required',
           'upper_level'=>'required',
           'logo'=>'nullable|file|max:2024',
        ]);

        $institution = new Institution;
        $institution->name = $request->name;
        $institution->email = $request->email;
        $institution->phone = $request->phone;
        $institution->address = $request->address;
        $institution->study_level_lower = $request->lower_level;
        $institution->study_level_upper = $request->upper_level;

        if ($request->hasFile('logo'))
        {
            $path = $request->file('logo')->storeAs('Institution', $request->file('logo')->getClientOriginalName());
            $institution->logo_path = 'storage/'.$path;
        }

        $institution->save();

        return redirect()->route('admin.institution.index')->with('toast_success', 'Successfully Created!');
    }

    public function edit(Institution $institution)
    {
        $institution = Institution::find($institution->id);
        return view('Institution.edit',compact('institution'));
    }

    public function update(Request $request, Institution $institution)
    {
        $request->validate([
            'name'=>'required|string|min:5',
            'email'=>'required|email|unique:institutions,email,'.$institution->id,
            'phone'=>'required|digits:10|unique:institutions,phone,'.$institution->id,
            'lower_level'=>'required',
            'upper_level'=>'required',
            'logo'=>'nullable|file|max:2024',
        ]);

        $institution = Institution::find($institution->id);
        $institution->name = $request->name;
        $institution->email = $request->email;
        $institution->phone = $request->phone;
        $institution->address = $request->address;
        $institution->study_level_lower = $request->lower_level;
        $institution->study_level_upper = $request->upper_level;
        $oldLogo = $institution->getOriginal('logo_path');

        if ($request->hasFile('logo'))
        {
            if (File::exists($oldLogo))
            {
                File::delete($oldLogo);
            }

            $path = $request->file('logo')->storeAs('Institution', $request->file('logo')->getClientOriginalName());
            $institution->logo_path = 'storage/'.$path;
        }

        $institution->save();

        return redirect()->route('admin.institution.index')->with('toast_info', 'Successfully Updated!');
    }

    public function destroy(Institution $institution)
    {
        $institution = Institution::find($institution->id);
        $logo = $institution->getOriginal('logo_path');

        if (File::exists($logo))
        {
            File::delete($logo);
        }

        $institution->delete();

        return redirect()->route('admin.institution.index')->with('toast_error', 'Record Deleted!');
    }
}
