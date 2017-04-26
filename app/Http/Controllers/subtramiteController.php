<?php

namespace App\Http\Controllers;

use App\subtramitemodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class subtramiteController extends Controller
{
    public function registrarSubtramite(Request $request)
    {
        if ($request->nombreTramite != ' ') {
            $subtramite = new subtramitemodel();
            $subtramite->setCuenta($request->cuentaContable);
            $subtramite->setNombre($request->nombreSubTramite);
            $subtramite->setPrecio($request->precio);
            $idTra = $subtramite->bdTramite($request->nombreTramite);
            $subtramite->setIdTramite($idTra);
            $sub = $subtramite->save();
        } else {
            $sub = false;
        }
        if ($sub == true) {
            return back()->with('true', 'Subtramite ' . $request->nombre . ' guardada con exito')->withInput();
        } else {
            return back()->with('false', 'Subtramite ' . $request->nombre . ' no guardada, puede que ya exista');
        }
    }

    public function cargarSubtramite($codTramite)
    {
        $subtramite = new subtramitemodel();
        $sub = $subtramite->consultarSubtramiteid($codTramite);
        return view('Administrador/SubTramite/Edit')->with(['subtramite' => $sub]);
    }

    public function editarSubtramite($codSubtramite, Request $request)
    {
        $subtramite = new subtramitemodel();
        $subtramite->setCuenta($request->cuentaContable);
        $subtramite->setNombre($request->nombreSubTramite);
        $subtramite->setPrecio($request->precio);
        $idTra = $subtramite->bdTramite($request->nombreTramite);
        $subtramite->setIdTramite($idTra);
        $subtramite->editarSubtramite($codSubtramite);

        return view('Administrador/SubTramite/search')->with(['nombre' => $request->nombreSubTramite]);
    }

    public function listarSubtramite(Request $request)
    {
        $valueA = Session::get('tipoCuentaA');
        $valueR = Session::get('tipoCuentaR');
        $sub = null;
        $subtramite = new subtramitemodel();

        if ($request->select == 'Tramite') {
            $sub = $subtramite->consultarSubtramiteTramite($request->text);
        } else {
            if ($request->select == 'Nombre subtramite') {
                $sub = $subtramite->consultarSubtramiteNombre($request->text);
            } else {
                if ($request->select == 'Cuenta contable') {
                    $sub = $subtramite->consultarSubtramiteCuenta($request->text);
                } else {
                    $sub = $subtramite->consultarSubtramites();
                }
            }
        }
        if ($valueA == 'Administrador')
            return view('Administrador/SubTramite/search')->with(['subtramite' => $sub, 'txt' => $request->text, 'select' => $request->select]);
        if ($valueR == 'Reportes')
            return view('Reportes/SubTramite/search')->with(['subtramite' => $sub, 'txt' => $request->text, 'select' => $request->select]);
    }

    public function eliminarSubtramite($codSubtramite, Request $request)
    {
        $subtramite = new subtramitemodel();
        $sub = $subtramite->eliminarSubtramite($codSubtramite);

        if ($sub == true) {
            return back()->with('true', 'Subtramite ' . $request->nombre . ' se elimino con exito')->withInput();
        } else {
            return back()->with('false', 'Subtramite ' . $request->nombre . ' no se elimino');
        }
    }

    public function nombreSCT(Request $request)
    {
        $sbnombre = null;
        $subtramitebd = DB::select('select nombre from subtramite where codSubtramite = "' . $request->ct . '"');

        foreach ($subtramitebd as $sb) {
            $sbnombre = $sb->nombre;
        }
        return $sbnombre;
    }
}
