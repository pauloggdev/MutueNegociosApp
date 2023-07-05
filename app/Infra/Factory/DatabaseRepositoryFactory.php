<?php

namespace App\Infra\Factory;
use App\Domain\Factory\RepositoryFactory;
use App\Infra\Repository\CarrinhoRepository;
use App\Infra\Repository\CouponDescontoRepository;
use App\Infra\Repository\FaturaVendaOnlineRepository;
use App\Infra\Repository\PagamentoVendaOnlineRepository;
use App\Infra\Repository\UserRepository;

class DatabaseRepositoryFactory implements RepositoryFactory
{
    public function createPagamentoVendaOnlineRepository(): PagamentoVendaOnlineRepository
    {
        return new PagamentoVendaOnlineRepository();
    }

    public function createUserRepository(): UserRepository
    {
        return new UserRepository();
    }

    public function createFaturaPagamentoVendaOnlineRepository(): FaturaVendaOnlineRepository
    {
       return new FaturaVendaOnlineRepository();
    }

    public function createCouponDescontoRepository():CouponDescontoRepository
    {
        return new CouponDescontoRepository();
    }
    public function createCarrinhoRepository():CarrinhoRepository{
        return new CarrinhoRepository();
    }
}
