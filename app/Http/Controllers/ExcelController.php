<?php

namespace App\Http\Controllers;

use App\escuelamodel;
use App\facultadmodel;
use App\pagomodel;
use App\personamodel;
use App\sedemodel;
use App\subtramitemodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function reportePago($txt, $select, $val)
    {
        Excel::create('Laravel Excel', function ($excel) use ($txt, $select, $val) {
            $excel->sheet('Productos', function ($sheet) use ($txt, $select, $val) {
                $data = null;
                $pag = null;
                $pago = new pagomodel();
                if ($select == 'Dni') {
                    $pag = $pago->consultarAlumnoDNI($txt, $val);
                } else {
                    if ($select == 'Codigo alumno') {
                        $pag = $pago->consultarAlumnoCodigo($txt, $val);
                    } else {
                        if ($select == 'Ruc') {
                            $pag = $pago->consultarClienteRuc($txt, $val);
                        } else {
                            if ($select == 'Codigo pago') {
                                $pag = $pago->consultarCodigoPago($txt, $val);
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

    public function importExcel(Request $request)
    {
        $val = null;
        $contaux = null;
        $persona = new personamodel();
        $subtramite = new subtramitemodel();
        $pago = new pagomodel();
        if ($request->hasFile('import_file')) {
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function ($reader) {
            })->get();
            if (!empty($data) && $data->count()) {
                foreach ($data->toArray() as $key => $value) {
                    if (!empty($value)) {
                        foreach ($value as $v) {
                            $codPer = $persona->obtnerIdDni($v['dni']);
                            $codSubt = $subtramite->consultarId($v['tasa']);
                            $cont = $this->contadorSubtramite($v['tasa']);
                            $contaux = $cont + 1;
                            $pago->setDetalle($v['detalle']);
                            $date = implode("-", array_reverse(explode("/", $v['fecha'])));
                            $pago->setFecha($date);
                            $pago->setModalidad('Banco');
                            $pago->setIdPersona($codPer);
                            $pago->setIdSubtramite($codSubt);
                            $val = $pago->saveExcel($contaux);
                        }
                        if ($val == true) {
                            return back()->with('true', 'Guardada con exito')->withInput();
                        } else {
                            return back()->with('false', 'No guardada');
                        }
                    }
                }
            }
        }
        return back()->with('error', 'Please Check your file, Something is wrong there.');
    }

    public function reportepagodetalle($estado, $modalidad, $opctram, $valtram, $sede, $facultad, $escuela, $tipre, $fuefi, $fechades, $fechahas)
    {
        date_default_timezone_set('America/Lima');
        $fechahoy = date('Y-m-d');
        Excel::create('Reporte detallado :  ' . $fechahoy . '', function ($excel) use ($estado, $modalidad, $opctram, $valtram, $sede, $facultad, $escuela, $tipre, $fuefi, $fechades, $fechahas) {
            $excel->sheet('resumen', function ($sheet) use ($estado, $modalidad, $opctram, $valtram, $sede, $facultad, $escuela, $tipre, $fuefi, $fechades, $fechahas) {

                $sede = new sedemodel();
                $fac = new facultadmodel();
                $esc = new escuelamodel();
                $subTramiteModel = new subtramitemodel();
                $pagoModel = new pagomodel();
                $tramiteModel = new  tramitemodel();
                $fechaDesde = date("Y-m-d H:i:s", strtotime($fechades));
                $fechaHasta = date("Y-m-d H:i:s", strtotime($fechahas));
                $total = 0;
                $lugar = null;
                $codigo = null;
                if (empty($sede) != true) {
                    if (empty($facultad) != true) {
                        if (empty($escuela) != true) {

                            $codigo = $esc->obtenerId($escuela);
                            $lugar = 'es.idEscuela';
                        } else {
                            $codigo = $fac->obtenerId($facultad);
                            $lugar = 'fac.idFacultad';
                        }
                    } else {
                        $codigo = $sede->obtenerId($sede);
                        $lugar = 'se.codSede';
                    }
                } else {
                    $lugar = null;
                }

                if ($estado == 'Anulado') {
                    $estado = 0;
                } else {
                    $estado = 1;
                }
                if ($opctram == 'Tramite') {
                    $tramites = $tramiteModel->consultarId($valtram);
                    $tram = 'tr.codTramite';
                } else {
                    if ($opctram == 'SubTramite') {
                        $tramites = $subTramiteModel->consultarId($valtram);
                        $tram = 'st.codSubtramite';
                    } else {
                        $tramites = null;
                        $tram = 'Todo';
                    }
                }
                if (empty($fuefi) != true) {
                    $fuenfin = $fuefi;
                } else {
                    $fuenfin = null;
                }
                if (empty($tipre) != true) {
                    $tipRe = $tipre;
                } else {
                    $tipRe = null;
                }

                $result = $pagoModel->listarGeneral($estado, $modalidad, $fechaDesde, $fechaHasta, $tram, $tramites, $tipRe, $fuenfin, $lugar, $codigo);
                if (!is_null($result) && empty($result) != true) {
                    foreach ($result as $sum) {
                        $total = $total + $sum->precio;
                    }
                } else {
                    $total = 0;
                }

                foreach ($result as $p) {
                    $data[] = array(
                        "CLASIFICADOR S.I.A.F" => $p->clasificadorsiaf,
                        "NOMBRE DE TRAMITE" => $p->nombreTramite,
                        "CUENTA" => $p->cuenta,
                        "NOMBRE DE SUBTRAMITE" => $p->nombresubtramite,
                        "IMPORTE" => $p->precio,
                        "NRO PAGOS" => $p->nurPagos,
                    );
                }

                $sheet->FromArray($data);


            });
        })->export('xls');
    }

    function reportePagoresu($tipo, $fecha, $valor)
    {
        date_default_timezone_set('America/Lima');
        $fechahoy = date('Y-m-d');
        Excel::create('Reporte resumido  :  ' . $fechahoy . '', function ($excel) use ($tipo, $fecha, $valor,$fechahoy) {
            $excel->sheet('resumen', function ($sheet) use ($tipo, $fecha, $valor,$fechahoy) {
                $pagoModel = new pagomodel();

                if ($tipo == 'Resumen total') {
                    $data = null;
                    $tiempo = null;
                    if ($fecha == 'Año') {
                        $tiempo = 'where Year(po.fecha) = ' . $valor . '';
                        $result = $pagoModel->listarpagosresumen($tiempo);
                    } elseif ($fecha == 'Mes') {
                        $tiempo = 'where MONTH(po.fecha) = ' . $valor . ' and Year(po.fecha)=(select Year (NOW()))';
                        $result = $pagoModel->listarpagosresumen($tiempo);
                        $meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
                        $valor=$meses[$valor-1];
                    } elseif ($fecha == 'Dia') {
                        $tiempo = 'where DAY(po.fecha) =' . $valor . ' and Month(po.fecha)=(select MONTH (NOW()))';
                        $result = $pagoModel->listarpagosresumen($tiempo);
                    }
                    $total = 0;
                    $cont=0;
                    foreach ($result as $r) {

                        $total += $r->importe;
                    }

                    foreach ($result as $p) {
                        $cont++;
                        $data[] = array(
                            "CLASIFICADOR S.I.A.F" => $p->clasificadorsiaf,
                            "NOMBRE DE TRAMITE" => $p->nombreTramite,
                            "IMPORTE" => $p->importe,
                        );
                    }

                    $var='CAPTACION DE INGRESOS DEL '.strtoupper($fecha).' - '.$valor;
                    //************************Cabeza de hoja
                    //titulo
                    $sheet->mergeCells('B1:D1');

                    $sheet->cell('B1', function($cell) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12',
                            'bold' => true
                        ));
                        $cell->setValue('UNIVERSIDAD NACIONAL DE TRUJILLO');
                        $cell->setAlignment('center');
                    });
                    $sheet->mergeCells('B2:D2');
                    $sheet->cell('B2', function($cell) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12',
                            'bold' => false
                        ));
                        $cell->setValue('OGSEF- OF.TEC. TESORERIA');
                        $cell->setAlignment('center');
                    });
                    $sheet->mergeCells('B3:D3');

                    $sheet->cell('B3', function($cell) use ($var) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12',
                            'bold' => true
                        ));
                        $cell->setValue($var);
                        $cell->setAlignment('center');
                    });
                    //total
                    $sheet->cell('C'.($cont+5).'', function($cell) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12',
                            'bold' => true
                        ));
                        $cell->setValue('Total de ingresos :');
                        $cell->setAlignment('right');
                    });
                    $sheet->cell('D'.($cont+5).'', function($cell) use($total) {
                        $cell->setValue($total);
                    });
                    $sheet->cells('D'.($cont+5).'', function ($cells) {
                        $cells->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));
                        $cells->setAlignment('center');
                    });

                    //*************************************************
                    //*******************cabecera de tabla
                    $sheet->cells('B4:D4', function ($cells) {
                        $cells->setBackground('#006600');
                        $cells->setFont(array(
                            'family' => 'Arial',
                            'size' => '12',
                            'bold' => true
                        ));
                        $cells->setBorder(array(
                            'top' => array(
                                'style' => 'solid'
                            ),
                        ));
                        $cells->setAlignment('center');
                    });
                    //*****************************************
                    //*******************************cuerpo de tabla
                    //estilos
                    $sheet->cells('B4:B'.($cont+4).'', function ($cells) {
                        $cells->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));
                        $cells->setAlignment('center');
                    });
                    $sheet->cells('D4:D'.($cont+4).'', function ($cells) {
                        $cells->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));
                        $cells->setAlignment('center');
                    });


                    //bordes de la hoja
                    $sheet->setBorder('B4:B'.($cont+3).'');
                    $sheet->setBorder('C4:C'.($cont+3).'');
                    $sheet->setBorder('D4:D'.($cont+3).'');
                    //ubicacion de la data
                    $sheet->fromArray($data, null, 'B4', false);
                    //nombre de hoja
                    $sheet->setTitle('Lista de reportes resumido');
                    //par que la data se ajuste
                    $sheet->setAutoSize(true);

                } elseif ($tipo == 'Codigo S.I.A.F') {
                    $data = null;
                    $var='';
                    $tiempo = null;
                    if ($fecha == 'Año') {
                        $tiempo = 'where Year(po.fecha) = ' . $valor . '';
                        $result = $pagoModel->obtenerPagosresumensiaf($tiempo);

                    } elseif ($fecha == 'Mes') {
                        $tiempo = 'where MONTH(po.fecha) = ' . $valor . ' and Year(po.fecha)=(select Year (NOW()))';
                        $result = $pagoModel->obtenerPagosresumensiaf($tiempo);
                        $meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
                        $valor=$meses[$valor-1];
                    } elseif ($fecha == 'Dia') {
                        $tiempo = 'where DAY(po.fecha) =' . $valor . ' and Month(po.fecha)=(select MONTH (NOW()))';
                        $result = $pagoModel->obtenerPagosresumensiaf($tiempo);
                    }
                    $var='RESUMEN DEL '.strtoupper($fecha).' - '.$valor;
                    $total = 0;
                    $cont = 0;
                    foreach ($result as $r) {
                        $total += $r->precio;
                        $cont++;
                    }


                    foreach ($result as $p) {
                        $data[] = array(

                            "CLASIFICADOR S.I.A.F" => $p->clasificadorsiaf,
                            "NOMBRE DE TASA" => $p->nombreTramite,
                            "CUENTA" => $p->cuenta,
                            "NOMBRE DE SUBTASA" => $p->nombresubtramite,
                            "NRO PAGOS" => $p->nurPagos,
                            "IMPORTE" => $p->precio
                        );

                    }

                    //************************Cabeza de hoja
                    //titulo
                    $sheet->mergeCells('B1:G1');

                    $sheet->cell('B1', function($cell) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12',
                            'bold' => true
                        ));
                        $cell->setValue('UNIVERSIDAD NACIONAL DE TRUJILLO');
                        $cell->setAlignment('center');
                    });
                    $sheet->mergeCells('B2:G2');
                    $sheet->cell('B2', function($cell) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12',
                            'bold' => false
                        ));
                        $cell->setValue('OGSEF- OF.TEC. TESORERIA');
                        $cell->setAlignment('center');
                    });
                    $sheet->mergeCells('B3:G3');
                    $sheet->cell('B3', function($cell) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12',
                            'bold' => true
                        ));
                        $cell->setValue('CAPTACION DE INGRESOS');
                        $cell->setAlignment('center');
                    });
                    $sheet->mergeCells('B4:G4');
                    $sheet->cell('B4', function($cell) use ($var) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12',
                            'bold' => true
                        ));
                        $cell->setValue($var);
                        $cell->setAlignment('center');
                    });

                    //cuerpo
                    $sheet->cell('B5', function($cell) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12',
                            'bold' => true
                        ));
                        $cell->setValue('FECHA DE IMPRESION :');
                        $cell->setAlignment('left');
                    });
                    $sheet->cell('C5', function($cell) use ($fechahoy) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12',
                            'bold' => false
                        ));
                        $cell->setValue($fechahoy);
                        $cell->setAlignment('left');
                    });

                    //total
                    $sheet->cell('F5', function($cell) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12',
                            'bold' => true
                        ));
                        $cell->setValue('TOTAL INGRESOS :');
                        $cell->setAlignment('right');
                    });
                    $sheet->cells('G5', function ($cells) {
                        $cells->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));
                        $cells->setAlignment('center');
                    });
                    $sheet->cell('G5', function($cell) use($total) {
                        $cell->setValue($total);
                    });

                    //*************************************************
                    //*******************cabecera de tabla
                    $sheet->cells('B6:G6', function ($cells) {
                        $cells->setBackground('#006600');
                        $cells->setFont(array(
                            'family' => 'Arial',
                            'size' => '12',
                            'bold' => true
                        ));
                        $cells->setBorder(array(
                            'top' => array(
                                'style' => 'solid'
                            ),
                        ));
                        $cells->setAlignment('center');
                    });
                    //*****************************************
                    //*******************************uerpo de tabla
                    //estilos
                    $sheet->cells('B6:B'.($cont+6).'', function ($cells) {
                        $cells->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));
                        $cells->setAlignment('center');
                    });
                    $sheet->cells('D6:D'.($cont+6).'', function ($cells) {
                        $cells->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));
                        $cells->setAlignment('center');
                    });
                    $sheet->cells('F6:F'.($cont+6).'', function ($cells) {
                        $cells->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));
                        $cells->setAlignment('center');
                    });
                    $sheet->cells('G6:G'.($cont+6).'', function ($cells) {
                        $cells->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));
                        $cells->setAlignment('center');
                    });
                    //bordes de la hoja
                    $sheet->setBorder('B6:B'.($cont+6).'');
                    $sheet->setBorder('C6:C'.($cont+6).'');
                    $sheet->setBorder('D6:D'.($cont+6).'');
                    $sheet->setBorder('E6:E'.($cont+6).'');
                    $sheet->setBorder('F6:F'.($cont+6).'');
                    $sheet->setBorder('G6:G'.($cont+6).'');
                    //ubicacion de la data
                    $sheet->fromArray($data, null, 'B6', false);
                    //nombre de hoja
                    $sheet->setTitle('Lista de reportes');
                    //par que la data se ajuste
                    $sheet->setAutoSize(true);

                }


            });
        })->export('xls');
    }


    function contadorSubtramite($nombreSubtramite)
    {
        $cont = null;
        $contador = DB::select('select contador from subtramite where subtramite.estado=1 and subtramite.nombre="' . $nombreSubtramite . '"');

        foreach ($contador as $c) {
            $cont = $c->contador;
        }
        return $cont;
    }

}