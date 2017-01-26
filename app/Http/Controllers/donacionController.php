<?php

namespace App\Http\Controllers;

use App\donacionmodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class donacionController extends Controller
{
    public function registrarDonaciones(Request $request)
    {
        $donacion = new donacionmodel();
        $donacion->setNumResolucion($request->numResolucion);
        $donacion->setFechaIngreso($request->fechaIngreso);
        $donacion->setDescripcion($request->descripcion);
        $donacion->setMonto($request->monto);
        $nombreT = $request ->nombreTramite;
        $idD = $donacion->bdTramite($nombreT);
        $donacion->setIdTramite($idD);
        $don= $donacion->save();

        if($don==true) {
            return view('Administrador/DonacionesYTransacciones/Add');
        }
        else{
            return view('Administrador/DonacionesYTransacciones/Add');
        }
    }

    public function autocompletet(Request $request)
    {
        $data = DB::table('tramite')->select("nombre as name")->where("nombre", "LIKE", "%{$request->input('query')}%")->get();

        return response()->json($data);
    }

}
