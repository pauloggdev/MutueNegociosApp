<?php

namespace App\Http\Controllers\Portal;
use App\Http\Controllers\Controller;
use App\Repositories\Empresa\CouponDescontoRepository;
use Illuminate\Http\Request;

class CouponDescontoProdutoController extends Controller
{

    private $couponDescontoRepository;

    public function __construct(CouponDescontoRepository $couponDescontoRepository)
    {
        $this->couponDescontoRepository = $couponDescontoRepository;
    }

    public function addCouponDesconto(Request $request)
    {
        $coupon = $this->couponDescontoRepository->getCoupon($request->codigo);
        if(!$coupon){
            return response()->json([
                'data'=> null,
                'message' => 'Coupon de desconto não existe'
            ]);
        }
        $couponExpirado = $this->couponDescontoRepository->isExpired($request->codigo);
        if($couponExpirado){
            return response()->json([
                'data'=> null,
                'message' => 'Coupon de desconto expirado'
            ]);
        }
        $totalDesconto = $this->couponDescontoRepository->calcularCoupon($request->totalSemDesconto, $coupon->percentagem);
        $totalPagar = $request->totalSemDesconto - $totalDesconto;
        return response()->json([
            'data' =>[
                'totalCouponDesconto' => $totalDesconto,
                'totalPagar'=> $totalPagar
            ],
            'message'=>'Operação realizada com sucesso!'
        ], 200);
    }

}
