<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LinkUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user, $link;

    public function __construct($user, $code)
    {
        $this->user = $user;
        $this->link = route('active_email',['code'=>$code]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->user->new_email)
            ->from(env('MAIL_FROM_ADDRESS'))
            ->subject('Изменение почты в сервисе backoffice.ru')
            ->view('email.link-user');
    }
}
