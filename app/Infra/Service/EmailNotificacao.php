<?php

namespace App\Infra\Service;

use App\Domain\Service\INotificacaoService;

class EmailNotificacao implements INotificacaoService
{

    public function notificar(array $notificados, $mensagem): void
    {
        // TODO: Implement notificar() method.
    }
}
