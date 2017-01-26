<?php

namespace App\Http\Controllers;

use App\subtramitemodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class subtramiteController extends Controller
{
    public function registrarSubtramite(Request $request)
    {
        $subtramite = new subtramitemodel();
        $subtramite->setCuenta($request->cuenta);
        $subtramite->setNombre($request->nombre);
        $subtramite->setPrecio($request->precio);
        $idTra = $subtramite->bdTramite($request->nombreTramite);
        $subtramite->setIdTramite($idTra);
        $var = $subtramite->save();

        if($var == true) {
            return view('Administrador/Subtramite/Add');
        }
        else{
            return view('Administrador/Subtramite/Add');
        }

    }

    public function autocomplete(Request $request)
    {
        $data = DB::table('tramite')->select("nombre as name")->where("nombre", "LIKE", "%{$request->input('query')}%")->get();

        return response()->json($data);
    }
}
