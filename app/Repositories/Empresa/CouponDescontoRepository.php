<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\CouponDesconto;
use Carbon\Carbon;
use DateTime;

class CouponDescontoRepository
{

    protected $entity;

    public function __construct(CouponDesconto $entity)
    {
        $this->entity = $entity;
    }

    public function getCoupon($code)
    {
        return $this->entity::where('codigo', $code)
            ->where('used', 'N')
            ->first();
    }

    public function isExpired($code)
    {
        $coupon = $this->getCoupon($code);
        if(!$coupon)return false;
        $today = Carbon::now()->format('Y-m-d H:i:s');
        $today = Carbon::parse($today);
        $data_expiracao = Carbon::parse($coupon->data_expiracao);
        return $today->gt($data_expiracao);
    }
    public function calcularCoupon($total, $percentagem)
    {
        return ($total *  $percentagem) / 100;
    }
}
