<?php

namespace App\Repositories\Admin;

use App\Models\admin\Taxa_Iva;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class TaxaIvaRepository
{

    protected $taxaIva;
    protected $coordenadaBancaria;

    public function __construct(Taxa_Iva $taxaIva)
    {
        $this->taxaIva = $taxaIva;
    }

    public function createTaxaIva(array $data)
    {
        $taxa  = $this->taxaIva::create([
            'taxa' => $data['taxa'],
            'codigostatus' => $data['codigostatus'],
            'descricao' => "IVA(" . number_format($data['taxa'], 1, ',', '.') . "%)",
            'codigoMotivo' => 8,
            'empresa_id' => 1
        ]);
        return $taxa;
    }
    public function updateTaxa($data)
    {

        $taxa  = $this->taxaIva::where('codigo', $data['codigo'])->update([
            'taxa' => $data['taxa'],
            'codigostatus' => $data['codigostatus'],
            'descricao' => "IVA(" . number_format($data['taxa'], 1, ',', '.') . "%)",
            'codigoMotivo' => 8,
            'empresa_id' => 1
        ]);

        return $taxa;
    }
    public function deletarTaxa($taxaId)
    {
        return $this->taxaIva::where('codigo', $taxaId)->delete();
    }


    public function getTaxaIvas($search)
    {
        $taxaIvas = $this->taxaIva::with(['statuGeral'])->search(trim($search))->paginate();
        return $taxaIvas;
    }

    public function getTaxaIva(int $id)
    {
        $taxaIva = $this->taxaIva::find($id);
        return $taxaIva;
    }
}
