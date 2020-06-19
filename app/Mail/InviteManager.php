<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteManager extends Mailable
{
    use Queueable, SerializesModels;
    protected $token;
    protected $userid;
    protected $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userid, $email)
    {
        $this->userid = $userid;
        $this->token = substr(md5($email), 0, 8);
    }

    private function getUrl()
    {
        return route('manager_confirmation', ['userid' => $this->userid, 'token' => $this->token]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.invite_manager')->with(['url' => $this->getUrl()]);
    }
}
