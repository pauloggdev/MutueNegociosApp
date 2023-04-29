<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class AtivacaoLicenca extends Notification implements ShouldQueue
{
    use Queueable;

    private $data;
    public $tries = 3;
    private $empresa;

    // public $connection = 'mysql2';


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->getEmpresa();

    }
    public function getEmpresa(){
        $this->empresa = DB::connection('mysql')->table('empresas')->where('id', 1)->first();
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->subject('Pedido de Activação Aceite')
            ->view('mail.activacaoPedidoLicenca', $this->data);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [];
    }
    public function toDatabase($notifiable)
    {
        return [
            'notificacao' => $this->data['data'],
            'empresa' => $this->empresa->nome,
            'mensagem' => "Foi activo uma nova licença " . $this->data['data']['licenca']['designacao'] . " em sua conta ",
            'descricao' => "A empresa " .$this->empresa->nome . " activou uma licença " . $this->data['data']['licenca']['designacao'] . " em sua conta, sendo assim a contagem da sua licença inicia no dia " . date_format(date_create($this->data['data']['data_inicio']), 'd-m-Y')
                . " até o  dia " . date_format(date_create($this->data['data']['data_fim']), 'd-m-Y')
        
        
            ];

    }

}


