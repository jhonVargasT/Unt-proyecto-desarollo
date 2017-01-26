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

        if ($facu == true) {
            return view('/Administrador/Facultad/Add');
        } else {
            return view('/Administrador/Facultad/Add');
        }
    }

    public function listarFacultad(Request $request)
    {
        $fac = null;
        $facultad = new facultadmodel();

        if ($request->select == 'Codigo facultad') {

            $fac = $facultad->consultarFacultadesCodigo($request->text);
        } else {
            if ($request->select == 'Nombre Facultad') {
                $fac = $facultad->consultarFacultadesNombre($request->text);
            } else {
                if ($request->select == 'Cuenta Interna') {
                    $fac = $facultad->consultarFacultadesCuentaInterna($request->text);
                }
            }
        }
        return view('Administrador/Facultad/Search')->with(['facultad' => $fac, 'txt' => $request->text]);

    }

}
