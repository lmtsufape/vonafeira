<?php

namespace projetoGCA;

use Illuminate\Database\Eloquent\Model;

class Produtor extends Model
{
  public function produtos(){
      return $this->hasMany(Produto::class);
  }

  public function grupoConsumo(){
      return $this->belongsTo(GrupoConsumo::class, 'grupoconsumo_id');
  }
}
