<?php

namespace App\Http\Controllers;

use App\pagomodel;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function reportePago($txt, $select)
    {
        Excel::create('Laravel Excel', function ($excel) use ($txt, $select) {
            $excel->sheet('Productos', function ($sheet) use ($txt, $select) {
                $data = null;
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
                                } else {
                                    $pag = $pago->consultarPagos();
                                }
                            }
                        }
                    }
                }
                foreach ($pag as $p) {
                    $data[] = array(
                        "Codigo Pago" => $p->codPago,
                        "Dni" => $p->p1dni,
                        "Nombres" => $p->p1nombres,
                        "Apellidos" => $p->p1apellidos,
                        "Subtramite" => $p->nombre,
                        "Fecha de Pago" => $p->pfecha,
                        "Monto" => $p->precio,
                        "Modalidad" => $p->modalidad,
                        "Detalle" => $p->detalle,
                        "Cajero Nombres" => $p->pnombres,
                        "Cajero Apellidos" => $p->papellidos,
                    );
                }
                $sheet->FromArray($data);
            });
        })->export('xls');
    }
}
