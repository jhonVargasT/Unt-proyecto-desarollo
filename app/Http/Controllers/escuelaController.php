<?php

namespace App\Http\Controllers;

use App\escuelamodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class escuelaController extends Controller
{

    public function registrarEscuela(Request $request)
    {
        if ($request->nombreFacultad != ' ') {
            $escuela = new escuelamodel();
            $escuela->setCodEscuela($request->codEscuela);
            $escuela->setNombre($request->nombre);
            $escuela->setNroCuenta($request->nroCuenta);
            $coF = $escuela->buscarFacultad($request->nombreFacultad, $request->nombreSede);
            $escuela->setFacultad($coF);

            $esc = $escuela->saveescuela();
        } else
            $esc = false;
        if ($esc == true) {
            return back()->with('true', 'Escuela ' . $request->nombre . ' guardada con exito')->withInput();
        } else {
            return back()->with('false', 'Escuela ' . $request->nombre . ' no guardada, puede que ya exista');
        }
    }

    public function autocompletee(Request $request)
    {
        $data = DB::table('facultad')->select("nombre as name")->where("nombre", "LIKE", "%{$request->input('query')}%")->get();

        return response()->json($data);
    }

    public function cargarEscuela($idEscuela)
    {

        $escuela = new escuelamodel();
        $esc = $escuela->consultarEscuelaid($idEscuela);

        return view('Administrador/Escuela/Edit')->with(['escuela' => $esc]);
    }

    public function editarEscuela($idEscuela, Request $request)
    {
        $escuela = new escuelamodel();
        $escuela->setCodEscuela($request->codEscuela);
        $escuela->setNombre($request->nombre);
        $escuela->setNroCuenta($request->nroCuenta);
        $coF = $escuela->buscarFacultad($request->nombreFacultad, $request->nombreSede);
        $escuela->setFacultad($coF);
        $escuela->editarEscuela($idEscuela);
        return view('Administrador/Escuela/search')->with(['nombre' => $request->nombre]);
    }

    public function listarEscuela(Request $request)
    {
        $valueA = Session::get('tipoCuentaA');
        $valueR = Session::get('tipoCuentaR');
        $esc = null;
        $escuela = new escuelamodel();

        if ($request->select == 'Codigo Escuela') {
            $esc = $escuela->consultarEscuelaCodigo($request->text);
        } else {
            if ($request->select == 'Nombre Escuela') {
                $esc = $escuela->consultarEscuelasNombre($request->text);
            } else {
                if ($request->select == 'Cuenta Interna') {
                    $esc = $escuela->consultarEscuelasCuentaInterna($request->text);
                } else {
                    if ($request->select == 'Facultad') {
                        $esc = $escuela->consultarEscuelasFacultad($request->text);
                    } else {
                        $esc = $escuela->consultarEscuelas();
                    }
                }
            }
        }
        if ($valueA == 'Administrador')
            return view('Administrador/Escuela/search')->with(['escuela' => $esc, 'txt' => $request->text, 'select' => $request->select]);
        if ($valueR == 'Reportes')
            return view('Reportes/Escuela/search')->with(['escuela' => $esc, 'txt' => $request->text, 'select' => $request->select]);
    }

    public function eliminarEscuela($idEscuela, Request $request)
    {
        $escuela = new escuelamodel();
        $esc=$escuela->eliminarEscuela($idEscuela);

        if ($esc == true) {
            return back()->with('true', 'Escuela ' . $request->nombre . ' se elimino con exito')->withInput();
        } else {
            return back()->with('false', 'Escuela ' . $request->nombre . ' no se elimino');
        }
    }

    public function searchE(Request $request)
    {
        $products = DB::select('select escuela.nombre as nombre from escuela
        left join facultad on facultad.idFacultad = escuela.codigoFacultad 
        where  facultad.idFacultad = escuela.codigoFacultad  and escuela.estado=1
        and facultad.estado=1 and facultad.nombre = "' . $request->facultad . '"   and escuela.nombre like "%' . $request->term . '%" ');

        $data = array();
        foreach ($products as $product) {
            $data[] = array('value' => $product->nombre);
        }
        if (count($data))
            return $data;
        else
            return ['value' => 'No se encuentra'];
    }

    public function autoCompleteEscuelaSede(Request $request)
    {
        $products = DB::select('select facultad.nombre as nombre from facultad
        left join sede on facultad.coSede=sede.codSede 
        where facultad.coSede=sede.codSede and sede.estado=1
        and facultad.estado=1  and sede.nombresede = "' . $request->sede . '"   and facultad.nombre like "%' . $request->term . '%" ');

        $data = array();
        foreach ($products as $product) {
            $data[] = array('value' => $product->nombre);
        }
        if (count($data))
            return $data;
        else
            return ['value' => 'No se encuentra'];
    }
}
