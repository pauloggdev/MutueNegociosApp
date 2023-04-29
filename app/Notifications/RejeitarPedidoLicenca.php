<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class RejeitarPedidoLicenca extends Notification implements ShouldQueue
{
    use Queueable;
    private $data;
    private $empresa;
    public $tries = 3;

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
        return (new MailMessage)->subject($this->data['assunto'])
            ->view('mail.cancelarPedidoLicenca', $this->data);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
           // 'mensagem' => "Foi rejeitado o seu pedido de licença"
        ];
    }
    public function toDatabase($notifiable)
    {
        return [
            'notificacao' => $this->data['data'],
            'empresa' => $this->empresa->nome,
            'mensagem' => "Foi rejeitado o seu pedido de licença",
            'descricao' => "Gostariamos informá-lo que seu pedido de renovação de licença feito no dia " . $this->data['dataPedidoLicenca'] . " não foi aceite na aplicação Mutue Negócios. Motivo: ".$this->data['motivo']
        
        
        ];
        
    }
}
