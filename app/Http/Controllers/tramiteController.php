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

        if($tram==true) {
            return view('Administrador/Tramite/add');
        }
        else{
            return view('Administrador/Tramite/add');
        }

    }

}
