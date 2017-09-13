<?php

namespace Corp\Http\Controllers\Auth;
use Corp\Role;
use Illuminate\Foundation\Auth\RegistersUsers;
use Validator;
use Corp\Repositories\MenusRepository;
use Illuminate\Http\Request;

use Corp\Http\Requests;
use Corp\Http\Controllers\Controller;
use Corp\Http\Controllers\SiteController;
use Corp\User;

class RegisterController extends SiteController
{

    protected $redirectTo = '/home';
    protected function redirectTo()
    {
        return '/home';
    }


    public function __construct()
    {
        $this->middleware('guest');

    }


    public function showRegistrationForm()
    {

        return view('my.auth.register');
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|confirmed|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',


        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'login' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
             'remember_token' => $data['_token'],
            'role_user' => $data['user_role'],
        ])->hasRole(3);

    }



    public function register(Request $request)
    {
        $this->validator($request->all());
        $user = $this->create($request->all());

        // assign  endcustomer role
        //$user->roles(3);
        return redirect('/');
    }




}