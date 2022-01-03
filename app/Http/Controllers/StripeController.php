<?php

namespace App\Http\Controllers;

use App\Course;
use App\Payment;
use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\CardException;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function create(Course $course)
    {
        return view('Payment.stripe', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $request->validate([
            'name_on_card'=>'required|string|min:4',
            'reference'=>'required|string|min:4',
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));
        try {
            $payment = Charge::create ([
                "amount" => $course->fee*100,
                "currency" => $course->currency,
                "source" => $request->stripeToken,
                "description" => "Enrollment Fee",
                "metadata"=>[
                    "reference"=>$request->reference,
                    "date"=>today()->toDateString()
                ]
            ]);
        }
        catch(CardException $exception)
        {
            return back()->with('toast_error','Card Error');
        }
        catch (ApiErrorException $exception)
        {
            return back()->with('toast_error','Session Expired. Please Try Again');
        }

        Payment::create([
            'user_id'=>auth()->user()->id,
            'course_id'=>$course->id,
            'method'=>$payment->payment_method_details->card->brand,
            'account_no'=>$payment->payment_method_details->card->last4,
            'reference'=>$request->reference,
            'transaction_id'=>$payment->balance_transaction,
            'amount'=>$course->fee,
            'is_verified'=>true,
            'needs_verification'=>false
        ]);

        if ($course->wishlists()->where('user_id', auth()->user()->id)->first())
        {
            $course->wishlists()->where('user_id', auth()->user()->id)->first()->delete();
        }

        $course->students()->syncWithoutDetaching(auth()->user()->id);

        return redirect()->route('module.index',$course)->with('toast_success','Payment Received Successfully');
    }
}
