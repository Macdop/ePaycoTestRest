<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\User;

class tokenPago extends Mailable
{
    use Queueable, SerializesModels;
    
    public $user;
    public $token;
    
    /**
    * Create a new message instance.
    *
    * @return void
    */
    public function __construct(string $user,string $token)
    {
        $this->user = $user;
        $this->token = $token;
    }
    /**
    * Build the message.
    *
    * @return $this
    */
    public function build()
    {
        return $this->view('emailtoken')->with(['token' => $this->token,'user' => $this->user]);
    }
}
