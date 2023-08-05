<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use URL;

class UserInvited extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
		private readonly string $name,
		private readonly string $email,
		private readonly int    $school_id,
		private readonly int    $role_id
	)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
		$url = URL::temporarySignedRoute('users.invitation-accept', now()->addDays(3), [
			'name' => $this->name,
			'email' => $this->email,
			'school_id' => $this->school_id,
			'role_id' => $this->role_id
		]);
		return (new MailMessage)
			->subject('Invitation to use Tasharuk Platform')
			->greeting('Hello '.$this->name.'!')
			->line("You have been invited to join Tasharuk Platform.")
			->line("Tasharuk Platform allows you to send out surveys for your school, and gauge your school's performance in different areas.")
			->line("Click the button below to accept the invitation and create your account's password")
			->action('Accept', url($url))
			->line('Note: this link expires after 72 hours.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
