<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Mail\MailCancelarLicenca;


use Illuminate\Support\Facades\Mail;

class JobMailCancelarPedidoLicenca implements ShouldQueue
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
     *
     * @return void
     */
    public function handle()
    {

      Mail::send(new MailCancelarLicenca($this->data));
    }
}
