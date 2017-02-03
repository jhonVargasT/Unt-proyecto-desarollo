<?php

namespace App\Http\Controllers;

use App\donacionmodel;
use App\loguntemodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class donacionController extends Controller
{
    public function registrarDonaciones(Request $request)
    {
        $donacion = new donacionmodel();
        $donacion->setNumResolucion($request->numResolucion);
        $donacion->setFechaIngreso($request->fechaIngreso);
        $donacion->setDescripcion($request->descripcion);
        $donacion->setMonto($request->monto);
        $nombreT = $request->nombreTramite;
        $idD = $donacion->bdTramite($nombreT);
        $donacion->setIdTramite($idD);
        $dona= $donacion->saveDonacion();

        if ($dona == true) {
            return back()->with('true', 'Donacion ' . $request->numResolucion . ' guardada con exito')->withInput();
        } else {
            return back()->with('false', 'Donacion ' . $request->numResolucion . ' no guardada, puede que ya exista');
        }
    }

    public function autocompletet(Request $request)
    {
        $data = DB::table('tramite')->select("nombre as name")->where("nombre", "LIKE", "%{$request->input('query')}%")->get();
        return response()->json($data);
    }

    public function cargarDonacion($codDonacion)
    {
        $donacion = new donacionmodel();
        $don = $donacion->consultarDonacionid($codDonacion);
        return view('Administrador/DonacionesYTransacciones/Edit')->with(['donacion' => $don]);
    }

    public function editarDonacion($codDonacion, Request $request)
    {
        $donacion = new donacionmodel();
        $donacion->setNumResolucion($request->numeroResolucion);
        $donacion->setDescripcion($request->descripcion);
        $donacion->setMonto($request->monto);
        $donacion->setFechaIngreso($request->fechaDeIngreso);
        $donacion->editarDonacion($codDonacion);
        return view('Administrador/DonacionesYTransacciones/Search')->with(['nombre' => $request->numeroResolucion]);
    }
    //Falta buscar desde una fecha hasta otra fecha....
    public function listarDonacion(Request $request)
    {
        $don = null;
        $donacion = new donacionmodel();

        if ($request->select == 'Fecha') {
            $don = $donacion->consultarDonacionFecha($request->text);
        } else {
            if ($request->select == 'Codigo Siaf') {
                $don = $donacion->consultarDonacionCodigoSiaf($request->text);
            } else {
                if ($request->select == 'Tipo de recurso') {
                    $don = $donacion->consultarDonacionTipoRecurso($request->text);
                } else {
                    if ($request->select == 'Fuente de financiamiento') {
                        $don = $donacion->consultarDonacionFuenteFinanciamiento($request->text);
                    } else {
                        if ($request->select == 'Numero Resolucion') {
                            $don = $donacion->consultarDonacionNumeroResolucion($request->text);
                        }
                    }
                }
            }
        }
        return view('Administrador/DonacionesYTransacciones/Search')->with(['donacion' => $don, 'txt' => $request->text, 'select' => $request->select]);
    }

    public function eliminarDonacion($codDonacion, Request $request)
    {
        $donacion = new donacionmodel();
        $donacion->eliminarDonacion($codDonacion);
        return view('Administrador/DonacionesYTransacciones/Search')->with(['nombre' => $request->numeroResolucion]);
    }

}
