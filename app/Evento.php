<?php

namespace projetoGCA;

use Illuminate\Database\Eloquent\Model;
use \projetoGCA\Pedido;
use \projetoGCA\GrupoConsumo;
class Evento extends Model
{
    public function pedidos(){
        return $this->hasMany(Pedido::class);
    }

    public function grupoConsumo(){
        return $this->belongsTo(GrupoConsumo::class, "grupoconsumo_id");
    }
}
