<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ThankYouForResponse extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $questionnaire;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $questionnaire)
    {
        $this->user = $user;
        $this->questionnaire = $questionnaire;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.thank_you_for_response')
                    ->subject('Thank you for your response!')
                    ->with([
                        'user' => $this->user,
                        'questionnaire' => $this->questionnaire,
                        'logoUrl' => asset('images/voiceup.png'),
                        'platformUrl' => route('home'),
                    ]);
    }
}
