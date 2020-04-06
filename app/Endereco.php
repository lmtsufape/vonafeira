<?php

namespace projetoGCA;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    //

    public function users(){
        return $this->hasMany(User::class, 'endereco_id', 'id');
    }
}
