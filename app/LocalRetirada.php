<?php

namespace projetoGCA;

use Illuminate\Database\Eloquent\Model;

class LocalRetirada extends Model
{
    public function grupoConsumo(){
        return $this->belongsTo(GrupoConsumo::class, 'grupoconsumo_id');
    }
    
    public function localretiradaevento(){
        return $this->hasMany(LocalRetiradaEvento::class);
    }
}
