<?php

namespace App\Http\Controllers;

use App\utilmodel;

class util extends Controller
{
    public function insertarError($mensaje,$funcion)
    {
        $util=new utilmodel();
        $util->setMensaje($mensaje);
        $util->setFuncion($funcion);
        $util->insertarError();
    }
}
