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
        $fac = $facultad->consultarFacultadesid($idFacultad);

        return view('Administrador/Facultad/Edit')->with(['facultad' => $fac]);
    }

    public function editarFacultad($idFacultad,Request $request)
    {
        $facultad = new facultadmodel();
        $facultad->setCodFacultad($request->CodigoFacultad);
        $facultad->setNombre($request->NombreFacultad);
        $facultad->setNroCuenta($request->CuentaInterna);
        $facultad->editarFacultad($idFacultad);
    
    }

    public function listarFacultad(Request $request)
    {
        $fac = null;
        $facultad = new facultadmodel();

        if ($request->select == 'Codigo facultad' && $request->text = !null) {
            $fac = $facultad->consultarFacultadesCodigo($request->text);
        } else {
            if ($request->select == 'Nombre Facultad' && $request->text = !null) {
                $fac = $facultad->consultarFacultadesNombre($request->text);
            } else {
                if ($request->select == 'Cuenta Interna' && $request->text = !null) {
                    $fac = $facultad->consultarFacultadesCuentaInterna($request->text);
                }
            }
        }
        return view('Administrador/Facultad/Search')->with(['facultad' => $fac, 'txt' => $request->text, 'select' => $request->select]);

    }
}
