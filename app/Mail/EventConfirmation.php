<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $examInfo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($examInfo)
    {
        $this->examInfo = $examInfo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('backend.email.event_confirmation');
    }
}
