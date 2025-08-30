<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class MeetingInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $title, $content, $platform, $meetLink, $scheduledAt;
    public $zoomMeetingId, $zoomPasscode;

    /**
     * Buat instance mail.
     */
    public function __construct($user, $title, $content, $platform, $meetLink, $scheduledAt, $zoomMeetingId = null, $zoomPasscode = null)
    {
        $this->user          = $user;
        $this->title         = $title;
        $this->content       = $content;
        $this->platform      = $platform;   // google_meet / zoom
        $this->meetLink      = $meetLink;
        $this->scheduledAt   = $scheduledAt;
        $this->zoomMeetingId = $zoomMeetingId;
        $this->zoomPasscode  = $zoomPasscode;
    }

    /**
     * Build pesan email.
     */
    public function build()
    {
        $platformName = $this->platform === 'zoom' ? 'Zoom Meeting' : 'Google Meet';

        return $this->subject("Undangan {$platformName} dari LPK Amarta")
                    ->view('emails.meeting_invitation');
    }
}
