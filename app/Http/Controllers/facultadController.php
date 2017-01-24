<?php

namespace App\Http\Controllers;

use App\facultadmodel;
use Illuminate\Http\Request;
use Validator;

class facultadController extends Controller
{

    public function registrarFacultad(Request $request)
    {

        $this->validate($request, [
                'CodigoFacultad' => 'Required|numeric',
                'NombreFacultad' => 'required',
                'CuentaInterna' => 'required|numeric',
            ]

        );

        $facultad = new facultadmodel();
        $facultad->setCodFacultad($request->CodigoFacultad);
        $facultad->setNombre($request->NombreFacultad);
        $facultad->setNroCuenta($request->CuentaInterna);
        $fac=$facultad->save();
        if ($fac!=null) {
            return back() ->with('true','Facultad '.$request->NombreFacultad.' guardada')->withInput();
        } else {
            return back() ->with('false','Facultad '.$request->NombreFacultad.' no guardada, puede que ya exista');
        }
    }
}
