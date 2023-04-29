<?php

namespace App\Http\Controllers\Api\Utilizadores;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserUpdatePasswordController extends Controller
{



    public function updatePassword(Request $request)
    {
        $messages = [
            'password1.required' => 'Informe a senha antiga',
            'password2.required' => 'Informe a nova senha',
        ];
        $validator = Validator::make($request->all(), [
            'password1' => ["required", function ($attr, $password1, $fail) use ($request) {

                if (!Hash::check($password1, auth()->user()->password)) {
                    $fail('A senha antiga não corresponde com a deste utilizador!');
                }
            }],
            'password2' => "required",
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }

        $user = DB::table('users_cliente')->where('id', auth()->user()->id)->update([
            'password' => Hash::make($request->password2),
            'updated_at' => Carbon::now(),
            'status_senha_id' => 2,
        ]);
        return $user;
    }
}
