<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/empresa/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('guest')->except('logout');
    }




    /**
     * subscrita de metodo
     */
    public function login(Request $request)
    {


        $TIPO_ADMIN = 1;
        $TIPO_EMPRESA = 2;

        if ($request->all()['tipoUser'] == $TIPO_ADMIN) {


            return $this->loginAdmin($request);




            $this->validateLogin($request);

            // If the class is using the ThrottlesLogins trait, we can automatically throttle
            // the login attempts for this application. We'll key this by the username and
            // the IP address of the client making these requests into this application.

            if (
                method_exists($this, 'hasTooManyLoginAttempts') &&
                $this->hasTooManyLoginAttempts($request)
            ) {
                $this->fireLockoutEvent($request);
                return $this->sendLockoutResponse($request);
            }

            if ($this->attemptLogin($request)) {

                return $this->sendLoginResponse($request);
            }

            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponse($request);
        } else {
            return $this->loginEmpresa($request);
        }
    }


    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended('/admin/home');
    }
    public function loginAdmin(Request $request)
    {

        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);

        if (is_numeric($request->email)) {
            $credentials = ['telefone' => $request->email, 'password' => $request->password];
        } else {
            $credentials = ['email' => $request->email, 'password' => $request->password];
        }

        if (auth()->guard('web')->attempt($credentials)) {
            return redirect('admin/home');
        } else {
            return $this->sendFailedLoginResponse($request);
        }
    }
    public function loginEmpresa(Request $request)
    {
        $request->validate([
            $this->username() => ["required", function ($attr, $value, $fail) {

                $user = DB::connection('mysql2')->table('users_cliente')->where('telefone', $value)
                    ->orWhere('email', $value)
                    ->orWhere('username', $value)
                    ->first();

                if ($user) {
                    if ($user->status_id == 2 || $user->statusUserAdicional == 3) {
                        $fail("Utilizador sem acesso, está desactivo");
                    }
                }
            }],
            'password' => 'required|string',
        ]);


        if (is_numeric($request->email)) {
            $credentials = ['telefone' => $request->email, 'password' => $request->password];
        } else if ($this->isMail($request->get('email'))) {
            $credentials = ['email' => $request->email, 'password' => $request->password];
        } else {
            $credentials = ['username' => $request->email, 'password' => $request->password];
        }

        if (auth()->guard('empresa')->attempt($credentials)) {
            return redirect('empresa/home');
        } else {
            return $this->sendFailedLoginResponse($request);
        }
    }
    /**
     * subscrita de metodo
     */
    protected function attemptLogin(Request $request)
    {

        return $this->guard()->attempt(
            $this->credentials($request),
            $request->filled('remember')
        );
    }

    public function loginForm()
    {
        return view('admin.auth.login');
    }

    //Sobrescrevendo o método para logar com telefone
    protected function credentials(Request $request)
    {
        if (is_numeric($request->get('email'))) {
            return ['telefone' => $request->get('email'), 'password' => $request->get('password')];
        }


        return $request->only($this->username(), 'password');
    }
    public function isMail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    public function username()
    {
        return 'email';
    }

    public function showLoginForm()
    {
        $data['licencas'] = DB::connection('mysql')->table('licencas')->get();
        return view('welcome', $data);
    }
}
