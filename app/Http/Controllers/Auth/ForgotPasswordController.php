<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\sSendsPasswordResetEmails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;


    /*
    Metodo subscrito
    */
    public function broker($params =  null)
    {
        $params = $params ? $params : "";
        return Password::broker($params);
    }

    /*
    Metodo subscrito
    */
    public function sendResetLinkEmail(Request $request)
    {

        $this->validateEmail($request);


        $connection1 = DB::connection('mysql')->table("users_admin")->where("email", $request->get("email"))->first();
        $connection2 = DB::connection('mysql2')->table("users_cliente")->where("email", $request->get("email"))->first();

        if ($connection1) {
            $response = $this->broker('users')->sendResetLink($this->credentials($request));
        }
        if ($connection2) {
            $response = $this->broker('empresas')->sendResetLink($this->credentials($request));
        }
        if (!$connection1 && !$connection2) {
            $response = $this->broker()->sendResetLink($this->credentials($request));
        }



        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.

        return $this->sendResetLinkResponse($request, 'Acessa o email para redefinir a senha');


        // return $response == Password::RESET_LINK_SENT
        //     ? $this->sendResetLinkResponse($request, $response)
        //     : $this->sendResetLinkFailedResponse($request, $response);
    }
    protected function validateEmail(Request $request)
    {
        $request->validate(
            [
                'email' => ['required', function ($attr, $email, $fail) use ($request) {
                    $connection1 = DB::connection('mysql')->table("users_admin")->where("email", $request->get("email"))->first();
                    $connection2 = DB::connection('mysql2')->table("users_cliente")->where("email", $request->get("email"))->first();
                    if (!$connection1 && !$connection2) {
                        $fail('E-mail não encontrado');
                    }
                }]
            ]
        );
    }
}
