<?php

namespace projetoGCA;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    public function usuario(){
        return $this->belongsTo(User::class);
    }
}
