<?php

namespace App\Http\Controllers;

use App\pagomodel;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function reportePago($txt, $select, $val)
    {
        Excel::create('Laravel Excel', function ($excel) use ($txt, $select,$val) {
            $excel->sheet('Productos', function ($sheet) use ($txt, $select,$val) {
                $data = null;
                $pag = null;
                $pago = new pagomodel();
                if ($select == 'Dni') {
                    $pag = $pago->consultarAlumnoDNI($txt,$val);
                } else {
                    if ($select == 'Codigo alumno') {
                        $pag = $pago->consultarAlumnoCodigo($txt,$val);
                    } else {
                        if ($select == 'Ruc') {
                            $pag = $pago->consultarClienteRuc($txt,$val);
                        } else {
                            if ($select == 'Codigo pago') {
                                $pag = $pago->consultarCodigoPago($txt,$val);
                            } else {
                                if ($select == 'Codigo personal') {
                                    $pag = $pago->consultarCodigoPersonal($txt);
                                } else {
                                    $pag = $pago->consultarPagos($val);
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
