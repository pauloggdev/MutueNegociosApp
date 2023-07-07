<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'uuid'=> Str::uuid(),
                'name'=> 'MUTUE SOLUÇÕES TECNOLÓGICAS INTELIGENTES LDA',
                'username'=> 'MUTUE SOLUÇÕES TECNOLÓGICAS INTELIGENTES LDA',
                'telefone'=> '922969192',
                'email'=> 'geral@mutue.ao',
                'foto'=> 'admin/UMA.jpg',
                'password'=> '$2y$10$dmP5P0IdLOLXYrjdKsScouYcq19SiKElhG16yAfOPWdRhFLU.Enoy',
                'status_senha_id'=> 2,
                'notificarAtivacaoLicenca'=> 'N',
            ],
            [
                'uuid'=> Str::uuid(),
                'name'=> 'Zenilda Fila',
                'username'=> 'Zenilda Fila',
                'telefone'=> '923656040',
                'email'=> 'filazenilda@gmail.com',
                'foto'=> 'utilizadores/cliente/avatarEmpresa.png',
                'password'=> '$2y$10$tqBhxN54CqMIgJwbE8fKfOTCixOxFvc/4rqPcaCC7zkqTm.NLcgwi',
                'status_senha_id'=> 2,
                'notificarAtivacaoLicenca'=> 'N',
            ],
            [
                'uuid'=> Str::uuid(),
                'name'=> 'Paulo Gonçalo Garcia João',
                'username'=> 'Paulo João',
                'telefone'=> '923656044',
                'email'=> 'pauloggjoao@gmail.com',
                'foto'=> 'utilizadores/cliente/avatarEmpresa.png',
                'password'=> '$2y$10$tqBhxN54CqMIgJwbE8fKfOTCixOxFvc/4rqPcaCC7zkqTm.NLcgwi',
                'status_senha_id'=> 2,
                'notificarAtivacaoLicenca'=> 'Y',
            ]
        ];
        foreach ($users as $user){
            $user = (object) $user;
            DB::connection('mysql')->table('users_admin')->insert([
                'uuid' => $user->uuid,
                'name' => $user->name,
                'username' => $user->username,
                'telefone' => $user->telefone,
                'email' => $user->email,
                'foto' => $user->foto,
                'password' => $user->password,
                'status_senha_id' => $user->status_senha_id,
                'notificarAtivacaoLicenca' => $user->notificarAtivacaoLicenca
            ]);
        }

    }
}
