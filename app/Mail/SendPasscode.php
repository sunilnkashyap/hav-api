<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendPasscode extends Mailable
{
    use Queueable, SerializesModels;
    public $passcode;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($passcode)
    {
      $this->passcode = $passcode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Passcode for email verification.')
        ->view('mail.passcode')
        ->with(["passcode" => $this->passcode]);
    }
}
