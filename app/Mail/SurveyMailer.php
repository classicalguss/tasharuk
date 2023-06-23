<?php

namespace App\Mail;

use App\Models\School;
use App\Models\Survey;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SurveyMailer extends Mailable
{
    use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 */
	public function __construct(
		protected $schoolName,
		protected $token
	) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Survey',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.survey-invitation',
			with: [
				'schoolName' => $this->schoolName,
				'acceptUrl' => config('app.url').'/survey?token='.$this->token
			]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
