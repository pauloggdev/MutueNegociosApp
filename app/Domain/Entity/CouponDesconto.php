<?php

namespace App\Domain\Entity;

use Carbon\Carbon;

class CouponDesconto
{

    private $codigo;
    private $percentagem;
    private $used;
    private $dataExpiracao;

    /**
     * @param $codigo
     * @param $percentagem
     * @param $used
     * @param $dataExpiracao
     */
    public function __construct($codigo, $percentagem, $used, $dataExpiracao)
    {
        $this->codigo = $codigo;
        $this->percentagem = $percentagem;
        $this->used = $used;
        $this->dataExpiracao = $dataExpiracao;
    }

    /**
     * @return mixed
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @return mixed
     */
    public function getPercentagem()
    {
        return $this->percentagem;
    }

    /**
     * @return mixed
     */
    public function getUsed()
    {
        return $this->used;
    }

    /**
     * @return mixed
     */
    public function getDataExpiracao()
    {
        return $this->dataExpiracao;
    }

    public function isValid(){
        if($this->isUsed()) return false;
        return $this->getDataExpiracao() > Carbon::now();
    }
    public function isUsed(){
        return $this->getUsed() == 'Y';
    }


}
