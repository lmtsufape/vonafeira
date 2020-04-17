<?php

namespace projetoGCA;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    //

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function pedidos(){
        return $this->hasMany(Pedido::class, 'endereco_consumidor_id', 'id');
    }
}
