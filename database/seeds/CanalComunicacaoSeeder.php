<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CanalComunicacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $canaisComunicacoes = [
            'BD','Portal Cliente', 'Portal Admin','Mobile'
        ];
        foreach ($canaisComunicacoes as $designacao){
            DB::connection('mysql')->table('canais_comunicacoes')->insert([
                'designacao' => $designacao,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
