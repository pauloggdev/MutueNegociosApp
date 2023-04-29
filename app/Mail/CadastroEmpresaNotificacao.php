<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CadastroEmpresaNotificacao extends Mailable
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
        $this->to($this->data['email']);
        $this->from(env('MAIL_FROM_ADDRESS'));
        $this->subject('Bem-vindo ao Mutue-Negócio! Segue seus dados de acesso');
        return $this->view("mail.NotificaCadastroEmpresa", $this->data);
    }
}
