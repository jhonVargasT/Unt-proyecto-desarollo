<?php

namespace App\Http\Controllers;

use App\pagomodel;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    //PDF, boleta de pago por alumno. Ventanilla
    public function PagosBoletaAlumno($codPago, $val)
    {
        $total = 0;
        $pag = null;
        $pago = new pagomodel();
        $pag = $pago->consultarCodigoPagoReporte($codPago, $val);//SQL, consultar pago por codigo de pago
        foreach ($pag as $p) {
            $total = $total + $p->precio;
        }
        view()->share(['pago' => $pag, 'total' => $total]);

        $pdf = app('dompdf.wrapper');

        $pdf->loadView('Ventanilla/Pagos/reporte');
        return $pdf->download('pagoAlumno.pdf');
    }

    //PDF, boleta de pago por alumno. Reportes
    public function PagosBoletaAlumnoR($codPago)
    {
        $total = 0;
        $pag = null;
        $pago = new pagomodel();
        $pag = $pago->consultarCodigoPagoReporteR($codPago);//SQL, consultar pago por codigo de pago
        foreach ($pag as $p) {
            $total = $total + $p->precio;
        }
        view()->share(['pago' => $pag, 'total' => $total]);
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('Reportes/Pagos/reporte');
        return $pdf->download('pagoAlumno.pdf');
    }

    public function PagosBoletaAlumnoO($codPago)
    {
        $total = 0;
        $pag = null;
        $pago = new pagomodel();
        $pag = $pago->consultarCodigoPagoReporteR($codPago);//SQL, consultar pago por codigo de pago
        foreach ($pag as $p) {
            $total = $total + $p->precio;
        }
        view()->share(['pago' => $pag, 'total' => $total]);
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('Ventanilla/Pagos/reporte');
        return $pdf->download('pagoAlumno.pdf');
    }

    public function BoletaVirtual($codPago)
    {
        $pag = null;
        $pago = new pagomodel();
        $pag = $pago->consultarCodigoPagoReporteR($codPago);//SQL, consultar pago por codigo de pago

        view()->share(['pago' => $pag]);
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('BoletaVirtual/boletavirtual');
        return $pdf->download('pagoAlumno.pdf');
    }
}
