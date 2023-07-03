<?php

namespace App\Domain\Factory;
use App\Infra\Repository\CouponDescontoRepository;
use App\Infra\Repository\FaturaVendaOnlineRepository;
use App\Infra\Repository\PagamentoVendaOnlineRepository;
use App\Infra\Repository\UserRepository;

interface RepositoryFactory
{
    public function createPagamentoVendaOnlineRepository():PagamentoVendaOnlineRepository;
    public function createUserRepository():UserRepository;
    public function createFaturaPagamentoVendaOnlineRepository():FaturaVendaOnlineRepository;
    public function createCouponDescontoRepository():CouponDescontoRepository;
}
