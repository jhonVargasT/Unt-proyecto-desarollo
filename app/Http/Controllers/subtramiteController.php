<?php

namespace App\Http\Controllers;

use App\subtramitemodel;
use Illuminate\Http\Request;

class subtramiteController extends Controller
{
    public function registrarSubtramite(Request $request)
    {
        $subtramite = new subtramitemodel();
        $subtramite->setCuenta($request->cuenta);
        $subtramite->setNombre($request->nombre);
        $subtramite->setPrecio($request->precio);
        $idTra=$subtramite->bdTramite('nombre');
        $subtramite->setIdTramite($idTra);
        $subtramite->save();

    }
}
