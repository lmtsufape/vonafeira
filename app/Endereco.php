<?php

namespace projetoGCA;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    //

    public function user(){
        return $this->belongsTo(User::class, 'author_id', 'id');
    }
}
