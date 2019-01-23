<?php

namespace projetoGCA;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produtor extends Model
{
  use SoftDeletes;

  public function produtos(){
      return $this->hasMany(Produto::class);
  }

  public function grupoConsumo(){
      return $this->belongsTo(GrupoConsumo::class, 'grupoconsumo_id');
  }
}
