<?php

namespace projetoGCA\Http\Controllers\Auth;

use projetoGCA\User;
use projetoGCA\Http\Controllers\Controller;
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
     * Where to redirect users after registration.
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'telefone' => 'required|numeric',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \projetoGCA\User
     */
    protected function create(array $data)
    {
        // endereço
        $end = new Endereco();
        $end->rua = $data['rua'];
        $end->numero = $data['numero'];
        $end->bairro = $data['bairro'];
        $end->cidade = $data['cidade'];
        $end->uf = $data['uf'];
        $end->cep = $data['cep'];

        $end->save();
        
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);  
        $user->telefone = $data['telefone'];
        $user->enderecoId = $end->id;
        $user->save();

        return $user;
      
    }
}
