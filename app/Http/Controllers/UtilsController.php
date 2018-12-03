<?php

namespace projetoGCA\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
class UtilsController extends Controller
{
    

    public static function dataFormato($date, $formato){
        $date = new DateTime($date);
        return $date->format($formato);
    }
}
