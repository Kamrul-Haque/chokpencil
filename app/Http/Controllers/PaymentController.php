<?php

namespace App\Http\Controllers;

use App\Course;
use App\Notifications\PaymentConfirmed;
use App\Notifications\PaymentReceived;
use App\Notifications\PaymentRejected;
use App\Payment;
use App\PaymentInfo;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::paginate(10);
        return view('Payment.index', compact('payments'));
    }

    public function create(Course $course)
    {
        $this->authorize('create', [Payment::class, $course]);

        $paymentInfos = PaymentInfo::all();

        return view('Payment.create', compact('course','paymentInfos'));
    }

    public function store(Course $course, Request $request)
    {
        $this->authorize('create', [Payment::class, $course]);

        $request->validate([
           'type'=>'required',
           'acc'=>'required|digits:10',
           'trxid'=>'required|string|unique:payments,transaction_id',
        ]);

        $payment = new Payment();
        $payment->course_id = $course->id;
        $payment->method = $request->type;
        $payment->user_id = auth()->user()->id;
        $payment->account_no = $request->acc;
        $payment->transaction_id = $request->trxid;
        $payment->amount = $course->fee;
        $payment->reference = $request->reference;
        $payment->save();

        $payment->user->notify(new PaymentReceived($payment));

        return redirect()->route('dashboard')->with('toast_success','Payment saved successfully!');
    }

    public function edit(Course $course, Payment $payment)
    {
        $this->authorize('update', $payment);

        return view('Payment.edit', compact('course','payment'));
    }

    public function update(Request $request, Course $course, Payment $payment)
    {
        $this->authorize('update', $payment);

        $request->validate([
            'acc'=>'required|digits:10',
            'trxid'=>'required|string|unique:payments,transaction_id,'.$payment->id,
        ]);

        $payment->account_no = $request->acc;
        $payment->transaction_id = $request->trxid;
        $payment->reference = $request->reference;
        $payment->is_edited = true;
        $payment->save();

        return redirect()->route('dashboard')->with('toast_info','Payment information updated!');
    }

    public function destroy(Payment $payment)
    {
        $payment->needs_verification = false;
        $payment->save();

        $payment->user->notify(new PaymentRejected($payment));

        return redirect()->route('admin.payment.index')->with('toast_info','Payment Rejected!');
    }

    public function verify(Course $course, Payment $payment)
    {
        $payment->is_verified = true;
        $payment->needs_verification = false;
        $payment->save();

        if ($course->wishlists()->where('user_id',$payment->user->id)->first())
        {
            $course->wishlists()->where('user_id',$payment->user->id)->first()->delete();
        }

        $course->students()->syncWithoutDetaching($payment->user->id);

        $payment->user->notify(new PaymentConfirmed($payment));

        return redirect()->route('admin.payment.index')->with('toast_info','Payment Verified!');
    }
}
