<?php

namespace App\Http\Controllers;

use App\facultadmodel;
use App\tramitemodel;
use Illuminate\Http\Request;

class tramiteController extends Controller
{
    public function registrarTramite(Request $request)
    {
        $tramite = new tramitemodel();
        $tramite->setClasificador($request->clasificador);
        $tramite->setNombre($request->nombre);
        $tramite->setFuentefinanc($request->fuentefinanc);
        $tramite->setTipoRecurso($request->tipoRecurso);
        $tram = $tramite->save();

        if ($tram == true) {
            return view('Administrador/Tramite/add');
        } else {
            return view('Administrador/Tramite/add');
        }
    }

    public function cargarTramite($codTramite)
    {
        $tramite = new tramitemodel();
        $tra = $tramite->consultarTramiteid($codTramite);
        return view('Administrador/Tramite/Edit')->with(['tramite' => $tra]);
    }

    public function editarTramite($codTramite, Request $request)
    {
        $tramite = new tramitemodel();
        $tramite->setClasificador($request->clasificadorSiaf);
        $tramite->setNombre($request->nombreTramite);
        $tramite->setFuentefinanc($request->fuenteFinaciamiento);
        $tramite->setTipoRecurso($request->tipoDeRecurso);
        $tramite->editarTramite($codTramite);
        return view('Administrador/Tramite/Search')->with(['nombre' => $request->nombreTramite]);
    }

    public function listarTramite(Request $request)
    {
        $tra = null;
        $tramite = new tramitemodel();

        if ($request->select == 'Clasificador Siaf') {
            $tra = $tramite->consultarTramiteCS($request->text);
        } else {
            if ($request->select == 'Tipo de recurso') {
                $tra = $tramite->consultarTramiteTR($request->text);
            } else {
                if ($request->select == 'Nombre de tramite') {
                    $tra = $tramite->consultarTramiteN($request->text);
                } else {
                    if ($request->select == 'Fuente de financiamiento') {
                        $tra = $tramite->consultarTramiteFF($request->text);
                    }
                }
            }
        }
        return view('Administrador/Tramite/Search')->with(['tramite' => $tra, 'txt' => $request->text, 'select' => $request->select]);
    }

}
