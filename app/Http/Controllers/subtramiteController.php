<?php

namespace App\Http\Controllers;

use App\subtramitemodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class subtramiteController extends Controller
{
    //Registrar Tasas
    public function registrarSubtramite(Request $request)
    {
        if ($request->nombreTramite != ' ') {
            $subtramite = new subtramitemodel();
            $subtramite->setCodigotasa($request->codigotasa);
            $subtramite->setNombre($request->nombreSubTramite);
            $subtramite->setPrecio($request->precio);
            $idTra = $subtramite->bdTramite($request->nombreTramite);//SQL, obtener id de clasificador por nombre
            $subtramite->setIdTramite($idTra);
            $subtramite->setUnidad($request->unidad);

            $sub = $subtramite->save();//SQL, insertar registro de la tasa
        } else {
            $sub = false;
        }
        if ($sub == true) {
            return back()->with('true', 'Tasa ' . $request->nombre . ' guardada con exito')->withInput();
        } else {
            return back()->with('false', 'Tasa ' . $request->nombre . ' no guardada, puede que ya exista');
        }
    }

    //Cargar datos de la tasa
    public function cargarSubtramite($codTramite)
    {
        $subtramite = new subtramitemodel();
        $sub = $subtramite->consultarSubtramiteid($codTramite);//SQL, obtener datos de la tasa por codigo de tasa
        return view('Administrador/SubTramite/Edit')->with(['subtramite' => $sub]);
    }

    //Editar registro de la tasa
    public function editarSubtramite($codSubtramite, Request $request)
    {
        $subtramite = new subtramitemodel();
        $subtramite->setCodigotasa($request->codigotasa);
        $subtramite->setNombre($request->nombreSubTramite);
        $subtramite->setPrecio($request->precio);
        $idTra = $subtramite->bdTramite($request->nombreTramite);//SQL, obtener id de clasificador por nombre
        $subtramite->setIdTramite($idTra);
        $subtramite->setUnidad($request->unidad);

        $subtramite->editarSubtramite($codSubtramite);//SQL, actualizar datos de la tasa

        return view('Administrador/SubTramite/search')->with(['nombre' => $request->nombreSubTramite]);
    }

    //Buscar tasas
    public function listarSubtramite(Request $request)
    {
        $valueA = Session::get('tipoCuentaA');
        $valueR = Session::get('tipoCuentaR');
        $sub = null;
        $subtramite = new subtramitemodel();

        if ($request->select == 'Nombre Clasificador') {
            $sub = $subtramite->consultarSubtramiteTramite($request->text);//SQL, buscar tasas por clasificador al que pertenece
        } else {
            if ($request->select == 'Nombre Tasa') {
                $sub = $subtramite->consultarSubtramiteNombre($request->text);//SQL, buscar tasa por nombre
            } else {
                if ($request->select == 'Codigo Tasa') {
                    $sub = $subtramite->consultarSubtramiteCodigoTasa($request->text);//SQL, bucsar tasa por numero de cuenta
                } else {
                    $sub = $subtramite->consultarSubtramites();//SQL, buscar todas las tasas
                }
            }
        }
        if ($valueA == 'Administrador')
            return view('Administrador/SubTramite/search')->with(['subtramite' => $sub, 'txt' => $request->text, 'select' => $request->select]);
        if ($valueR == 'Reportes')
            return view('Reportes/SubTramite/search')->with(['subtramite' => $sub, 'txt' => $request->text, 'select' => $request->select]);
    }

    //Eliminar registro de la tasa
    public function eliminarSubtramite($codSubtramite, Request $request)
    {

        $subtramite = new subtramitemodel();
        $sub = $subtramite->eliminarSubtramite($codSubtramite);//SQL, eliminar(cambiar de 1 a 0) el registro de la tasa por codigo de tasa
        if ($sub == true) {
            return back()->with('true', 'Tasa ' . $request->nombre . ' se elimino con exito')->withInput();
        } else {
            return back()->with('false', 'Tasa ' . $request->nombre . ' no se elimino');
        }
    }

    //AJAX autollenado, buscar nombre de tasa por codigo de tasa
    public function nombreSCT(Request $request)
    {
        $sbnombre = null;
        $subtramitebd = DB::select('select nombre from subtramite where codigoSubtramite = "' . $request->ct . '"');

        foreach ($subtramitebd as $sb) {
            $sbnombre = $sb->nombre;
        }
        return $sbnombre;
    }

    public function codigoSubtramite(Request $request)
    {
        $sbcd = null;
        $subtramitebd = DB::select('select codigoSubtramite from subtramite where nombre = "' . $request->name . '"');

        foreach ($subtramitebd as $sb) {
            $sbcd = $sb->codigoSubtramite;
        }
        return $sbcd;
    }
}
