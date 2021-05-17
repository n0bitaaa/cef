<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'name';
    }

    public function guardLogin(Request $request,$guard){
        return Auth::guard($guard)->attempt([
            'name' => $request->name,
            'code' => $request->code,
            'password' => $request->password
        ],
        $request->get('remember')
    );
    }

    public function showLogin(){
        return view('auth.login',['uri'=>'admin']);
    }

    public function postLogin(Request $request){
        $request->validate([
            'name' => 'required',
            'password' => 'required',
            'code' => 'required',
        ]);
        if($this->guardLogin($request,'admin')){
            return redirect()->intended('/admin/admins');
        }
        return back()->withInput($request->only('name','remember'));
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->intended('/');
    }
}
