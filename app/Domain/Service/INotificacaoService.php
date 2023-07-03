<?php

namespace App\Domain\Service;

interface INotificacaoService
{
    public function notificar(array $notificados, $mensagem):void;
}
