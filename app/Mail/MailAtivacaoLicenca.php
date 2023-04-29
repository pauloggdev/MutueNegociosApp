<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailAtivacaoLicenca extends Mailable 
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

    $this->subject('Pedido de Activação Aceite');
    $this->to($this->data['emailEmpresa']);


    return $this->view('mail.activacaoPedidoLicenca', $this->data);
  }
}
