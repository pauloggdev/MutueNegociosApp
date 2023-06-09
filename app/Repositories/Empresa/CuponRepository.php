<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\CouponDesconto;



class CuponRepository
{

    protected $couponDesconto;

    public function __construct(CouponDesconto $couponDesconto)
    {
        $this->couponDesconto = $couponDesconto;
    }
    public function getCupons($search)
    {
        $cupons = $this->couponDesconto::where('empresa_id', auth()->user()->empresa_id)
            ->search(trim($search))
            ->paginate();
        return $cupons;
    }

    public function lastCoupon()
    {
        return $this->couponDesconto::orderByDesc('id')->first();
    }
    public function gerarCuponDesconto($cupon)
    {
        return $this->couponDesconto::create([
            'codigo' => $cupon['codigo'],
            'percentagem' => $cupon['percentagem'],
            'data_expiracao' => $cupon['data_expiracao'],
            'empresa_id' => auth()->user()->empresa_id,
            'used' => 'N'
        ]);
    }
}
