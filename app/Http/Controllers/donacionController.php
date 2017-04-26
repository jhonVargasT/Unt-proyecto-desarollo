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
        $date = implode("-", array_reverse(explode("/", $request->fecha)));
        $donacion->setFechaIngreso($date);
        $donacion->setDescripcion($request->descripcion);
        $donacion->setMonto($request->monto);
        $nombreT = $request->nombreTramite;
        $idD = $donacion->bdTramite($nombreT);
        $donacion->setIdTramite($idD);
        $idB = $donacion->obteneridBanco($request->cuenta);
        $donacion->setIdBanco($idB);
        $dona = $donacion->saveDonacion();

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

    public function tipoRecurso(Request $request)
    {
        $var = $request->name;
        $nombreT = DB::select('select tipoRecurso from tramite where nombre=:nombre and estado=1', ['nombre' => $var]);
        foreach ($nombreT as $n) {
            $dato = $n->tipoRecurso;
            return response()->json($dato);
        }
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
        $donacion->setNumResolucion($request->numResolucion);
        $d = $request->fecha;
        $date = implode("-", array_reverse(explode("/", $d)));
        $donacion->setFechaIngreso($date);
        $donacion->setDescripcion($request->descripcion);
        $donacion->setMonto($request->monto);
        $nombreT = $request->nombreTramite;
        $idD = $donacion->bdTramite($nombreT);
        $donacion->setIdTramite($idD);
        $idB = $donacion->obteneridBanco($request->cuenta);
        $donacion->setIdBanco($idB);
        $donacion->editarDonacion($codDonacion);
        return view('Administrador/DonacionesYTransacciones/Search')->with(['nombre' => $request->numResolucion]);
    }

    public function listarDonaciones(Request $request)
    {
        $valueA = Session::get('tipoCuentaA');
        $valueR = Session::get('tipoCuentaR');

        $don = null;
        $donacion = new donacionmodel();

        if ($request->select == 'Tramite') {
            $don = $donacion->consultarDonacionTramite($request->text);
        } else {
            if ($request->select == 'Fecha') {
                $don = $donacion->consultarDonacionFecha($request->text);
            } else {
                if ($request->select == 'Tipo de recurso') {
                    $don = $donacion->consultarDonacionTipoRecurso($request->text);
                } else {
                    if ($request->select == 'Fuente de financiamiento') {
                        $don = $donacion->consultarDonacionFuenteFinanciamiento($request->text);
                    } else {
                        if ($request->select == 'Numero Resolucion') {
                            $don = $donacion->consultarDonacionNumeroResolucion($request->text);
                        } else {
                            $don = $donacion->consultarDonaciones();
                        }
                    }
                }
            }
        }
        if ($valueA == 'Administrador')
            return view('Administrador/DonacionesYTransacciones/Search')->with(['donacion' => $don, 'txt' => $request->text, 'select' => $request->select]);
        if ($valueR == 'Reportes')
            return view('Reportes/DonacionYTransacciones/Search')->with(['donacion' => $don, 'txt' => $request->text, 'select' => $request->select]);

    }

    public function eliminarDonacion($codDonacion, Request $request)
    {
        $donacion = new donacionmodel();
        $dona = $donacion->eliminarDonacion($codDonacion);

        if ($dona == true) {
            return back()->with('true', 'Donacion ' . $request->numResolucion . ' se elimino con exito')->withInput();
        } else {
            return back()->with('false', 'Donacion ' . $request->numResolucion . ' no elimno');
        }
    }

    public function banco()
    {
        $products = DB::select('select banco, cuenta from banco where estado=1');

        $data = array();
        foreach ($products as $product) {
            $data[] = array($product->banco, $product->cuenta);
        }
        return $data;
    }

}
