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

    public function cargarDonacion($codTramite)
    {
        $donacion = new donacionmodel();
        $tra = $donacion->consultarTramiteid($codTramite);
        return view('Administrador/DonacionesYTransacciones/Edit')->with(['tramite' => $tra]);
    }

    public function editarDonacion($codTramite, Request $request)
    {
        $donacion = new donacionmodel();
        $donacion->setNombre($request->numeroResolucion);
        $donacion->setFuentefinanc($request->fechaDeIngreso);
        $donacion->setTipoRecurso($request->monto);
        $donacion->setTipoRecurso($request->descripcion);
        $donacion->editarTramite($codTramite);
        return view('Administrador/DonacionesYTransacciones/Search')->with(['nombre' => $request->nombreTramite]);
    }

    public function listarDonacion(Request $request)
    {
        $don = null;
        $donacion = new donacionmodel();

        if ($request->select == 'Clasificador Siaf') {
            $don = $donacion->consultarTramiteCS($request->text);
        } else {
            if ($request->select == 'Tipo de recurso') {
                $don = $donacion->consultarTramiteTR($request->text);
            } else {
                if ($request->select == 'Nombre de tramite') {
                    $don = $donacion->consultarTramiteN($request->text);
                } else {
                    if ($request->select == 'Fuente de financiamiento') {
                        $don = $donacion->consultarTramiteFF($request->text);
                    }
                }
            }
        }
        return view('Administrador/DonacionesYTransacciones/Search')->with(['donacion' => $don, 'txt' => $request->text, 'select' => $request->select]);
    }

}
