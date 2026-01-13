<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;

class AppointmentSet extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $appointment;
    public $rdv;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user,  Post $appointment, String $rdv)
    {
        $this->user = $user;
        $this->appointment = $appointment;
        $this->rdv = $rdv;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('meeting@elliot-deganai.net', $this->appointment->name)
        ->cc('edeganai@gmail.com')
        ->subject('Nouveau RDV')
        ->markdown('email.appointment');
    }
}
