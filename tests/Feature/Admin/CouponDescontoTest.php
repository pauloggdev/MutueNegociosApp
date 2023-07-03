<?php

namespace Admin;

use App\Domain\Entity\CouponDesconto;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class CouponDescontoTest extends TestCase
{
    public function testDeveCriarUmCouponDescontoTest(){

        $couponDesconto = new CouponDesconto('VALE20', 20, 'N','2023-06-26');
        $this->assertSame('VALE20', $couponDesconto->getCodigo());
        $this->assertSame('2023-06-26', $couponDesconto->getDataExpiracao());
        $this->assertSame('N', $couponDesconto->getUsed());
    }
    public function testDeveVerificarSeCouponDescontoEValido(){
        $data = Carbon::parse('2023-06-26');
        $couponDesconto = new CouponDesconto('VALE20', 20, 'N',$data);
        $isValido = $couponDesconto->isValid();
        $this->assertFalse($isValido);
    }

}
