<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

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
        Session::forget('samlLogoutURL');
        Cookie::queue(Cookie::forget('SimpleSAMLAuthToken'));
        Cookie::queue(Cookie::forget('SimpleSAMLCookie'));
        $this->middleware('guest')->except('logout');
    }
    public function logout(){
//        dd(Session::has('samlLogoutURL'));
        Auth::logout();
        Cookie::queue(Cookie::forget('SimpleSAMLAuthToken'));
        Cookie::queue(Cookie::forget('SimpleSAMLCookie'));
        if(Session::has('samlLogoutURL') === true){
            Session::flush();
            return redirect()->route('home');
        }
        Session::flush();
        return redirect()->route('home');
    }
}
