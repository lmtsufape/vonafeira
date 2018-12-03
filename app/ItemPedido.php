<?php

namespace projetoGCA;

use Illuminate\Database\Eloquent\Model;
use \projetoGCA\Pedido;
class ItemPedido extends Model
{
    public function pedido(){
        return $this->belongsTo(Pedido::class, "pedido_id");
    }
}
