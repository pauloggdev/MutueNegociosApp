<?php

namespace App\Jobs;

use App\Mail\PedidoAtivacaoDoUtilizador;
use App\Mail\PedidoRejeitadoAtivacaoUtilizador;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class JobEnviarEmailDeAtivacaoDoUtilizador implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;
    public $tries = 3;

    /**
     * Create a new job instance.
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
        Mail::send(new PedidoAtivacaoDoUtilizador($this->data));
    }
}
