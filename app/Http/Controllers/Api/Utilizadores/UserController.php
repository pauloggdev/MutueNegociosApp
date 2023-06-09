<?php

namespace App\Http\Controllers\Api\Utilizadores;

use App\Http\Controllers\Controller;
use App\Jobs\JobRecuperacaoSenha;
use App\Repositories\Empresa\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Keygen\Keygen;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function quantidadeUtilizadores()
    {
        return $this->userRepository->quantidadeUsers();

    }
    public function recuperacaoDeSenha(Request $request){

        $messages = [
            'email.required' => 'Informe o email',
        ];
        $validator = Validator::make($request->all(), [
            'email' => ["required", function($attr, $email, $fail){
                $user = DB::connection()->table('users_cliente')
                ->where('email', $email)
                ->first();
                if(!$user){
                    $fail("E-mail não encontrado");
                }
            }],
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }
        $novaSenha = Keygen::alphanum(8)->generate();

        DB::table('users_cliente')->where('email', $request->email)->update([
            'password' => Hash::make($novaSenha),
            'updated_at' => Carbon::now()
        ]);
        $user = DB::connection()->table('users_cliente')->where('email', $request->email)->first();
        $data['novaSenha'] = $novaSenha;
        $data['nome'] = $user->name;
        $data['email'] = $request->email;
        JobRecuperacaoSenha::dispatch($data)->delay(now()->addSecond('5'));

        return response()->json([
            'data' => '',
            'message'=> 'Foram enviado a nova senha no seu email'
        ]);

    }
}
