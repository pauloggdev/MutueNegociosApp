<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoUserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tiposUsers = [
            'Admin','Empresa', 'Cliente'
        ];
        foreach ($tiposUsers as $designacao){
            DB::connection('mysql')->table('tipo_users')->insert([
                'designacao' => $designacao,
            ]);
        }
    }
}
