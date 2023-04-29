<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppController extends Controller {


    public function __construct()
    {
      //  dd(auth()->guard('empresa')->user());
    }


    public function logout(){
        Auth::guard('web')->logout();
        Auth::guard('empresa')->logout();

    }

    public function Home() {



       // return view('manutencao');

        $this->logout();

    //     $USER_TIPO_EMPRESA = 2;
    //     $USER_TIPO_FUNCIONARIO = 3;
    //     $USER_TIPO_ADMIN = 1;
    //dd(auth()->user());


    //     if(Auth::guard('web')->check() && Auth::user()->tipo_user_id == $USER_TIPO_EMPRESA){
    //         return redirect("/empresa/home");
    //     }
    //     else if(Auth::guard('empresa')->check() && Auth::user()->tipo_user_id == $USER_TIPO_FUNCIONARIO){
    //         return redirect("/empresa/home");
    //     }
    //     else if(Auth::guard('web')->check() && Auth::user()->tipo_user_id == $USER_TIPO_ADMIN){
    //         return redirect("/home");
    //     }



        // if(Auth::guard('web')->check() && )
        // dd(Auth::user()->tipo_user_id);
        // dd(Auth::guard('web')->check());


        $data['licencas'] = DB::connection('mysql')->table('licencas')->get();
        return view('welcome', $data);
    }

}
