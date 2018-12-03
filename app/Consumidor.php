<?php

namespace projetoGCA;

use Illuminate\Database\Eloquent\Model;
use \projetoGCA\User;
use \projetoGCA\GrupoConsumo;
use \projetoGCA\Pedido;
class Consumidor extends Model
{
    protected $table = 'consumidors';
    public function usuario(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function grupoConsumo(){
        return $this->belongsTo(GrupoConsumo::class, "grupo_consumo_id");
    }

    public function pedidos(){
        return $this->hasMany(Pedido::class, "consumidor_id", "id");
    }

    public function nome(){
        return $this->usuario->name;
    }
}
