<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class CadastroEmpresaNotificacao extends Notification implements ShouldQueue
{
    use Queueable;

    private $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;

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
        //return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->subject('Bem-vindo ao Mutue-Negócio! Segue seus dados de acesso')
        ->view("mail.NotificaCadastroEmpresa",$this->data);
                    
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
            
            //
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */

    
     public function toDatabase($notifiable)
    {
        return [
            'notificacao' => (object) $this->data['data'],
            'empresa' => $this->data['data']['nome'],
            'mensagem' => "A empresa " . $this->data['data']['nome'] . " foi cadastrado na aplicação",
            'descricao' => "A empresa " .$this->data['data']['nome'] . " fez o seu cadastro na aplicação Mutue Negócios. O cadastro foi efectuado no dia " . date_format(date_create($this->data['data']['created_at']), 'd-m-Y')
        ];
    }
}
