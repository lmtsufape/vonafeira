<?php

namespace projetoGCA;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function unidadeVenda(){
        return $this->hasOne(UnidadeVenda::class, 'id', 'unidadevenda_id');
    }

    public function grupoConsumo(){
        return $this->belongsTo(GrupoConsumo::class, 'grupoconsumo_id');
    }

    public function produtor(){
        return $this->belongsTo(Produtor::class, 'produtor_id');
    }
}
