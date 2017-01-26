<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class WelcomeAdmMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
	public $user;
	public $psw;
	
    public function __construct(User $user,$pswx)
    {
         $this->user = $user;
		 $this->psw = $pswx;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.welcomeadm')
		        ->from('hoytrabajas@hoytrabajas.com')
                ->subject('Usuario administrador creado, Bienvenido!');
    }
}
