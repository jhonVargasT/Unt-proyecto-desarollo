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

    public function cargarFacultad($idFacultad)
    {

        $facultad = new facultadmodel();
        $fac = $facultad->consultarFacultadid($idFacultad);

        return view('Administrador/Facultad/Edit')->with(['facultad' => $fac]);
    }

    public function editarFacultad($idFacultad,Request $request)
    {
        $facultad = new facultadmodel();
        $facultad->setCodFacultad($request->CodigoFacultad);
        $facultad->setNombre($request->NombreFacultad);
        $facultad->setNroCuenta($request->CuentaInterna);
        $facultad->editarFacultad($idFacultad);

            return view('Administrador/Facultad/Search')->with(['nombre'=>$request->NombreFacultad]);


    
    }

    public function listarFacultad(Request $request)
    {
        $fac = null;
        $facultad = new facultadmodel();

        if ($request->select == 'Codigo facultad' ) {
            $fac = $facultad->consultarFacultadesCodigo($request->text);
        } else {
            if ($request->select == 'Nombre Facultad' ) {
                $fac = $facultad->consultarFacultadesNombre($request->text);
            } else {
                if ($request->select == 'Cuenta Interna' ) {
                    $fac = $facultad->consultarFacultadesCuentaInterna($request->text);
                }
            }
        }
        return view('Administrador/Facultad/Search')->with(['facultad' => $fac, 'txt' => $request->text, 'select' => $request->select]);

    }
    
    public function eliminarFacultad($idFacultad,Request $request)
    {
        $facultad = new facultadmodel();
        $facultad->eliminarFacultad($idFacultad);
        return view('Administrador/Facultad/Search')->with(['nombre'=>$request->NombreFacultad]);
    }
}
