<?php

namespace App\Http\Controllers;

use App\facultadmodel;
use Illuminate\Http\Request;

class facultadController extends Controller
{

    public function registrarFacultad(Request $request)
    {
        $facultad = new facultadmodel();
        $facultad->setCodFacultad($request->codFacultad);
        $facultad->setNombre($request->nombre);
        $facultad->setNroCuenta($request->nroCuenta);
        $facu = $facultad->save();

        if($facu!=null) {
            return view('/Administrador/Facultad/Add');
        }
        else{
            return view('/Administrador/Facultad/Add');
        }
    }
}
