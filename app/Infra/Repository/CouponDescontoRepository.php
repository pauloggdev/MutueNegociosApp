<?php

namespace App\Infra\Repository;
use App\Domain\Entity\CouponDesconto;
use App\Models\empresa\CouponDesconto as CouponDescontoDatabase;

class CouponDescontoRepository
{
    public function getCoupon($codigoCoupon)
    {
        return CouponDescontoDatabase::where('codigo', $codigoCoupon)->first();
    }

}
