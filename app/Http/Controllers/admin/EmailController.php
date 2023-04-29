<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{

    public function index(){

        return view('email.index');
    }

    public function enviarEmail(){

        //enviar email

        Mail::to('mutuenegocio@gmail.com')->send(new Email());
        return 'ok';



    }
    //
}
