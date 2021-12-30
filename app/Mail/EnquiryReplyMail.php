<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnquiryReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $enquiry;
    public $subject;
    public $reply;

    public function __construct($subject, $reply, $enquiry)
    {
        $this->subject = $subject;
        $this->reply = $reply;
        $this->enquiry = $enquiry;
    }

    public function build()
    {
        return $this->markdown('emails.EnquiryReply')->subject($this->subject);
    }
}
