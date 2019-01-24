<?php

namespace projetoGCA;

use Illuminate\Database\Eloquent\Model;

class LocalRetiradaEvento extends Model
{
    public function evento(){
        return $this->belongsTo(LocalRetirada::class, 'evento_id');
    }

    public function localretirada(){
        return $this->belongsTo(LocalRetirada::class, 'localretirada_id');
    }

    public function pedidos(){
        return $this->hasMany(Pedido::class);
    }
}
