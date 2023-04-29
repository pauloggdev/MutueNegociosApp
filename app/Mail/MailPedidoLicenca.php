<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailPedidoLicenca extends Mailable
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

        $this->subject($this->data['assunto']);
        $this->to(getenv('MAIL_USERNAME'), 'MUTUE NEGÓCIOS')
        ->from($this->data['email'])
        ->replyTo($this->data['email'], $this->data['nome']);
        return $this->view('mail.pedidoLicenca', $this->data);
    }
}
