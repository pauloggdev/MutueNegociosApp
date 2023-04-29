<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;



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

    protected $redirectTo = '/home';



    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()

    {

        $this->middleware('guest')->except('logout');

    }

    

    public function loginForm()

    {

        return view('admin.auth.login');

    }

    

    //Sobrescrevendo o método para logar com telefone

    protected function credentials(Request $request){

        if(is_numeric($request->get('email'))){

            return ['telefone'=>$request->get('email'),'password'=>$request->get('password')];

        }

        return $request->only($this->username(), 'password');

    }
    public function showLoginForm()
    {
        return view('welcome');
    }
   
    

}

