<?php

namespace projetoGCA\Http\Controllers\Auth;

use projetoGCA\User;
use projetoGCA\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use projetoGCA\Endereco;

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
            'name' => 'required|string|max:255|regex:/^\s*\S+(?:\s+\S+){1,}$/',
            'email' => 'required|string|email|max:255|unique:users',
            'telefone' => 'required|regex:/^\(\d{2}\)\s\d{4,5}-\d{4}$/',
            'password' => 'required|string|min:6|confirmed',

            'cep'=> 'required_with:rua,bairro,cidade,uf',
            'rua' => 'required_with:cep,bairro,cidade,uf',
            'bairro' => 'required_with:cep,rua,cidade,uf',
            'cidade' => 'required_with:cep,rua,bairro,uf',
            'uf' => 'required_with:cep,rua,bairro,cidade',
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
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);  
        $user->telefone = $data['telefone'];
        $user->save();
        
        if($data['cep'] != null){
            $end = new Endereco();
            $end->rua = $data['rua'];           
            $end->numero = $data['numero'];
            $end->bairro = $data['bairro'];
            $end->cidade = $data['cidade'];
            $end->uf = $data['uf'];
            $end->cep = $data['cep'];
            
            
            $user->endereco()->save($end);
        }

        return $user;
    }
}
