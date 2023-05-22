<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\empresa\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MvClienteAuthPortalController extends Controller
{
    public function auth(Request $request)
    {
        $mensagem =  [
            'email.required' => 'E-mail/ou telefone é obrigatorio',
            'password.required' => 'Senha é obrigatorio',
        ];

        $credentials = $request->validate([
            'email' => ['required', function ($attr, $email, $fail) use ($request) {
                $user = User::where('email', $request->email)
                    ->orwhere('telefone', $request->email)->where('tipo_user_id', 4)->first();
                if (!$user) {
                    $fail("O usuário não encontrado");
                }
            }, 'email'],
            'password' => ['required'],
        ], $mensagem);

        if (auth()->guard('empresa')->attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json([
                'message' => 'logado com sucesso'
            ], 200);
        }

        return response()->json([
            'message' => 'Acesso negado!'
        ], 401);



        // $validator = Validator::make($request->all(), [
        //     'email' => ['required', function ($attr, $email, $fail) use ($request) {
        //         $user = User::where('email', $request->email)
        //             ->orwhere('telefone', $request->email)->where('tipo_user_id', 4)->first();
        //         if (!$user) {
        //             $fail("O usuário não encontrado");
        //         }
        //     }],
        //     'password' => 'required'
        // ], $mensagem);
        // if ($validator->fails()) {
        //     return response()->json($validator->errors()->messages(), 401);
        // }

        dd('teste');
        // $user = User::where('email', $request->email)
        //     ->orwhere('telefone', $request->email)->where('tipo_user_id', 4)->first();
        // if ($user)
        //     $user->tokens()->delete();
        // if (!$user || !Hash::check($request->password, $user->password)) {
        //     return response()->json(['message' => 'Credenciais invalidos'], 401);
        // }
        // $token = $user->createToken('mobile')->plainTextToken;
        // return response()->json([
        //     'token' => $token,
        //     'user' => [
        //         'id' => $user->id,
        //         'name' => $user->name,
        //         'email' => $user->email,
        //         'telefone' => $user->telefone,
        //         'status_senha_id' => $user->status_senha_id,
        //         'foto' => $user->foto
        //     ]
        // ]);
    }
    public function getEmpresa()
    {
        return auth()->user()->empresa;
    }
    public function me()
    {
        $user = auth()->user();
        return response()->json($user, 200);
        // return new UserResource($user);
    }
    public function logout()
    {

        dd(auth()->user());
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'logout feito com sucesso'
        ]);
    }
}
