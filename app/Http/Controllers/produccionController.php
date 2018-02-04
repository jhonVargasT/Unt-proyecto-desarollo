<?php

namespace App\Http\Controllers;

use App\pagomodel;
use App\personamodel;
use App\produccionmodel;
use App\subtramitemodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class produccionController extends Controller
{
    public function registrarProduccion(Request $request)
    {
        $produccion = new produccionmodel();
        $produccion->setNombre($request->nombre);
        $produccion->setDirecion($request->direccion);

        $pro = $produccion->saveProduccion();

        if ($pro == true) {
            return back()->with('true', 'Produccion ' . $request->nombre . ' guardada con exito')->withInput();
        } else {
            return back()->with('false', 'Produccion ' . $request->nombre . ' no se guardado');
        }
    }

    public function cargarProduccion($codProduccion)
    {
        $produccion = new produccionmodel();
        $pro = $produccion->consultarProduccionid($codProduccion);//Obtiene los datos del alumno por su codigo de persona

        return view('Administrador/Produccion/Edit')->with(['produccion' => $pro]);
    }

    public function editarProduccion($codProduccion, $codPersona, $idAlumno, $codProduccionAlumno, Request $request)
    {
        $produccion = new produccionmodel();
        $produccion->setNombre($request->nombre);
        $produccion->setDirecion($request->direccion);
        $produccion->editarProduccion($codProduccion, $codPersona, $idAlumno, $codProduccionAlumno);//Ejecuta la consulta de actualizar los datos del alumno
        return view('Administrador/Produccion/Search')->with(['nombre' => $request->nombres]);
    }

    public function eliminarProduccion($codProduccion, $codPersona, $idAlumno, $codProduccionAlumno, Request $request)
    {
        $produccion = new produccionmodel();
        $val = $produccion->eliminarProduccion($codProduccion, $codPersona, $idAlumno, $codProduccionAlumno);//SQL que cambia de estado al registro
        if ($val == true) {
            return back()->with('true', 'Banco ' . $request->nombre . ' eliminado con exito')->withInput();
        } else {
            return back()->with('false', 'Sede ' . $request->nombre . ' no eliminada');
        }
    }

    public function listarProduccion(Request $request)
    {
        $prod = null;
        $produccion = new produccionmodel();

        if ($request->select == 'Todo') {
            $prod = $produccion->consultarProduccion();//Sql que busca al banco por su nombre
        } else {
            if ($request->select == 'Nombre') {
                $prod = $produccion->consultarProduccionxNombre($request->text);//Sql que busca al banco por el numero de cuenta
            } else {
                if ($request->select == 'Direccion') {
                    $prod = $produccion->consultarProduccionxDireccion($request->text);//Sql que busca a todos los bancos
                }
            }
        }
        return view('Administrador/Produccion/Search')->with(['produccion' => $prod, 'txt' => $request->text, 'select' => $request->select]);
    }

    public function autocompleteprod(Request $request)
    {
        $data = DB::table('produccion')->select("nombre as name")->where("nombre", "LIKE", "%{$request->input('query')}%")->get();
        return response()->json($data);
    }

    public function registrarPagoProduccion(Request $request)
    {
        //$d = $request->fecha;
        //$fecha = date("Y-m-d", strtotime($d));
        //$date = implode("-", array_reverse(explode("/", $fecha)));
        $cont = 0;
        $pers = new personamodel();
        $subt = new subtramitemodel();
        $prod = new produccionmodel();
        $codSubtramite = null;
        $codper = $pers->obtnerIdNombre($request->produccion);
        $codprod = $prod->getIdAlumnoProduccion($request->produccion);
        if ($request->subtramite) {//si existe nombre de la tasa
            $codSubtramite = $subt->consultarSubtramiteidNombre($request->subtramite);//SQL, obtener id de la tasa por nombre de tasa
            $cont = $this->contadorSubtramite($request->subtramite);//SQL, obtener contador de la tasa por nombre de tasa
        } elseif ($request->txtsub) {//si existe codigo de la tasa
            $codSubtramite = $subt->consultarSubtramiteidNombre($request->txtsub);//SQL, obtener id de la tasa por nombre de tasa
            $cont = $this->contadorSubtramite($request->txtsub);//SQL, obtener contador de la tasa por nombre de tasa
        }
        date_default_timezone_set('America/Lima');
        $dato = date('Y-m-d H:i:s');
        $cantidad = $request->multiplicador;

        $p = new pagomodel();
        $p->setModalidad('ventanilla');
        $p->setDetalle($request->detalle);
        $p->setFecha($dato);
        $idper = Session::get('idpersonal', 'No existe session');
        $p->setCoPersonal($idper);
        $p->setIdPersona($codper);
        $p->setIdSubtramite($codSubtramite);
        $p->setCantidad($cantidad);
        $p->setIdProduccionAlumno($codprod);
        $contaux = $cont + 1;
        $valid = $p->savePago($contaux);//SQL, insersion del pago
        if ($valid == true) {
            return back()->with('true', 'Donacion ' . $request->numResolucion . ' guardada con exito')->withInput();
        } else {
            return back()->with('false', 'Donacion ' . $request->numResolucion . ' no guardada, puede que ya exista');
        }
    }

    public function contadorSubtramite($nombreSubtramite)
    {
        $cont = null;
        $contador = DB::select('select contador from subtramite where subtramite.estado=1 and subtramite.nombre="' . $nombreSubtramite . '"');
        foreach ($contador as $c) {
            $cont = $c->contador;
        }
        return $cont;
    }

    public function buscarProduccion()
    {
        $produccion = DB::select('select nombre from produccion where estado=1');

        $data = array();
        $i = 0;
        foreach ($produccion as $p) {
            $data[$i] = array($p->nombre);
            $i++;
        }
        return $data;
    }
}
