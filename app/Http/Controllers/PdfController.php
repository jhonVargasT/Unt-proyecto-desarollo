<?php

namespace App\Http\Controllers;

use App\pagomodel;

class PdfController extends Controller
{
    public function PagosBoletaAlumno($codPago,$val)
    {
        $total = 0;
        $pag = null;
        $pago = new pagomodel();

        $pag = $pago->consultarCodigoPagoReporte($codPago,$val);

        foreach ($pag as $p) {
            $total = $total + $p->precio;
        }

        view()->share(['pago' => $pag, 'total' => $total]);

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('Ventanilla/Pagos/reporte');
        return $pdf->stream('pagoAlumno.pdf');

    }
}
