<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function perform()
    {
        Session::flush();
        Auth::logout();
        return redirect('login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            //return redirect()->intended('dashboard');
            $user = Auth::user();
            $response = [
                'success'     => true,
                'message'     => 'Bienvenido '.$user->name.' Inicio de sesión de usuario con éxito',

            ];
        } else {

            $response = [
              'success'     => false,
              'message'     => 'Usuario No autorizado',

          ];
        }
      return response()->json($response);
    }
}
