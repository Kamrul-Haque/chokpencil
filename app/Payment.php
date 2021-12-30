<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    /*public function matched()
    {
        $recievedPayments = ReceivedPayment::all();

        foreach ($recievedPayments as $recievedPayment)
        {
            if ($recievedPayment->method == $this->method)
                if($recievedPayment->account_no == $this->account_no)
                    if($recievedPayment->transaction_id == $this->transaction_id)
                        return true;
        }
        return false;
    }*/

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
