<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PedidoRejeitadoAtivacaoUtilizador extends Mailable
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
     * @return $this
     */
    public function build()
    {
        $this->to($this->data['email']);
        $this->from(env('MAIL_FROM_ADDRESS'));
        $this->subject('Pedido activação do utilizador rejeitado');
        return $this->view("mail.notificacaoPedidoRejeitadoActivacaoUtilizador", $this->data);
    }
}
