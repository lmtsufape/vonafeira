<?php

namespace projetoGCA;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GrupoConsumo extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    public function coordenador(){
        return $this->belongsTo(User::class, 'coordenador_id');
    }

    public function consumidores(){
        return $this->hasMany(Consumidor::class);
    }

    public function produtos(){
        return $this->hasMany(Produto::class);
    }

    public function produtores(){
        return $this->hasMany(Produtor::class);
    }

    public function locaisRetirada(){
        return $this->hasMany(LocalRetirada::class);
    }
}
