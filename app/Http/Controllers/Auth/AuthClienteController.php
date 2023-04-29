<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class AuthClienteController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = 'empresa/home';



    public function __construct()
    {
        // $this->middleware('guest:empresa');
    }

    public function login(Request $request)
    {



        $validator = validator($request->all(), [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect('/login')
                ->withErrors($validator)
                ->withInput();
        }

        if (is_numeric($request->email)) {
            $credentials = ['telefone' => $request->email, 'password' => $request->password];
        } else {
            $credentials = ['email' => $request->email, 'password' => $request->password];
        }

        if (auth()->guard('empresa')->attempt($credentials)) {
            return redirect('empresa/home');
        } else {
            return redirect('/login')
                ->withErrors(['errors'=>'Login inválido'])
                ->withInput();
        }



        // $request->validate([
        //     $this->username() => 'required|string',
        //     'password' => 'required|string',
        // ]);

        // if (is_numeric($request->email)) {
        //     $credentials = ['telefone' => $request->email, 'password' => $request->password];
        // } else {
        //     $credentials = ['email' => $request->email, 'password' => $request->password];
        // }

        // $auth = Auth::guard('empresa')->attempt($credentials);
        // if ($auth) {
        //     return redirect('empresa/home');
        // } else {
        //     return $this->sendFailedLoginResponse($request);
        //     // return redirect()->back()->withInput($request->only('email', 'remember'));
        // }
    }
    public function showLoginForm()
    {
        return view('empresa.auth.login');
    }
}
