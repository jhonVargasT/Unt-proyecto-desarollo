<?php

namespace App\Http\Controllers;

use App\bancomodel;
use Illuminate\Http\Request;

class bancoController extends Controller
{
    public  function registrarBanco(Request $request)
    {
        $banco = new bancomodel();
        $banco->setNombreBanco($request->nombreBanco);
        $banco->setNroCuenta($request->nombreBanco);
        $banco->guardarBanco();
    }
}
