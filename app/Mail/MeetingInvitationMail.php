<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class MeetingInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $title, $content, $meetLink, $scheduledAt;

    public function __construct($user, $title, $content, $meetLink, $scheduledAt)
    {
        $this->user = $user;
        $this->title = $title;
        $this->content = $content;
        $this->meetLink = $meetLink;
        $this->scheduledAt = $scheduledAt;
    }

    public function build()
    {
        return $this->subject('Undangan Google Meet dari LPK Amarta')
                    ->view('emails.meeting_invitation');
    }
}
