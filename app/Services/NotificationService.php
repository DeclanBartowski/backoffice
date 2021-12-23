<?php

namespace App\Services;

use App\Mail\LinkUser;
use App\Mail\SendRegister;
use App\Mail\SendRestore;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    private $user;
    public function __construct($user){
        $this->user = $user;
    }

    public function sendRegister($code)
    {
        session(['register code' => $code]);
        Mail::send(new SendRegister($this->user,$code));
       // \Debugbar::addMessage('register code',$code);
    }

    public function sendRestore($code)
    {
        Mail::send(new SendRestore($this->user,$code));
        \Debugbar::addMessage('restore code',$code);
    }

    public function linkUser($code)
    {
        Mail::send(new LinkUser($this->user,$code));
        session(['link code' => $code]);
    }

}
