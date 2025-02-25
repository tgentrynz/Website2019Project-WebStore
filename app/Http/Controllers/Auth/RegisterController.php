<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Grower;
use App\Customer;
use App\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     * 
     * This is overriding the RegisterUsers trait
     */
    public function showRegistrationForm()
    {
        $type = Input::get('type');
        if($type == 'grower')
        {
            return view('auth.registergrower');
        }
        else
        {
            return view('auth.registercustomer');
        }
        
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * This is overriding the RegisterUsers trait
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        
        $type = Input::get('type');
        if($type == 'grower')
        {
            event(new Registered($user = $this->createGrower($request->all())));
        }
        else
        {
            event(new Registered($user = $this->create($request->all())));
        }
    
        $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }
    


    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/account';

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'customer' => Customer::create()->id,
        ]);
    }

    /**
     * Create a new grower user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function createGrower(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'grower' => Grower::create()->id,
        ]);
    }
}
