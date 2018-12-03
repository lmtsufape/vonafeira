<?php

namespace projetoGCA;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    public function unidadeVenda(){
        return $this->hasOne(UnidadeVenda::class, 'id', 'unidadevenda_id');
    }

    public function grupoConsumo(){
        return $this->belongsTo(GrupoConsumo::class, 'grupoconsumo_id');
    }
}
