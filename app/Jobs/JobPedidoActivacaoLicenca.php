<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Mail\MailCancelarLicenca;
use App\Mail\MailPedidoLicenca;
use Illuminate\Support\Facades\Mail;

class JobPedidoActivacaoLicenca implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

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
     * Execute the job.
     * @return void
     */
    public function handle()
    {
        // foreach ($this->data['users'] as $user) {
            // $this->data['email'] = $user->email;
            $this->data['email'] = 'pauloggjoao@gmail.com';
            Mail::send(new MailPedidoLicenca($this->data));
        // }
    }
}
