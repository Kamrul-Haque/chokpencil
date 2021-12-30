<?php

namespace App\Http\Controllers;

use App\Course;
use App\PaymentInfo;
use Illuminate\Http\Request;

class PaymentInfoController extends Controller
{
    public function index()
    {
        $paymentInfos = PaymentInfo::paginate();
        return view('PaymentInfo.index', compact('paymentInfos'));
    }

    public function create()
    {
        return view('PaymentInfo.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'service'=>'required',
            'acc'=>'required|digits:10',
            'type'=>'required',
        ]);

        $paymentInfo = new PaymentInfo();
        $paymentInfo->method = $request->service;
        $paymentInfo->account_no = $request->acc;
        $paymentInfo->account_type = $request->type;
        $paymentInfo->save();

        return redirect()->route('admin.payment-info.index')->with('toast_success','Created Successfully');
    }

    public function edit($paymentInfo)
    {
        $paymentInfo = PaymentInfo::find($paymentInfo);

        return view('PaymentInfo.edit',compact('paymentInfo'));
    }

    public function update(Request $request, $paymentInfo)
    {
        $request->validate([
            'service'=>'required',
            'acc'=>'required|digits:10',
            'type'=>'required',
        ]);

        $paymentInfo = PaymentInfo::find($paymentInfo);
        $paymentInfo->method = $request->service;
        $paymentInfo->account_no = $request->acc;
        $paymentInfo->account_type = $request->type;
        $paymentInfo->save();

        return redirect()->route('admin.payment-info.index')->with('toast_info','Successfully Updated');
    }

    public function destroy($paymentInfo)
    {
        $paymentInfo = PaymentInfo::find($paymentInfo);

        $paymentInfo->delete();

        return redirect()->route('admin.payment-info.index')->with('toast_error','Record Deleted');
    }
}
