<?php

namespace projetoGCA;

use Illuminate\Database\Eloquent\Model;

class GrupoConsumo extends Model
{
    public function coordenador(){
        return $this->hasOne(User::class);
    }

    public function consumidores(){
        return $this->hasMany(Consumidor::class);
    }

    public function produtos(){
        return $this->hasMany(Produto::class);
    }
}
