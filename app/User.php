<?php

namespace projetoGCA;

use \projetoGCA\Notifications\ResetPassword;    
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'telefone', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function endereco(){
        return $this->belongsTo(Endereco::class, 'endereco_id', 'id');
    }

    public function contato(){
        return $this->hasOne('projetoGCA\Contato');
    }

    public function consumidores(){
        return $this->hasMany(Consumidor::class, 'user_id', 'id');
    }

    public function sendPasswordResetNotification($token){
        $this->notify(new ResetPassword($token));
    }
}
