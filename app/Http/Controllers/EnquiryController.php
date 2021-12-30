<?php

namespace App\Http\Controllers;

use App\Enquiry;
use App\Mail\EnquiryReplyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EnquiryController extends Controller
{
    public function index()
    {
        $enquiries = Enquiry::latest()->paginate(10);
        return view('Enquiry.index', compact('enquiries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|min:4',
            'email'=>'required|email',
            'phone'=>'nullable',
            'enquiry'=>'required|string|max:255'
        ]);

        $enquiry = new Enquiry();
        $enquiry->course_id = $request->course_id ?? null;
        $enquiry->name = $request->name;
        $enquiry->email = $request->email;
        $enquiry->phone = $request->phone;
        $enquiry->enquiry = $request->enquiry;
        $enquiry->save();

        return back()->with('toast_success', 'Enquiry placed successfully');
    }

    public function show(Enquiry $enquiry)
    {
        return view('Enquiry.show', compact('enquiry'));
    }

    public function destroy(Enquiry $enquiry)
    {
        $enquiry->delete();

        return back()->with('toast_error', 'Enquiry Deleted');
    }

    public function reply(Request $request, Enquiry $enquiry)
    {
        Mail::to($enquiry->email)->send(new EnquiryReplyMail($request->subject, $request->reply, $enquiry));

        return redirect()->route('dashboard')->with('toast_success','Mail Sent Successfully');
    }
}
