<?php

namespace App\Http\Controllers;

use App\pagomodel;
use Illuminate\Support\Facades\Session;

class PdfController extends Controller
{
    public function PagosBoletaAlumno($codPago, $val)
    {
        $total = 0;
        $pag = null;
        $pago = new pagomodel();
        $pag = $pago->consultarCodigoPagoReporte($codPago, $val);
        foreach ($pag as $p) {
            $total = $total + $p->precio;
        }
        view()->share(['pago' => $pag, 'total' => $total]);

        $pdf = app('dompdf.wrapper');

        $pdf->loadView('Ventanilla/Pagos/reporte');
        return $pdf->download('pagoAlumno.pdf');
    }

    public function PagosBoletaAlumnoR($codPago, $val)
    {
        $total = 0;
        $pag = null;
        $pago = new pagomodel();
        $pag = $pago->consultarCodigoPagoReporteR($codPago, $val);
        foreach ($pag as $p) {
            $total = $total + $p->precio;
        }
        view()->share(['pago' => $pag, 'total' => $total]);
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('Reportes/Pagos/reporte');
        return $pdf->download('pagoAlumno.pdf');
    }
}
