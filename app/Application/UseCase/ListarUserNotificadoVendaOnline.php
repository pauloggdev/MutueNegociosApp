<?php

namespace App\Application\UseCase;

use App\Domain\Factory\RepositoryFactory;
use App\Infra\Repository\UserRepository;

class ListarUserNotificadoVendaOnline
{
    private UserRepository $userRepository;

    public function __construct(RepositoryFactory $repositoryFactory)
    {
        $this->userRepository = $repositoryFactory->createUserRepository();
    }
    public function execute(){
        return $this->userRepository->emaisUserParaNotificar();
    }
}
