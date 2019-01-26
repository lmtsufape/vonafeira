<?php

namespace projetoGCA;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LocalRetirada extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function grupoConsumo(){
        return $this->belongsTo(GrupoConsumo::class, 'grupoconsumo_id');
    }

    public function localretiradaevento(){
        return $this->hasMany(LocalRetiradaEvento::class);
    }
}
