<?php

namespace App\Http\Controllers;

use App\pagomodel;

class PdfController extends Controller
{
    public function pdf($txt, $select)
    {
        $total = 0;
        $pag = null;
        $pago = new pagomodel();

        if ($select == 'Dni') {
            $pag = $pago->consultarAlumnoDNI($txt);
        } else {
            if ($select == 'Codigo alumno') {
                $pag = $pago->consultarAlumnoCodigo($txt);
            } else {
                if ($select == 'Ruc') {
                    $pag = $pago->consultarClienteRuc($txt);
                } else {
                    if ($select == 'Codigo pago') {
                        $pag = $pago->consultarCodigoPago($txt);
                    } else {
                        if ($select == 'Codigo personal') {
                            $pag = $pago->consultarCodigoPersonal($txt);
                        }
                    }
                }
            }
        }

        foreach ($pag as $p) {
            $total = $total + $p->pago;
        }

        view()->share(['pago' => $pag, 'total' => $total]);

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('Ventanilla/Pagos/reporte');
        return $pdf->stream('documento.pdf');

    }
}
