<?php

namespace App\Http\Controllers;

use App\facultadmodel;
use App\loguntemodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Validator;

class facultadController extends Controller
{
    public function registrarFacultad(Request $request)
    {
        $facultad = new facultadmodel();
        $facultad->setCodFacultad($request->CodigoFacultad);
        $facultad->setNombre($request->NombreFacultad);
        $facultad->setNroCuenta($request->CuentaInterna);
        $codsede = $facultad->bscSedeId($request->nombreSede);
        $facultad->setCodSede($codsede);

        $fac = $facultad->save();
        if ($fac == true) {
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

    public function editarFacultad($idFacultad, Request $request)
    {
        $facultad = new facultadmodel();
        $facultad->setCodFacultad($request->CodigoFacultad);
        $facultad->setNombre($request->NombreFacultad);
        $facultad->setNroCuenta($request->CuentaInterna);
        $facultad->editarFacultad($idFacultad);
        return view('Administrador/Facultad/Search')->with(['nombre' => $request->NombreFacultad]);
    }

    public function listarFacultad(Request $request)
    {
        $fac = null;
        $facultad = new facultadmodel();
        $opciones = ['Todo', 'Codigo facultad', 'Codigo facultad', 'Nombre Facultad'];
        if ($request->select == 'Codigo Facultad') {
            $fac = $facultad->consultarFacultadesCodigo($request->text);
        } else {
            if ($request->select == 'Nombre Facultad') {
                $fac = $facultad->consultarFacultadesNombre($request->text);
            } else {
                if ($request->select == 'Cuenta Interna') {
                    $fac = $facultad->consultarFacultadesCuentaInterna($request->text);
                } else {
                    if ($request->select == 'Sede') {
                        $fac = $facultad->consultarFacultadesSede($request->text);
                    } else {
                        $fac = $facultad->consultarFacultades();
                    }
                }
            }
        }
        return view('Administrador/Facultad/Search')->with(['facultad' => $fac, 'txt' => $request->text, 'select' => $request->select, 'opciones' => $opciones]);
    }

    public function eliminarFacultad($idFacultad, Request $request)
    {
        $facultad = new facultadmodel();
        $facultad->eliminarFacultad($idFacultad);
        return view('Administrador/Facultad/Search')->with(['nombre' => $request->NombreFacultad]);
    }

    public function llenarFacultad()
    {
        $var = null;
        $facultad = new facultadmodel();
        $nombre = $facultad->llenarFacultadReporte();
        foreach ($nombre as $nom) {
            $var = $nom->nombre;
        }
        return Response::json($var);
    }
    public function autocomplete(Request $request)
    {
        $facultad = new facultadmodel();
        $data = $facultad->llenarFacultadReporte( $request->input('query'));
        return response()->json($data);
    }

    public function autocompletesede(Request $request)
    {
        $data = DB::table('sede')->select("nombresede as name")->where("nombresede", "LIKE", "%{$request->input('query')}%")->get();
        return response()->json($data);
    }
}
