<?php

namespace App\Http\Controllers;

use App\pagomodel;
use Illuminate\Http\Request;

class pagoController extends Controller
{
    public function registrarPago(Request $request)
    {
        $pago = new pagomodel();
        $pago->setLugar($request->lugar);
        $pago->setDetalle($request->detalle);
        $pago->setFechaDevolucion($request->fechaDevolucion);
        $idpd = $pago->bdPersona('dni');
        $pago->setIdPersona($idpd);
        $idna = $pago->bdPersonaxNombre('nombre','apellidos');
        $pago->setIdPersona($idna);
        $pag = $pago->save();

        if($pag!=null) {
            return view('pago');
        }
        else{
            return view('pago');
        }
    }
}
