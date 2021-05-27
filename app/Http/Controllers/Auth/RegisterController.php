<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255','unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required','string'],
            'address' => ['required','string','max:255'],
            'admin_id' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'address' => $data['address'],
        ]);
    }

    public function guardLogin(Request $request,$guard){
        return Auth::guard($guard)->attempt([
            'name' => $request->name,
            'password' => $request->password,
        ],
        $request->get('remember')
    );
    }

    public function showRegister(){
        return view('auth.register',['uri'=>'admin']);
    }

    public function postRegister(Request $request){
        $request->validate([
            'name' => 'string|unique:admins',
            'password' => 'required|string|min:8|confirmed'
        ]);
        \App\Admin::create([
            'name' => $request->name,
            'code' => Str::uuid(),
            'password' => Hash::make($request->password),
        ]);
        if($this->guardLogin($request,'admin')){
            return redirect()->route('admins.index');
        }
        return back()->withInput($request->only('name','remember'));
    }
}
