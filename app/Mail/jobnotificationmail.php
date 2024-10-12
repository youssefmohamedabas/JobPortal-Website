<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class jobnotificationmail extends Mailable
{
    use Queueable, SerializesModels;

    public $maildata;

    public function __construct($maildata)
    {
        $this->maildata = $maildata; // Store the mail data
    }

    public function envelope(): Envelope
    {
        $jobTitle = isset($this->maildata['job']) && $this->maildata['job'] 
            ? $this->maildata['job']->title 
            : 'Unknown Job'; // Fallback if job is null

        return new Envelope(
            subject:$jobTitle,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'front.email.mail', // Make sure this view file exists
            with: ['maildata' => $this->maildata],  // Pass data to the view
        );
    }

    public function attachments(): array
    {
        return []; // Return an empty array for no attachments
    }
}