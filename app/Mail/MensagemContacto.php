<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class MensagemContacto extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;


    private $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->data['assunto'])
            ->from($this->data['email'], $this->data['nome'])
            ->replyTo($this->data['email'], $this->data['nome'])
            ->to(env('MAIL_FROM_ADDRESS'),$this->data['nome'])
            ->view('mail.mensagemContacto', $this->data);
    }
}
