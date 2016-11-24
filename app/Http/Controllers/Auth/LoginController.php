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

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    //protected $redirectAfterLogout = '/auth/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function showLoginForm()
    {
        $showWarning = false;
        if (!empty(session('url.intended'))) {
            $showWarning = true;
        }
        //return $this->showLoginForm();
        return view('auth.login', ['show_warning' => $showWarning]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect($this->redirectAfterLogout)->with('success_msg', trans('Sesión finalizada exitosamente.'));
    }

}
