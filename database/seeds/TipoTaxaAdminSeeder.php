<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoTaxaAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tiposTaxas = [
            [
                'taxa' => 0,
                'codigostatus' => 1,
                'descricao' => 'IVA(0,00%)',
                'codigoMotivo' => 12,
                'empresa_id' => 1,
            ],
            [
                'taxa' => 14,
                'codigostatus' => 1,
                'descricao' => 'IVA(14,00%)',
                'codigoMotivo' => 9,
                'empresa_id' => 1,
            ],
            [
                'taxa' => 2,
                'codigostatus' => 1,
                'descricao' => 'IVA(2,00%)',
                'codigoMotivo' => 8,
                'empresa_id' => 1,
            ]
        ];
        foreach ($tiposTaxas as $tipotaxa) {
            $tipotaxa = (object) $tipotaxa;
            DB::connection('mysql')->table('tipotaxa')->insert([
                'taxa' => $tipotaxa->taxa,
                'codigostatus' => $tipotaxa->codigostatus,
                'descricao' => $tipotaxa->descricao,
                'codigoMotivo' => $tipotaxa->codigoMotivo,
                'empresa_id' => $tipotaxa->empresa_id,
            ]);
        }
    }
}
