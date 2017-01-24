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
<<<<<<< Updated upstream
        $idD = $donacion->bdTramite('nombre');
=======
        $donacion->setMonto($request->monto);
        $nombreT = $request ->nombreTramite;
        $idD = $donacion->bdTramite($nombreT);
>>>>>>> Stashed changes
        $donacion->setIdTramite($idD);
        $don= $donacion->save();

        if($don!=null) {
<<<<<<< Updated upstream
            return view('donacion');
        }
        else{
            return view('donacion');
=======
            return view('Administrador/DonacionesYTransacciones/Add');
        }
        else{
            return view('Administrador/DonacionesYTransacciones/Add');
>>>>>>> Stashed changes
        }
    }
}
