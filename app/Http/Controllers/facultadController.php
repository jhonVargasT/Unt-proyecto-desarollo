<?php

namespace App\Http\Controllers;

use App\facultadmodel;
use Illuminate\Http\Request;
use Validator;

class facultadController extends Controller
{

    public function registrarFacultad(Request $request)
    {

        $facultad = new facultadmodel();
        $facultad->setCodFacultad($request->CodigoFacultad);
        $facultad->setNombre($request->NombreFacultad);
        $facultad->setNroCuenta($request->CuentaInterna);
        $fac = $facultad->save();
        if ($fac != null) {
            return back()->with('true', 'Facultad ' . $request->NombreFacultad . ' guardada con exito')->withInput();
        } else {
            return back()->with('false', 'Facultad ' . $request->NombreFacultad . ' no guardada, puede que ya exista');
        }
    }

    public function buscarFacultad(Request $request)
    {

    }

    public function listarFacultad(Request $request)
    {
        $fac=null;
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
        return view('Administrador/Facultad/Search')->with(['facultad' => $fac,'txt'=>$request->text]);

    }
}
