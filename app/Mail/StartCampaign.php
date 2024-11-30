<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Post;

class StartCampaign extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $password;
    public $campaign;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, String $password, Post $campaign)
    {
        $this->user = $user;
        $this->password = $password;
        $this->campaign = $campaign;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('secret-santa@elliot-deganai.com', $this->campaign->name)->markdown('email.campaign');
    }
}
