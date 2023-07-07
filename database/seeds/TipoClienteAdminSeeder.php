<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoClienteAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tiposClientes = [
            'Singular',
            'Instituição Privada',
            'Instituição Publica',
            'Sociedade Anónima',
            'ONG',
            'Diversos',
        ];
        foreach ($tiposClientes as $designacao){
            DB::connection('mysql')->table('tipos_clientes')->insert([
                'designacao' => $designacao,
            ]);
        }
    }
}
