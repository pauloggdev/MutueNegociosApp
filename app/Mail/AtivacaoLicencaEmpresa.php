<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AtivacaoLicencaEmpresa extends Mailable
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

        $this->to($this->data['emails']);
        $this->subject($this->data['assunto']);
        $views = $this->view("mail.PedidoAtivacaoLicenca", $this->data);
        foreach ($this->data['comprovativos'] as $comprovativo => $descricao) {
            $views->attach($comprovativo, [
                'as' => $descricao
            ]);
        }
        return $views;
    }
}
