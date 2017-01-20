<?php

namespace App\Http\Controllers;

use App\donacionmodel;
use Illuminate\Http\Request;

class donacionController extends Controller
{
    public function registrarDonaciones(Request $request)
    {
        $donacion = new donacionmodel();
        $donacion->setNumResolucion($request->numResolucion);
        $donacion->setFechaIngreso($request->fechaIngreso);
        $donacion->setDescripcion($request->descripcion);
        $idD = $donacion->bdTramite('nombre');
        $donacion->setIdTramite($idD);
        $don= $donacion->save();

        if($don!=null) {
            return view('donacion');
        }
        else{
            return view('donacion');
        }
    }
}
