<?php

namespace App\Http\Controllers\Api\UtilizadorPortal;

use App\Http\Controllers\Controller;
use App\Models\empresa\User;
use App\Repositories\Empresa\UserPortalRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MvUserController extends Controller
{

    private $userRepository;

    public function __construct(UserPortalRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function quantidadeUtilizadores()
    {
        return $this->userRepository->quantidadeUsers();
    }
    public function createNewUser(Request $request)
    {
        $mensagem =  [
            'name.required' => 'Informe o nome',
            'email.required' => 'Informe o E-mail',
            'password1.required' => 'Informe a senha',
            'password2.required' => 'Informe novamente a senha',
            'telefone.required' => 'Informe o telefone'
        ];

        $validator = Validator::make($request->all(), [
            'email' => ['required', function ($attr, $email, $fail) use ($request) {
                $user = User::where('email', $request->email)
                    ->where('tipo_user_id', 4)->first();
                if ($user) {
                    $fail("E-mail já cadastrado");
                }
            }],
            'name' => 'required',
            'password1' => ["required", function ($attr, $password1, $fail) use ($request) {
                if ($password1 !== $request->password2) {
                    $fail("As senhas não correspondem");
                }
            }],
            'password2' => ["required"],
            'telefone' => ["required", function ($attr, $telefone, $fail) {
                $user = User::where('telefone', $telefone)
                    ->where('tipo_user_id', 4)->first();
                if ($user) {
                    $fail("Telefone já cadastrado");
                }
            }]
        ], $mensagem);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'data' => null,
                'message' => $errors->all()[0]
            ], 401);
        }

        $user = $this->userRepository->createNewUser($request);

        $output = [
            'uuid' => $user->uuid,
            'name' => $user->name,
            'foto' => $user->foto,
            'email' => $user->email,
            'password' => $request->password1,
        ];

        return response()->json([
            'data' => $output,
            'message' => 'Usuário cadastro com sucesso!'
        ]);
    }
    public function updateUser(Request $request, $uuid)
    {
        $mensagem =  [
            'name.required' => 'Informe o nome',
            'email.required' => 'Informe o E-mail',
            'telefone.required' => 'Informe o telefone'
        ];

        $validator = Validator::make($request->all(), [
            'email' => ['required', function ($attr, $email, $fail) use ($uuid) {
                $user = User::where('email', $email)
                    ->where('uuid', '!=', $uuid)
                    ->where('tipo_user_id', 4)->first();
                if ($user) {
                    $fail("E-mail já cadastrado");
                }
            }],
            'name' => 'required',
            'telefone' => ["required", function ($attr, $telefone, $fail) use ($uuid) {
                $user = User::where('telefone', $telefone)
                    ->where('tipo_user_id', 4)
                    ->where('uuid', '!=', $uuid)
                    ->first();
                if ($user) {
                    $fail("Telefone já cadastrado");
                }
            }]
        ], $mensagem);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'data' => null,
                'message' => $errors->all()[0]
            ], 401);
        }

        $user = $this->userRepository->updateUser($request, $uuid);

    }
}
