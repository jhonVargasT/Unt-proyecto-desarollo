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
        $numero = '';
        $result = null;
        $donacion= new donacionmodel();
        $vartiemp = $request->combito;
        $varaño = $request->año1;
        if ($vartiemp == 1) {

            $tiempo = 'where Year(d.fechaIngreso) = ' . $varaño . '';
            $result = $donacion->consultarDonaciones($tiempo);
            $numero = 'DEL AÑO -'.$varaño;
        } elseif ($vartiemp == 2) {
            $tiempo = 'where MONTH(d.fechaIngreso) = ' . $request->mes2 . ' and Year(d.fechaIngreso)=' . $request->año2 . '';
            $result = $donacion->consultarDonaciones($tiempo);
            $meses = array("ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE");
            $valor = $meses[$request->mes2 - 1];
            $numero = 'DE ' . $valor . ' DEL ' . $request->año2;

        } elseif ($vartiemp == 3) {
            $originalDate = $request->fecha;
            $fecha = date("Y-m-d", strtotime($originalDate));
            $tiempo = 'where DATE(d.fechaIngreso) =\'' . $fecha . '\'';
            $result = $donacion->consultarDonaciones($tiempo);
            $numero = 'DE '.$fecha;
        }
        $total = 0;
        foreach ($result as $r) {
            $total += $r->importe;
        }
        return view('Administrador/DonacionesYTransacciones/search')->with(['result' => $result,'total'=>$total,'fecha'=>$tiempo,'numero'=>$numero]);



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
