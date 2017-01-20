<?php

namespace App\Http\Controllers;
use App\escuelamodel;

use Illuminate\Http\Request;

class escuelaController extends Controller
{

    public function registrarEscuela(Request $request)
    {
        $escuela = new escuelamodel();
        $escuela ->setCodEscuela($request->codEscuela);
        $escuela ->setNombre($request->nombre);
        $escuela ->setNroCuenta($request->nroCuenta);
        $coF=$escuela ->buscarFacultad($request->nombreFacultad);
        $escuela->setFacultad($coF);
        $rg=$escuela->save();

        if($rg!=null) {
            return view('/Administrador/Escuela/Add');
        }
        else{
            return view('/Administrador/Escuela/Add');
        }
    }

    /*public function poblarFacultad()
    {
        $facultad = new facultadmodel();
        $valor = $facultad->consultarNombreFacultades();

        return view('/Administrador/Escuela/Add',['valores' => $valor]);
    }*/
}
