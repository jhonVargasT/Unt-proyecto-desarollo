<?php

namespace App\Http\Controllers;

use App\escuelamodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class escuelaController extends Controller
{

    public function registrarEscuela(Request $request)
    {
        $escuela = new escuelamodel();
        $escuela->setCodEscuela($request->codEscuela);
        $escuela->setNombre($request->nombre);
        $escuela->setNroCuenta($request->nroCuenta);
        $coF = $escuela->buscarFacultad($request->nombreFacultad);
        $escuela->setFacultad($coF);
        $rg = $escuela->save();

        if ($rg == true) {
            return view('/Administrador/Escuela/Add');
        } else {
            return view('/Administrador/Escuela/Add');
        }
    }

    public function autocomplete(Request $request)
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
        $escuela->setCodEscuela($request->CodigoEscuela);
        $escuela->setNombre($request->NombreEscuela);
        $escuela->setNroCuenta($request->CuentaInterna);
        $escuela->editarEscuela($idEscuela);

        return view('Administrador/Escuela/Search')->with(['nombre' => $request->NombreEscuela]);
    }

    public function listarEscuela(Request $request)
    {
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
                    }
                }
            }
        }
        return view('Administrador/Escuela/search')->with(['escuela' => $esc, 'txt' => $request->text, 'select' => $request->select]);

    }
}
