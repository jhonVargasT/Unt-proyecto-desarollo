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
}
