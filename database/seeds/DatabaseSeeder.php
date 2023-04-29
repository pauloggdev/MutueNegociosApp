<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


        for ($i = 1; $i <= 1; $i++) {

            DB::beginTransaction();

            try {
                //utilizador empresa
                $userId = DB::connection('mysql2')->table('users_cliente')->insertGetId([
                    'name' => 'Teste' . $i,
                    'email' => 'teste' . $i . '@gmail.com',
                    'username' => 'Teste' . $i,
                    'password' => Hash::make('12345'),
                    'tipo_user_id' => 2,
                    'status_id' => 1,
                    'status_senha_id' => 2,
                    'telefone' => '923654' . $i,
                    'canal_id' => 2,
                    'empresa_id' => 53,
                    'foto' => 'utilizadores/cliente/avatarEmpresa.png'
                ]);

                //funcao utilizador
                DB::connection('mysql2')->table('role_user')->insertGetId([
                    'user_id' => $userId,
                    'role_id' => 3,
                ]);

                //contsys utilizador
                $STATUS_ATIVO = 1;
                DB::connection('mysql3')->table('utilizadores')->insert([
                    'Nome' => 'Teste' . $i,
                    'Username' => 'Teste' . $i,
                    'Password' => Hash::make('12345'),
                    'CodStatus' => $STATUS_ATIVO,
                    'CodTipoUser' => 2,
                    'empresa_id' => 53,
                    'email' => 'teste' . $i . '@gmail.com',
                    'UserId' => $userId
                ]);

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                //throw $th;
            }
        }
    }
}
