<?php

namespace App\Http\Controllers\Auth;

use App\Models\Tenant\Company;
use App\Models\System\Websites;
use App\Models\Tenant\User;

use App\Models\Tenant\Configuration;
use App\Models\System\Client;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Modules\BusinessTurn\Models\BusinessTurn;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\System\Configuration as SystemConfiguration;

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


    //protected $redirectTo = '/dashboard';

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
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    // public function login_admin(Request $request){
    //     //$user = $request->all();

    //     $user = User::where('email', $request->email)->where('password', bcrypt($request->input('password')))->first();
    //     dd($user);
    //     Auth::login($user);
    //     if(auth()->check()){
    //         return [
    //             'success' => true,
    //             'message' => "Sesión exitosa. Bienvenido/a"];
    //     }
    //     return [
    //         'success' => true,
    //         'message' => "Usuario/Contraseña Incorrecta"];
    // }
    public function showLoginForm()
    {
        $configuration = Configuration::first();
        $company = Company::first();

        return view('tenant.auth.login', compact('company', 'configuration'));
    }
}
