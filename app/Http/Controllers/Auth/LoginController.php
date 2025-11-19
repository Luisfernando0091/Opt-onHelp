<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
protected function credentials(\Illuminate\Http\Request $request)
{
    return [
        'email' => $request->email,
        'password' => $request->password,
        'activo' => 1, // Solo permite login si está activo
    ];
}

protected function sendFailedLoginResponse(\Illuminate\Http\Request $request)
{
    $user = \App\Models\User::where('email', $request->email)->first();

    // Si existe el usuario pero está inactivo
    if ($user && $user->activo == 0) {
        return back()->withErrors([
            'email' => 'Tu usuario está inactivo. Contacta al administrador.',
        ]);
    }

    // Caso normal: credenciales incorrectas
    return back()->withErrors([
        'email' => 'Estas credenciales no coinciden con nuestros registros.',
    ]);
}

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
        $this->middleware('auth')->only('logout');
    }
    protected function authenticated($request, $user)
{
    // Si el usuario tiene rol "usuario" va a su propio dashboard
    // if ($user->hasRole('usuario')) {
    //     return redirect()->route('usuario.dashboard');
    // }

    // Otros roles → dashboard normal
 return redirect('/home');

}

}
