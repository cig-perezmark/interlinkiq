<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param array $details
     */
    public $details;
    public $emailSubject;

    public function __construct($details, $emailSubject)
    {
        $this->details = $details;
        $this->emailSubject = $emailSubject;
    }

    public function build()
    {
        return $this->subject($this->emailSubject)
                    ->html('<p>' . $this->details['message'] . '</p>');
    }

}
