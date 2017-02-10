<?php

namespace App\Http\Controllers;

use App\subtramitemodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class subtramiteController extends Controller
{
    public function registrarSubtramite(Request $request)
    {
        if ($request->nombreTramite != ' ') {
            echo 'asdasd';
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

    public function autocomplete(Request $request)
    {
        $data = DB::table('tramite')->select("nombre as name")->where("nombre", "LIKE", "%{$request->input('query')}%")->get();

        return response()->json($data);
    }

    public function cargarSubtramite($codTramite)
    {
        $subtramite = new subtramitemodel();
        $sub = $subtramite->consultarSubtramiteid($codTramite);
        return view('Administrador/Subtramite/Edit')->with(['subtramite' => $sub]);
    }

    public function editarSubtramite($codSubtramite, Request $request)
    {
        $subtramite = new subtramitemodel();
        $subtramite->setCuenta($request->cuentaContable);
        $subtramite->setNombre($request->nombreSubtramite);
        $subtramite->setPrecio($request->precio);
        $subtramite->editarSubtramite($codSubtramite);

        return view('Administrador/Subtramite/Search')->with(['nombre' => $request->nombreSubtramite]);
    }

    public function listarSubtramite(Request $request)
    {
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
                }
            }
        }
        return view('Administrador/Subtramite/Search')->with(['subtramite' => $sub, 'txt' => $request->text, 'select' => $request->select]);
    }

    public function eliminarSubtramite($codSubtramite, Request $request)
    {
        $subtramite = new subtramitemodel();
        $subtramite->eliminarSubtramite($codSubtramite);
        return view('Administrador/Subtramite/Search')->with(['nombre' => $request->nombre]);
    }
}
