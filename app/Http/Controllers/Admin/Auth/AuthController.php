<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Admin as User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/home';

    protected $redirectAfterLogout = '/admin/auth/login';

    protected $username = 'username';

    protected $guard = 'admin';

    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect('/admin/home');
        }
        
        return view('admin.auth.login');
    }
    
    /*public function showRegistrationForm()
    {
        return view('admin.auth.register');
    }
    
    public function resetPassword()
    {
        return view('admin.auth.passwords.email');
    }*/
    
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/auth/login')->with('success_msg', trans('Sesión finalizada exitosamente.'));
    }

}
