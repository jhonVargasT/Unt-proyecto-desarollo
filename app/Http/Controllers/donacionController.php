<?php

namespace App\Http\Controllers;

use App\donacionmodel;
use App\loguntemodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class donacionController extends Controller
{
    //Registrar las donaciones y transferencias
    public function registrarDonaciones(Request $request)
    {
        $donacion = new donacionmodel();
        $donacion->setNumResolucion($request->numResolucion);
        $date = implode("-", array_reverse(explode("/", $request->fecha)));
        $donacion->setFechaIngreso($date);
        $donacion->setDescripcion($request->descripcion);
        $donacion->setMonto($request->monto);
        $nombreT = $request->nombreTramite;
        $idD = $donacion->bdTramite($nombreT);//SQL, busca al id del clasificador mediante su nombre
        $donacion->setIdTramite($idD);
        $idB = $donacion->obteneridBanco($request->cuenta);//SQL, obtener el id del banco mediante su numero de cuenta
        $donacion->setIdBanco($idB);
        $dona = $donacion->saveDonacion();//SQL, insercion de los datos de la donacion o transferencias

        if ($dona == true) {
            return back()->with('true', 'Donacion ' . $request->numResolucion . ' guardada con exito')->withInput();
        } else {
            return back()->with('false', 'Donacion ' . $request->numResolucion . ' no guardada, puede que ya exista');
        }
    }

    //Typeahead javascript para autollenar el nombre de los clasificadores
    public function autocompletet(Request $request)
    {
        $data = DB::table('tramite')->select("nombre as name")->where("nombre", "LIKE", "%{$request->input('query')}%")->get();
        return response()->json($data);
    }

    //AJAX, autollenado el tipo de recurso escogiendo el nombre del clasificador
    public function tipoRecurso(Request $request)
    {
        $var = $request->name;
        $nombreT = DB::select('select tipoRecurso from tramite where nombre=:nombre and estado=1', ['nombre' => $var]);
        foreach ($nombreT as $n) {
            $dato = $n->tipoRecurso;
            return response()->json($dato);
        }
    }

    //Cargar los datos de la donacion y transferencia para la modificacion
    public function cargarDonacion($codDonacion)
    {
        $donacion = new donacionmodel();
        $don = $donacion->consultarDonacionid($codDonacion);//SQL, buscar al registro mediante su codigo
        return view('Administrador/DonacionesYTransacciones/Edit')->with(['donacion' => $don]);
    }

    //Modifica los datos del registro buscado mediante su codigo
    public function editarDonacion($codDonacion, Request $request)
    {
        $valueA = Session::get('tipoCuentaA');
        $valueR = Session::get('tipoCuentaR');
        $donacion = new donacionmodel();
        $donacion->setNumResolucion($request->numResolucion);
        $d = $request->fecha;
        $date = implode("-", array_reverse(explode("/", $d)));
        $donacion->setFechaIngreso($date);
        $donacion->setDescripcion($request->descripcion);
        $donacion->setMonto($request->monto);
        $nombreT = $request->nombreTramite;
        $idD = $donacion->bdTramite($nombreT);//SQL, busca al id del clasificador mediante su nombre
        $donacion->setIdTramite($idD);
        $idB = $donacion->obteneridBanco($request->cuenta);//SQL, obtener el id del banco mediante su numero de cuenta
        $donacion->setIdBanco($idB);
        $donacion->editarDonacion($codDonacion);//SQL, actualizar los datos de la donacion y transferencia
        if($valueA == 'Administrador')
            return view('Administrador/DonacionesYTransacciones/Search')->with(['nombre' => $request->numResolucion]);

        if($valueR == 'Reportes')
            return view('Reportes/DonacionesYTransacciones/Search')->with(['nombre' => $request->numResolucion]);

    }

    //Buscar donaciones y transfencias
    public function listarDonaciones(Request $request)
    {
        $valueA = Session::get('tipoCuentaA');
        $valueR = Session::get('tipoCuentaR');
        $tiempo=null;
        $numero = '';
        $result = null;
        $donacion= new donacionmodel();
        $vartiemp = $request->combito;
        $varaño = $request->año1;
        if ($request->combito !== 'Escojer') {
            if ($vartiemp == 1) {
                $tiempo = 'where Year(d.fechaIngreso) = ' . $varaño . '';
                $result = $donacion->consultarDonaciones($tiempo);//SQL, buscar a la donacion y transferencia fecha
                $numero = 'DEL AÑO -' . $varaño;
            } elseif ($vartiemp == 2) {
                $tiempo = 'where MONTH(d.fechaIngreso) = ' . $request->mes2 . ' and Year(d.fechaIngreso)=' . $request->año2 . '';
                $result = $donacion->consultarDonaciones($tiempo);//SQL, buscar a la donacion y transferencia fecha
                $meses = array("ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE");
                $valor = $meses[$request->mes2 - 1];
                $numero = 'DE ' . $valor . ' DEL ' . $request->año2;

            } elseif ($vartiemp == 3) {
                $originalDate = $request->fecha;
                $fecha = date("Y-m-d", strtotime($originalDate));
                $tiempo = 'where DATE(d.fechaIngreso) =\'' . $fecha . '\'';
                $result = $donacion->consultarDonaciones($tiempo);//SQL, buscar a la donacion y transferencia fecha
                $numero = 'DE ' . $fecha;
            }
            $total = 0;
            foreach ($result as $r) {
                $total += $r->importe;
            }
            if($valueA == 'Administrador'){
                return view('Administrador/DonacionesYTransacciones/Search')->with(['result' => $result, 'total' => $total, 'fecha' => $tiempo, 'numero' => $numero]);}

            if($valueR == 'Reportes'){
                return view('Reportes/DonacionesYTransacciones/Search')->with(['result' => $result, 'total' => $total, 'fecha' => $tiempo, 'numero' => $numero]);}

        }
        else{

            if($valueA == 'Administrador')
                return view('Administrador/DonacionesYTransacciones/Search');

            if($valueR == 'Reportes')
                return view('Reportes/DonacionesYTransacciones/Search');

        }

    }


    //Eliminar(cambiar de estado 1 a 0) el registro de donacion y transferencia
    public function eliminarDonacion($codDonacion, Request $request)
    {
        $donacion = new donacionmodel();
        $dona = $donacion->eliminarDonacion($codDonacion);//SQL, cambiar de estado al registro

        if ($dona == true) {
            return back()->with('true', 'Donacion ' . $request->numResolucion . ' se elimino con exito')->withInput();
        } else {
            return back()->with('false', 'Donacion ' . $request->numResolucion . ' no elimno');
        }
    }

    //Ajax, autollenado de los datos del banco. Donaciones y transferencias
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
