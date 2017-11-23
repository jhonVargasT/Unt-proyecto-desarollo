<?php

namespace App\Http\Controllers;

use App\donacionmodel;
use App\escuelamodel;
use App\facultadmodel;
use App\pagomodel;
use App\personamodel;
use App\sedemodel;
use App\subtramitemodel;
use App\tramitemodel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\alumnomodel;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class ExcelController extends Controller
{
    //Reporte excel de donaciones y transferencia
    public function donacionExcel($fecha, $numero)
    {
        date_default_timezone_set('America/Lima');
        $fechahoy = date('Y-m-d');
        Excel::create('Reporte donacion' . $fechahoy . '', function ($excel) use ($fecha, $numero) {
            $excel->sheet('Productos', function ($sheet) use ($fecha, $numero) {
                $data = null;
                $total = 0;
                $cont = 0;
                $pag = null;
                $donacion = new donacionmodel();
                $result = $donacion->consultarDonaciones($fecha);//SQL, buscar donaiones y transacciones por fecha
                foreach ($result as $p) {
                    $total += $p->importe;
                }

                foreach ($result as $d) {
                    $cont++;
                    $data[] = array(
                        "Numero Resolucion" => $d->numResolucion,
                        "Banco" => $d->banco, "N° cuenta" => $d->cuenta,
                        "Clasificador" => $d->nombre
                    , "Fecha de ingreso" => $d->fechaIngreso
                    , "Descripcion" => $d->descripcion,
                        "Importe" => $d->importe,

                    );
                }
                $sheet->protect('admin');
                //$sheet->FromArray($data);
                $sheet->mergeCells('B1:H1');
                $var = 'RESUMEN  ' . $numero;
                $sheet->cell('B1', function ($cell) {
                    $cell->setFont(array(
                        'family' => 'Arial',
                        'size' => '12',
                        'bold' => true
                    ));
                    $cell->setValue('UNIVERSIDAD NACIONAL DE TRUJILLO');
                    $cell->setAlignment('center');
                });
                $sheet->mergeCells('B2:H2');
                $sheet->cell('B2', function ($cell) {
                    $cell->setFont(array(
                        'family' => 'Arial',
                        'size' => '12',
                        'bold' => false
                    ));
                    $cell->setValue('OGSEF- OF.TEC. TESORERIA');
                    $cell->setAlignment('center');
                });
                $sheet->mergeCells('B3:H3');

                $sheet->cell('B3', function ($cell) {
                    $cell->setFont(array(
                        'family' => 'Arial',
                        'size' => '12',
                        'bold' => true
                    ));
                    $cell->setValue('Reporte de donaciones y transefrencias');
                    $cell->setAlignment('center');
                });
                $sheet->mergeCells('B4:H4');

                $sheet->cell('B4', function ($cell) use ($var) {
                    $cell->setFont(array(
                        'family' => 'Arial',
                        'size' => '12',
                        'bold' => true
                    ));
                    $cell->setValue($var);
                    $cell->setAlignment('center');
                });
                //total
                $sheet->cell('G6', function ($cell) {
                    $cell->setFont(array(
                        'family' => 'Arial',
                        'size' => '12',
                        'bold' => true
                    ));
                    $cell->setValue('Total de ingresos :');
                    $cell->setAlignment('right');
                });
                $sheet->cell('H6', function ($cell) use ($total) {
                    $cell->setFont(array(
                        'family' => 'Arial',
                        'size' => 12,
                        'AutoSize' => true
                    ));
                    $cell->setValue($total);
                });
                $sheet->cells('H6', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '12'
                    ));
                    $cells->setAlignment('center');
                });

                //*************************************************
                //*******************cabecera de tabla
                $sheet->cells('B7:H7', function ($cells) {
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
                $sheet->cells('B7:B' . ($cont + 7) . '', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '12'
                    ));
                    $cells->setAlignment('left');
                });
                $sheet->cells('F7:F' . ($cont + 7) . '', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '12'
                    ));
                    $cells->setAlignment('center');
                });
                $sheet->cells('G7:G' . ($cont + 7) . '', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '12'
                    ));
                    $cells->setAlignment('center');
                });
                $sheet->cells('H7:H' . ($cont + 7) . '', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '12'
                    ));
                    $cells->setAlignment('center');
                });


                /*$sheet->cells('M7:M' . ($cont + 7) . '', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '12'
                    ));
                    $cells->setAlignment('center');
                });*/
                //bordes de la hoja
                $sheet->setBorder('B7:B' . ($cont + 7) . '');
                $sheet->setBorder('C7:C' . ($cont + 7) . '');
                $sheet->setBorder('D7:D' . ($cont + 7) . '');
                $sheet->setBorder('E7:E' . ($cont + 7) . '');
                $sheet->setBorder('F7:F' . ($cont + 7) . '');
                $sheet->setBorder('G7:G' . ($cont + 7) . '');
                $sheet->setBorder('H7:H' . ($cont + 7) . '');
                //ubicacion de la data
                $sheet->fromArray($data, null, 'B7', false);
                //nombre de hoja
                $sheet->setTitle('dona y trans fresumido');
                //par que la data se ajuste
                $sheet->setAutoSize(true);
            });
        })->export('xls');
    }

    //Reporte total de los pagos por dni o codigo alumno, ruc o todos
    public function reportePago($txt, $select, $val)
    {
        Excel::create('Reporte', function ($excel) use ($txt, $select, $val) {
            $excel->sheet('Productos', function ($sheet) use ($txt, $select, $val) {
                $data = null;
                $total = 0;
                $cont = 0;
                $pag = null;
                $pago = new pagomodel();
                $sheet->protect('admin');
                if ($select == 'Dni') {
                    $pag = $pago->consultarAlumnoDNI($txt, $val);//SQL, buscar alumnos por su dni
                } else {
                    if ($select == 'Codigo alumno') {
                        $pag = $pago->consultarAlumnoCodigo($txt, $val);//SQL, buscar alumnos por su codigo
                    } else {
                        if ($select == 'Ruc') {
                            $pag = $pago->consultarClienteRuc($txt, $val);//SQL, buscar clientes por su ruc
                        } else {
                            if ($select == 'Codigo pago') {
                                $pag = $pago->consultarCodigoPago($txt, $val);//SQL, buscar pagos realizados por su codigo de pago
                            } else {
                                if ($select == 'Todo') {
                                    $pag = $pago->consultarPagos($val);//SQL, buscar todos los pagos
                                }
                            }
                        }
                    }
                }
                foreach ($pag as $p) {
                    $total += $p->precio;
                }
                foreach ($pag as $p) {
                    $cont++;
                    $data[] = array(
                        "Codigo Pago" => $p->codPago,
                        "Dni" => $p->p1dni,
                        "Nombres" => $p->p1nombres,
                        "Apellidos" => $p->p1apellidos,
                        "Tasa" => $p->nombre,
                        "Fecha de Pago" => $p->pfecha,
                        "Monto" => $p->precio,
                        "Modalidad" => $p->modalidad,
                        "Detalle" => $p->detalle,
                        "Cajero Nombres" => $p->pnombres,
                        "Cajero Apellidos" => $p->papellidos,
                    );
                }
                //$sheet->FromArray($data);
                $sheet->mergeCells('B1:L1');

                $sheet->cell('B1', function ($cell) {
                    $cell->setFont(array(
                        'family' => 'Arial',
                        'size' => '12',
                        'bold' => true
                    ));
                    $cell->setValue('UNIVERSIDAD NACIONAL DE TRUJILLO');
                    $cell->setAlignment('center');
                });
                $sheet->mergeCells('B2:L2');
                $sheet->cell('B2', function ($cell) {
                    $cell->setFont(array(
                        'family' => 'Arial',
                        'size' => '12',
                        'bold' => false
                    ));
                    $cell->setValue('OGSEF- OF.TEC. TESORERIA');
                    $cell->setAlignment('center');
                });
                $sheet->mergeCells('B3:L3');

                $sheet->cell('B3', function ($cell) {
                    $cell->setFont(array(
                        'family' => 'Arial',
                        'size' => '12',
                        'bold' => true
                    ));
                    $cell->setValue('Reporte de Pagos de Alumnos');
                    $cell->setAlignment('center');
                });
                //total
                $sheet->cell('K6', function ($cell) {
                    $cell->setFont(array(
                        'family' => 'Arial',
                        'size' => '12',
                        'bold' => true
                    ));
                    $cell->setValue('Total de ingresos :');
                    $cell->setAlignment('right');
                });
                $sheet->cell('L6', function ($cell) use ($total) {
                    $cell->setValue($total);
                });
                $sheet->cells('L6', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '12'
                    ));
                    $cells->setAlignment('center');
                });

                //*************************************************
                //*******************cabecera de tabla
                $sheet->cells('B7:L7', function ($cells) {
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
                $sheet->cells('B7:B' . ($cont + 7) . '', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '12'
                    ));
                    $cells->setAlignment('center');
                });

                $sheet->cells('G7:G' . ($cont + 7) . '', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '12'
                    ));
                    $cells->setAlignment('center');
                });
                $sheet->cells('H7:H' . ($cont + 7) . '', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '12'
                    ));
                    $cells->setAlignment('center');
                });
                $sheet->cells('I7:I' . ($cont + 7) . '', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '12'
                    ));
                    $cells->setAlignment('center');
                });
                $sheet->cells('J7:J' . ($cont + 7) . '', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '12'
                    ));
                    $cells->setAlignment('center');
                });
                $sheet->cells('L7:L' . ($cont + 7) . '', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '12'
                    ));
                    $cells->setAlignment('center');
                });
                /*$sheet->cells('M7:M' . ($cont + 7) . '', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '12'
                    ));
                    $cells->setAlignment('center');
                });*/
                //bordes de la hoja
                $sheet->setBorder('B7:B' . ($cont + 7) . '');
                $sheet->setBorder('C7:C' . ($cont + 7) . '');
                $sheet->setBorder('D7:D' . ($cont + 7) . '');
                $sheet->setBorder('E7:E' . ($cont + 7) . '');
                $sheet->setBorder('F7:F' . ($cont + 7) . '');
                $sheet->setBorder('G7:G' . ($cont + 7) . '');
                $sheet->setBorder('H7:H' . ($cont + 7) . '');
                $sheet->setBorder('I7:I' . ($cont + 7) . '');
                $sheet->setBorder('J7:J' . ($cont + 7) . '');
                $sheet->setBorder('K7:K' . ($cont + 7) . '');
                $sheet->setBorder('L7:L' . ($cont + 7) . '');
                //ubicacion de la data
                $sheet->fromArray($data, null, 'B7', false);
                //nombre de hoja
                $sheet->setTitle('Lista de reportes resumido');
                //par que la data se ajuste
                $sheet->setAutoSize(true);
            });
        })->export('xls');
    }

    //Importar pagos realizados por el banco, TXT
    public function importTxtBanco(Request $request)
    {
        $data = array();
        $fp = null;
        $val = null;
        $contaux = null;
        $persona = new personamodel();
        $pago = new pagomodel();
        $bool = false;
        if ($request->hasFile('import_file')) {
            $path = Input::file('import_file')->getRealPath();
            $codPer = null;
            $CBANCO = array();
            $NCREDITO = array();
            $NCUOTA = array();
            $FVNCMTO = array();
            $FPAGO = array();
            $FVALOR = array();
            $CAGENCIA = array();
            $CCAJERO = array();
            $CMONEDA = array();
            $SIMPORTE = array();
            $ACLIENTE = array();
            $GTASA = array();
            $FACTORMORA = array();
            $FACTORCOMP = array();
            $SINTERMORA = array();
            $SINTERCOMP = array();
            $SGASTOSCOB = array();
            $SPAGADO = array();
            $FILLER = array();
            $lines = array();

            $fp = fopen($path, 'r');

            while (!feof($fp)) {
                $line = fgets($fp);
                $line = trim($line);
                $lines[] = $line;
            }

            for ($i = 0; $i < sizeof($lines); $i++) {
                $CBANCO[$i] = substr($lines[$i], 0, 8);
                $NCREDITO[$i] = substr($lines[$i], 8, 1);
                $NCUOTA[$i] = substr($lines[$i], 9, 7);
                $FVNCMTO[$i] = substr($lines[$i], 20, 8);
                $FPAGO[$i] = substr($lines[$i], 28, 8);
                $FVALOR[$i] = substr($lines[$i], 36, 8);
                $CAGENCIA[$i] = substr($lines[$i], 44, 8);
                $CCAJERO[$i] = substr($lines[$i], 52, 4);
                $CMONEDA[$i] = substr($lines[$i], 56, 3);
                $SIMPORTE[$i] = substr($lines[$i], 59, 15);
                $ACLIENTE[$i] = substr($lines[$i], 74, 30);
                $GTASA[$i] = substr($lines[$i], 104, 1);
                $FACTORMORA[$i] = substr($lines[$i], 105, 15);
                $FACTORCOMP[$i] = substr($lines[$i], 120, 15);
                $SINTERMORA[$i] = substr($lines[$i], 135, 15);
                $SINTERCOMP[$i] = substr($lines[$i], 150, 15);
                $SGASTOSCOB[$i] = substr($lines[$i], 165, 15);
                $SPAGADO[$i] = substr($lines[$i], 180, 15);
                $FILLER[$i] = substr($lines[$i], 195, 105);
            }

            for ($c = 0; $c < sizeof($lines); $c++) {
                $codPer = $persona->obtnerIdDni($CBANCO[$c]);
                $pago->setIdSubtramite($NCREDITO[$c]);
                $cont = $this->contadorSubtramite($NCREDITO[$c]);
                $contaux = $cont + 1;
                $pago->setDetalle($NCUOTA[$c]);
                $date = implode("-", array_reverse(explode("/", '05/05/2017 16:58:10')));
                $pago->setFecha($date);
                $pago->setModalidad('Banco');
                $pago->setIdPersona($codPer);
                $b = $pago->saveExcel($contaux);
                if ($b == false) {
                    $data[] = array(
                        "Codigo Pago" => $FVNCMTO[$c],
                        "Dni" => $CBANCO[$c],
                        "Tasa" => $NCREDITO[$c],
                        "Fecha de Pago" => $date,
                        "Modalidad" => 'Banco',
                        "Detalle" => $NCUOTA[$c],
                    );
                }
                if ($c == sizeof($lines) - 1) {
                    $bool = true;
                }
            }
            if ($bool == true) {
                fclose($fp);
                if ($data != null) {
                    $this->reporteNoPagado($data);

                }
            }
        }
        return back()->with('true', 'Guardada con exito')->withInput();
    }

    public function reporteNoPagado($data)
    {
        Excel::create('Reporte', function ($excel) use ($data) {
            $excel->sheet('Alumnos', function ($sheet) use ($data) {
                $sheet->protect('admin');
                $sheet->mergeCells('B1:F1');

                $sheet->cell('B1', function ($cell) {
                    $cell->setFont(array(
                        'family' => 'Arial',
                        'size' => '12',
                        'bold' => true
                    ));
                    $cell->setValue('UNIVERSIDAD NACIONAL DE TRUJILLO');
                    $cell->setAlignment('center');
                });
                $sheet->mergeCells('B2:F2');
                $sheet->cell('B2', function ($cell) {
                    $cell->setFont(array(
                        'family' => 'Arial',
                        'size' => '12',
                        'bold' => false
                    ));
                    $cell->setValue('OGSEF- OF.TEC. TESORERIA');
                    $cell->setAlignment('center');
                });
                $sheet->mergeCells('B3:F3');

                $sheet->cell('B3', function ($cell) {
                    $cell->setFont(array(
                        'family' => 'Arial',
                        'size' => '12',
                        'bold' => true
                    ));
                    $cell->setValue('Reporte de Pagos de Alumnos');
                    $cell->setAlignment('center');
                });

                //*************************************************
                //*******************cabecera de tabla
                $sheet->cells('B7:G7', function ($cells) {
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
                $sheet->cells('B7:B' . (500) . '', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '12'
                    ));
                    $cells->setAlignment('center');
                });

                $sheet->cells('G7:G' . (500) . '', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '12'
                    ));
                    $cells->setAlignment('center');
                });
                $sheet->cells('H7:H' . (500) . '', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '12'
                    ));
                    $cells->setAlignment('center');
                });
                $sheet->cells('I7:I' . (500) . '', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '12'
                    ));
                    $cells->setAlignment('center');
                });
                $sheet->cells('J7:J' . (500) . '', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '12'
                    ));
                    $cells->setAlignment('center');
                });
                $sheet->cells('L7:L' . (500) . '', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '12'
                    ));
                    $cells->setAlignment('center');
                });

                //bordes de la hoja
                $sheet->setBorder('B7:B' . (5) . '');
                $sheet->setBorder('C7:C' . (5) . '');
                $sheet->setBorder('D7:D' . (5) . '');
                $sheet->setBorder('E7:E' . (5) . '');
                $sheet->setBorder('F7:F' . (5) . '');
                $sheet->setBorder('G7:G' . (5) . '');

                //ubicacion de la data
                $sheet->fromArray($data, null, 'B7', false);
                //nombre de hoja
                $sheet->setTitle('Lista pagos de alumnos');
                //par que la data se ajuste
                $sheet->setAutoSize(true);
            });
        })->export('xls');
    }

    public function importExcelAlumno(Request $request)
    {
        $alumno = new alumnomodel();
        if ($request->hasFile('import_file')) {
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function ($reader) {
            })->get();
            if (!empty($data)) {
                foreach ($data as $value) {
                    $coP = null;
                    $coS = null;
                    $coF = null;
                    if (!empty($value)) {
                        try {
                            $coS = DB::table('sede')->select('codSede')->where('nombresede', '' . $value['sede'] . ' ')->count();
                            if ($coS != 0) {
                                $coS = DB::table('sede')->select('codSede')->where('nombresede', '' . $value['sede'] . ' ')->get();
                                foreach ($coS as $co) {
                                    $coS = $co->codSede;
                                }
                                $coF = DB::table('facultad')->select('idFacultad')
                                    ->where([
                                        ['coSede', '=', $coS],
                                        ['nombre', '=', '' . $value['facultad'] . ' '],
                                        ['estado', '=', 1]
                                    ])->count();

                                if ($coF != 0) {
                                    $coF = DB::table('facultad')->select('idFacultad')
                                        ->where([
                                            ['coSede', '=', $coS],
                                            ['nombre', '=', '' . $value['facultad'] . ' '],
                                            ['estado', '=', 1]
                                        ])->get();
                                    foreach ($coF as $co) {
                                        $coF = $co->idFacultad;
                                    }

                                    $coE = DB::table('escuela')->select('idEscuela')->where(
                                        [
                                            ['nombre', '=', $value['escuela']],
                                            ['codigoFacultad', '=', $coF]
                                        ]
                                    )->count();
                                    if ($coE != 0) {
                                        $coE = DB::table('escuela')->select('idEscuela')->where(
                                            [
                                                ['nombre', '=', $value['escuela']],
                                                ['codigoFacultad', '=', $coF]
                                            ]
                                        )->get();
                                        foreach ($coE as $co) {
                                            $coE = $co->idEscuela;
                                        }

                                        $cantAl = 0;
                                        $coP = DB::table('alumno')->select('idAlumno')->where('codAlumno', '=', $value['codigo'])->count();
                                        if ($coP != 0) {
                                            $coP = DB::table('alumno')->select('idAlumno')->where('codAlumno', '=', $value['codigo'])->get();
                                            foreach ($coP as $co) {
                                                $coP = $co->idAlumno;
                                            }
                                            $cantAl = DB::table('alumno')->select('idAlumno')->where('idAlumno', '=', $coP)->count();
                                        }
                                        if ($cantAl == 0) {
                                            $alumno->setTipoAlummno(1);
                                            $alumno->setDni($value['dni']);
                                            $alumno->setNombres($value['nombres']);
                                            $alumno->setApellidos($value['apellidos']);
                                            $alumno->setCodAlumno($value['codigo']);
                                            $alumno->setCorreo($value['correo']);
                                            $alumno->setFecha($value['fecha']);
                                            $alumno->setIdEscuela($coE);
                                            $alumno->saveAlumnoImportar($value['codigo']);
                                        }
                                    }
                                }
                            }
                        } catch (Exception $e) {
                            return back()->with('false', 'No subieron los archivos');
                        }
                    }
                }
                return back()->with('true', 'Se subio el archivo');
            }
            return back()->with('false', 'Por favor, revisar su archivo.');
        }
        return back()->with('false', 'Por favor, revisar su archivo.');
    }

    public function importExcelClasificador(Request $request)
    {
        $tramite = new tramitemodel();
        if ($request->hasFile('import_file')) {
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function ($reader) {
            })->get();
            if (!empty($data) && $data->count()) {
                foreach ($data->toArray() as $key => $value) {
                    if (!empty($value)) {
                        try {
                            foreach ($value as $v) {
                                $tramite->setClasificador($v['clasificador']);;
                                $tramite->setNombre($v['nombre']);
                                $tramite->setTipoRecurso($v['recurso']);
                                $tramite->setFuentefinanc($v['financiamiento']);
                                $tramite->save();
                            }
                        } catch (Exception $e) {
                            return back()->with('false', 'Error, por favor revisar su archivo.');
                        }
                    }
                }
                return back()->with('true', 'Se subio el archivo')->withInput();
            }
        }
        return back()->with('false', 'Por favor, revisar su archivo.');
    }

    public function importExcelTasa(Request $request)
    {
        $subtramite = new subtramitemodel();
        if ($request->hasFile('import_file')) {
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function ($reader) {
            })->get();
            if (!empty($data)) {
                foreach ($data as $value) {
                    if (!empty($value)) {
                        try {
                            $subtramite->setCodigotasa($value['codigo']);
                            $subtramite->setNombre($value['nombre']);
                            $subtramite->setPrecio($value['precio']);
                            $subtramite->setUnidad($value['unidad']);
                            $idTra = $subtramite->bdTramitexClasificador($value['siaf']);
                            $subtramite->setIdTramite($idTra);
                            $subtramite->save();
                        } catch
                        (Exception $e) {
                            return back()->with('false', 'Error, por favor revisar su archivo.');
                        }
                    }
                }
                return back()->with('true', 'Se subio el archivo')->withInput();
            }
        }
        return back()->with('false', 'Por favor, revisar su archivo.');
    }

    public
    function importExcelSede(Request $request)
    {
        $sede = new sedemodel();
        if ($request->hasFile('import_file')) {
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function ($reader) {
            })->get();
            if (!empty($data)) {
                foreach ($data as $value) {
                    $coS = null;
                    if (!empty($value)) {
                        try {
                            $coS = DB::select('select codSede from sede where nombresede =  "' . $value['sede'] . '" and codigosede = "' . $value['codigo'] . '" and direccion = "' . $value['direccion'] . '"');
                            if (empty($coS)) {
                                $sede->setNombreSede($value['sede']);
                                $sede->setCodigoSede($value['codigo']);
                                $sede->setDireccion($value['direccion']);
                                $sede->save();
                            }
                        } catch (Exception $e) {
                            return back()->with('false', 'Error, por favor revisar su archivo.');
                        }
                    }
                }
                return back()->with('true', 'Se subio el archivo')->withInput();
            }
        }
        return back()->with('false', 'Por favor, revisar su archivo.');
    }

    public
    function importExcelFacultad(Request $request)
    {
        $facultad = new facultadmodel();
        if ($request->hasFile('import_file')) {
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function ($reader) {
            })->get();
            if (!empty($data)) {
                foreach ($data as $value) {

                    if (!empty($value)) {
                        try {
                            $coS = null;
                            $coS = DB::table('sede')->select('codSede')->where('nombresede', '' . $value['sede'] . ' ')->count();

                            if ($coS != 0) {
                                $coS = DB::table('sede')->select('codSede')->where('nombresede', '' . $value['sede'] . ' ')->get();

                                foreach ($coS as $co) {
                                    $coS = $co->codSede;
                                }
                                $coF = null;
                                $coF = DB::table('facultad')->select('idFacultad')
                                    ->where([
                                        ['coSede', '=', $coS],
                                        ['nombre', '=', '' . $value['facultad'] . ' '],
                                        ['codFacultad', '=', '' . $value['codigo'] . ''],
                                        ['estado', '=', 1]
                                    ])->count();


                                if ($coF == 0) {
                                    $facultad->setNombre($value['facultad']);
                                    $facultad->setCodFacultad($value['codigo']);
                                    $facultad->setNroCuenta($value['cuenta']);
                                    $facultad->setCodSede($coS);
                                    $facultad->save();
                                }


                            }
                        } catch (Exception $e) {

                            return back()->with('false', 'Error, por favor, revisar su archivo.');
                        }
                    }
                }
                return back()->with('true', 'Se subio el archivo')->withInput();
            }
        }
        return back()->with('false', 'Por favor, revisar su archivo.');
    }

    public
    function importExcelEscuela(Request $request)
    {
        $escuela = new escuelamodel();

        if ($request->hasFile('import_file')) {
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function ($reader) {
            })->get();
            if (!empty($data)) {
                foreach ($data as $value) {
                    $coE = null;
                    if (!empty($value)) {
                        try {
                            $coS = null;
                            $coS = DB::table('sede')->select('codSede')->where('nombresede', '' . $value['sede'] . ' ')->count();
                            if ($coS != 0) {

                                $coS = DB::table('sede')->select('codSede')->where('nombresede', '' . $value['sede'] . ' ')->get();
                                foreach ($coS as $co) {
                                    $coS = $co->codSede;
                                }
                                $coF = null;

                                $coF = DB::table('facultad')->select('idFacultad')
                                    ->where([
                                        ['coSede', '=', $coS],
                                        ['nombre', '=', '' . $value['facultad'] . ' '],
                                        ['estado', '=', 1]
                                    ])->count();
                                if ($coF != 0) {
                                    $coF = DB::table('facultad')->select('idFacultad')
                                        ->where([
                                            ['coSede', '=', $coS],
                                            ['nombre', '=', '' . $value['facultad'] . ' '],
                                            ['estado', '=', 1]
                                        ])->get();
                                    foreach ($coF as $co) {
                                        $coF = $co->idFacultad;
                                    }

                                    $coE = DB::table('escuela')->select('idEscuela')->where(
                                        [['codigoFacultad', '=', $coF],
                                            ['nroCuenta', '=', $value['cuenta']],
                                            ['nombre', '=', $value['escuela']],
                                            ['codEscuela', '=', $value['codigo']]
                                        ]
                                    )->count();


                                    if ($coE == 0) {
                                        $escuela->setNombre($value['escuela']);
                                        $escuela->setCodEscuela($value['codigo']);
                                        $escuela->setNroCuenta($value['cuenta']);
                                        $escuela->setFacultad($coF);
                                        $escuela->saveescuela();
                                    }

                                }


                            }
                        } catch (Exception $e) {

                            return back()->with('false', 'Error, por favor, revisar su archivo.');
                        }


                    }
                }
                return back()->with('true', 'Se subio el archivo')->withInput();
            }
        }
        return back()->with('error', 'Por favor, revisar su archivo.');
    }

    //Jhon, no encuentro donde esta esto
    public
    function reportepagodetalle($estado, $modalidad, $opctram, $valtram, $sede, $facultad, $escuela, $tipre, $fuefi, $fechades, $fechahas)
    {
        date_default_timezone_set('America/Lima');
        $fechahoy = date('Y-m-d');
        Excel::create('Reporte detallado :  ' . $fechahoy . '', function ($excel) use ($estado, $modalidad, $opctram, $valtram, $sede, $facultad, $escuela, $tipre, $fuefi, $fechades, $fechahas) {
            $excel->sheet('resumen', function ($sheet) use ($estado, $modalidad, $opctram, $valtram, $sede, $facultad, $escuela, $tipre, $fuefi, $fechades, $fechahas) {
                $sheet->protect('admin');
                $data = null;
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
                        "NOMBRE DE CLASIFICADOR" => $p->nombreTramite,
                        "CUENTA" => $p->cuenta,
                        "NOMBRE DE TASA" => $p->nombresubtramite,
                        "IMPORTE" => $p->precio,
                        "NRO PAGOS" => $p->nurPagos,
                    );
                }
                $sheet->FromArray($data);
            });
        })->export('xls');
    }

    //Reporte detallado, formato excel
    function reporteDetallado($encriptado)
    {

        list($estado, $modalidad, $fechaDesde, $fechaHasta, $tram, $tramites, $tipRe, $fuenfin, $lugar, $codigo, $centroProducion, $opcBusqueda) = explode(';', $encriptado);
        date_default_timezone_set('America/Lima');
        $fechahoy = date('Y-m-d h:m:s');
        $opcBuscar = explode('|', $opcBusqueda);

        Excel::create('Reporte detallado  :  ' . $fechahoy . '', function ($excel) use ($opcBuscar, $estado, $modalidad, $fechaDesde, $fechaHasta, $tram, $tramites, $tipRe, $fuenfin, $lugar, $codigo, $fechahoy, $centroProducion) {
            $excel->sheet('detalle', function ($sheet) use ($opcBuscar, $estado, $modalidad, $fechaDesde, $fechaHasta, $tram, $tramites, $tipRe, $fuenfin, $lugar, $codigo, $fechahoy, $centroProducion) {
                $pagoModel = new pagomodel();
                $data = null;
                $result = $pagoModel->listarGeneral($estado, $modalidad, $fechaDesde, $fechaHasta, $tram, $tramites, $tipRe, $fuenfin, $lugar, $codigo, $centroProducion);//pago,personal,subtramite,escuela,facultad
                $total = 0;
                $cont = 0;
                $sheet->protect('admin');
                foreach ($result as $r) {

                    $total += $r->precio;
                }

                foreach ($result as $r) {
                    $cont++;
                    $data[] = array(
                        "ID" => $r->codigopago
                    , "MODALIDAD" => $r->modalidad
                    , "SEDE" => $r->nombresede
                    , "FACULTAD" => $r->nombrefacultad
                    , "ESCUELA" => $r->nombreescuela
                    , "CLASIFICADOR S.I.A.F" => $r->clasi
                    , "CLASIFICADOR" => $r->nombretramite
                    , "TASA" => $r->nombresubtramite
                    , "FECHA" => $r->fechapago
                    , "DETALLE" => $r->pagodetalle
                    , "PRECIO" => $r->precio


                    );
                }

                $sheet->mergeCells('B1:l1');

                $sheet->cell('B1', function ($cell) {
                    $cell->setFont(array(
                        'family' => 'Arial',
                        'size' => '14',
                        'bold' => true
                    ));
                    $cell->setValue('UNIVERSIDAD NACIONAL DE TRUJILLO');
                    $cell->setAlignment('center');
                });
                $sheet->mergeCells('B2:l2');
                $sheet->cell('B2', function ($cell) {
                    $cell->setFont(array(
                        'family' => 'Arial',
                        'size' => '14',
                        'bold' => false
                    ));
                    $cell->setValue('OGSEF- OF.TEC. TESORERIA');
                    $cell->setAlignment('center');
                });
                $sheet->mergeCells('B3:l3');

                $sheet->cell('B3', function ($cell) {
                    $cell->setFont(array(
                        'family' => 'Arial',
                        'size' => '14',
                        'bold' => true
                    ));
                    $cell->setValue('Reporte de pagos detallado');
                    $cell->setAlignment('center');
                });
                //datos
                $sheet->mergeCells('B4:C4');

                $sheet->cell('B4', function ($cell) {
                    $cell->setFont(array(
                        'family' => 'Arial',
                        'size' => '14',
                        'bold' => true
                    ));
                    $cell->setValue('Fecha de impresion :');
                    $cell->setAlignment('left');
                });


                $sheet->cell('D4', function ($cell) use ($fechahoy) {
                    $cell->setFont(array(
                        'family' => 'Arial',
                        'size' => '11',

                    ));
                    $cell->setValue($fechahoy);
                    $cell->setAlignment('left');
                });
                $sheet->mergeCells('D5:L5');
                //datos

                $conta = count($opcBuscar);

                $sheet->mergeCells('B5:C5');

                $sheet->cell('B5', function ($cell) {
                    $cell->setFont(array(
                        'family' => 'Arial',
                        'size' => '14',
                        'bold' => true
                    ));
                    $cell->setValue('Opciones seleccionadas :');
                    $cell->setAlignment('left');
                });

                $sheet->cell('D5', function ($cell) use ($opcBuscar, $conta) {
                    $cell->setFont(array(
                        'family' => 'Arial',
                        'size' => '11',

                    ));
                    $dat = null;
                    for ($i = 0; $i < $conta; $i++) {
                        if ($i == 3) {
                            break;
                        } else {
                            if ($i == $conta - 1) {
                                $dat .= ' ' . $opcBuscar[$i] . '.';
                            } else {
                                $dat .= ' ' . $opcBuscar[$i] . ';';
                            }
                        }
                    }
                    $cell->setValue($dat
                    );
                    $cell->setAlignment('left');
                });
                if ($conta > 3) {
                    $sheet->mergeCells('B6:L6');
                    $sheet->cell('B6', function ($cell) use ($opcBuscar, $conta) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '11',

                        ));
                        $dat = null;
                        for ($i = 3; $i < $conta; $i++) {

                            if ($i == $conta - 1) {
                                $dat .= ' ' . $opcBuscar[$i] . '.';
                            } else {
                                $dat .= ' ' . $opcBuscar[$i] . ';';
                            }
                        }
                        $cell->setValue($dat);
                        $cell->setAlignment('left');
                    });
                }
                //total
                $sheet->cell('k7', function ($cell) {
                    $cell->setFont(array(
                        'family' => 'Arial',
                        'size' => '14',
                        'bold' => true
                    ));
                    $cell->setValue('Total de ingresos :');
                    $cell->setAlignment('right');
                });
                $sheet->cell('l7', function ($cell) use ($total) {
                    $cell->setValue($total);
                });
                $sheet->cells('l7', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '14'
                    ));
                    $cells->setAlignment('center');
                });

                //*************************************************
                //*******************cabecera de tabla
                $sheet->cells('B8:l8', function ($cells) {
                    $cells->setBackground('#006600');
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '14',
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
                $sheet->cells('B8:B' . ($cont + 8) . '', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '14'
                    ));
                    $cells->setAlignment('center');
                });

                $sheet->cells('G8:G' . ($cont + 8) . '', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '14'
                    ));
                    $cells->setAlignment('center');
                });
                $sheet->cells('H8:H' . ($cont + 8) . '', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '12'
                    ));
                    $cells->setAlignment('center');
                });
                $sheet->cells('I8:I' . ($cont + 8) . '', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '14'
                    ));
                    $cells->setAlignment('center');
                });
                $sheet->cells('J8:J' . ($cont + 8) . '', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '12'
                    ));
                    $cells->setAlignment('center');
                });
                $sheet->cells('L8:L' . ($cont + 8) . '', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '14'
                    ));
                    $cells->setAlignment('center');
                });

                //bordes de la hoja
                $sheet->setBorder('B8:B' . ($cont + 8) . '');
                $sheet->setBorder('C8:C' . ($cont + 8) . '');
                $sheet->setBorder('D8:D' . ($cont + 8) . '');
                $sheet->setBorder('E8:E' . ($cont + 8) . '');
                $sheet->setBorder('F8:F' . ($cont + 8) . '');
                $sheet->setBorder('G8:G' . ($cont + 8) . '');
                $sheet->setBorder('H8:H' . ($cont + 8) . '');
                $sheet->setBorder('I8:I' . ($cont + 8) . '');
                $sheet->setBorder('J8:J' . ($cont + 8) . '');
                $sheet->setBorder('K8:K' . ($cont + 8) . '');
                $sheet->setBorder('L8:L' . ($cont + 8) . '');
                //Firma
                $sheet->cell('J' . ($cont + 11), function ($cell) {

                    $cell->setFont(array(
                        'family' => 'Arial',
                        'size' => '12',
                        'bold' => true
                    ));
                    $cuenta = Session::get('misession');
                    $cell->setValue('Firma : ' . $cuenta);
                });
                $sheet->cells('J' . ($cont + 11), function ($cells) {

                    $cells->setBorder('thin', null, null, null);
                    $cells->setAlignment('center');
                });
                //ubicacion de la data
                $sheet->fromArray($data, null, 'B8', false);
                //nombre de hoja
                $sheet->setTitle('Lista de reportes resumido');
                //par que la data se ajuste
                $sheet->setAutoSize(true);


            });
        })->export('xls');
    }

//Reporte resumido, formato excel
    function reportePagoresu($tiporep, $varopc, $tiempo, $numero, $unop)
    {


        date_default_timezone_set('America/Lima');
        $fechahoy = date('Y-m-d h:m:s');

        Excel::create('Reporte resumido  :  ' . $fechahoy . '', function ($excel) use ($tiporep, $varopc, $tiempo, $fechahoy, $numero, $unop) {

            $excel->sheet('resumen', function ($sheet) use ($tiporep, $varopc, $tiempo, $fechahoy, $numero, $unop) {
                $sheet->protect('admin');
                $pagoModel = new pagomodel();
                $opiones = 'Tipo reporte : ' . $varopc . '| Tiempo :' . $tiporep . ' ' . $numero;
                if ($unop != 'v') {
                    $opiones .= '| Unidad operativa :' . $unop;
                }
                if ($varopc == 'Resumen total') {
                    $tiporep = strtoupper($tiporep);
                    $result = $pagoModel->listarpagosresumen($tiempo, $unop);
                    $data = null;
                    $total = null;
                    $cont = 0;
                    foreach ($result as $r) {
                        $cont++;
                        $total += $r->importe;
                    }
                    foreach ($result as $p) {
                        $data[] = array(
                            "CLASIFICADOR S.I.A.F" => $p->clasificadorsiaf,
                            "UNIDAD OPERATIVA" => $p->unop,
                            "NOMBRE DE CLASIFICADOR" => $p->nombreTramite,
                            "CANTIDAD" => $p->cantidad,
                            "IMPORTE" => $p->importe
                        );
                    }
                    $var = 'CAPTACION DE INGRESOS DEL ' . $tiporep . ' - ' . $numero;
                    //************************Cabeza de hoja
                    //titulo
                    $sheet->mergeCells('B1:F1');

                    $sheet->cell('B1', function ($cell) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '14',
                            'bold' => true
                        ));
                        $cell->setValue('UNIVERSIDAD NACIONAL DE TRUJILLO');
                        $cell->setAlignment('center');
                    });
                    $sheet->mergeCells('B2:F2');
                    $sheet->cell('B2', function ($cell) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '14',
                            'bold' => false
                        ));
                        $cell->setValue('OGSEF- OF.TEC. TESORERIA');
                        $cell->setAlignment('center');
                    });
                    $sheet->mergeCells('B3:F3');

                    $sheet->cell('B3', function ($cell) use ($var) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '14',
                            'bold' => true
                        ));
                        $cell->setValue($var);
                        $cell->setAlignment('center');
                    });
                    //total
                    $sheet->cell('E' . ($cont + 7) . '', function ($cell) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '14',
                            'bold' => true
                        ));
                        $cell->setValue('Total de ingresos :');
                        $cell->setAlignment('right');
                    });
                    $sheet->cell('F' . ($cont + 7) . '', function ($cell) use ($total) {
                        $cell->setValue($total);
                    });
                    $sheet->cells('F' . ($cont + 7) . '', function ($cells) {
                        $cells->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));
                        $cells->setAlignment('center');
                    });

                    //datos de impresion

                    $sheet->cell('B' . (4) . '', function ($cell) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '14',
                            'bold' => true
                        ));
                        $cell->setValue('Usuario : ');
                        $cell->setAlignment('left');
                    });

                    $sheet->mergeCells('C4:D4');
                    $sheet->cell('C4', function ($cell) use ($total) {

                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));
                        $cuenta = Session::get('misession');
                        $cell->setValue($cuenta);
                        $cell->setAlignment('left');
                    });
                    //fecha de impresion
                    $sheet->cell('E' . (4) . '', function ($cell) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '14',
                            'bold' => true
                        ));
                        $cell->setValue('Fecha de impresion: ');
                        $cell->setAlignment('left');
                    });
                    $sheet->cell('F4', function ($cell) use ($fechahoy) {

                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));

                        $cell->setValue($fechahoy);
                        $cell->setAlignment('left');
                    });
                    //Datos de impresion
                    $sheet->cell('B' . (5) . '', function ($cell) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '14',
                            'bold' => true
                        ));
                        $cell->setValue('Datos de impresion');
                        $cell->setAlignment('left');
                    });

                    $sheet->cell('C4', function ($cell) use ($total) {

                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));
                        $cuenta = Session::get('misession');
                        $cell->setValue($cuenta);
                    });
                    //opciones de busqueda
                    $sheet->mergeCells('C5:f5');
                    $sheet->cell('C5', function ($cell) use ($opiones) {

                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));
                        $cell->setValue($opiones);
                    });

                    //*************************************************
                    //*******************cabecera de tabla
                    $sheet->cells('B6:F6', function ($cells) {
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
                    $sheet->cells('B6:B' . ($cont + 6) . '', function ($cells) {
                        $cells->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));
                        $cells->setAlignment('center');
                    });
                    $sheet->cells('C6:C' . ($cont + 6) . '', function ($cells) {
                        $cells->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));
                        $cells->setAlignment('center');
                    });
                    $sheet->cells('E6:E' . ($cont + 6) . '', function ($cells) {
                        $cells->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));
                        $cells->setAlignment('center');
                    });
                    $sheet->cells('F6:F' . ($cont + 6) . '', function ($cells) {
                        $cells->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));
                        $cells->setAlignment('center');
                    });


                    //bordes de la hoja
                    $sheet->setBorder('B6:B' . ($cont + 6) . '');
                    $sheet->setBorder('C6:C' . ($cont + 6) . '');
                    $sheet->setBorder('D6:D' . ($cont + 6) . '');
                    $sheet->setBorder('E6:E' . ($cont + 6) . '');
                    $sheet->setBorder('F6:F' . ($cont + 6) . '');
                    //Firma
                    $sheet->cell('E' . ($cont + 9), function ($cell) {

                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12',
                            'bold' => true
                        ));
                        $cuenta = Session::get('misession');
                        $cell->setValue('Firma : ' . $cuenta);
                    });

                    $sheet->cells('E' . ($cont + 9), function ($cells) {

                        $cells->setBorder('thin', null, null, null);
                        $cells->setAlignment('center');
                    });

                    //ubicacion de la data
                    $sheet->fromArray($data, null, 'B6', false);
                    //nombre de hoja
                    $sheet->setTitle('Lista de reportes resumido');
                    //par que la data se ajuste
                    $sheet->setAutoSize(true);
                } else {
                    $tiporep = strtoupper($tiporep);
                    $result = $pagoModel->obtenerPagosresumensiaf($tiempo, $unop);
                    $data = null;
                    $total = null;
                    $cont = 0;
                    foreach ($result as $r) {
                        $cont++;
                        $total += $r->precio;
                    }
                    foreach ($result as $r) {
                        $data[] = array(
                            "UNI. OP"=>  $r->unop,
                            "NOMB CLASIF"=>$r->nombreTramite,
                            "TASA" =>$r->nombresubtramite,
                            "PRECIO"=>$r->precio,
                            "NUM PAGOS"=>$r->nurPagos,

                        );
                    }
                    $var = 'CAPTACION DE INGRESOS DEL ' . $tiporep . ' - ' . $numero;
                    //************************Cabeza de hoja
                    //titulo
                    $sheet->mergeCells('B1:F1');

                    $sheet->cell('B1', function ($cell) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '14',
                            'bold' => true
                        ));
                        $cell->setValue('UNIVERSIDAD NACIONAL DE TRUJILLO');
                        $cell->setAlignment('center');
                    });
                    $sheet->mergeCells('B2:F2');
                    $sheet->cell('B2', function ($cell) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '14',
                            'bold' => false
                        ));
                        $cell->setValue('OGSEF- OF.TEC. TESORERIA');
                        $cell->setAlignment('center');
                    });
                    $sheet->mergeCells('B3:F3');

                    $sheet->cell('B3', function ($cell) use ($var) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '14',
                            'bold' => true
                        ));
                        $cell->setValue($var);
                        $cell->setAlignment('center');
                    });
                    //total
                    $sheet->cell('E6', function ($cell) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '14',
                            'bold' => true
                        ));
                        $cell->setValue('Total de ingresos :');
                        $cell->setAlignment('right');
                    });
                    $sheet->cell('F6', function ($cell) use ($total) {
                        $cell->setValue($total);
                    });
                    $sheet->cells('F6', function ($cells) {
                        $cells->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));
                        $cells->setAlignment('center');
                    });
                    //datos de impresion

                    $sheet->cell('B4', function ($cell) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '14',
                            'bold' => true
                        ));
                        $cell->setValue('Usuario : ');
                        $cell->setAlignment('left');
                    });

                    $sheet->mergeCells('C4:D4');
                    $sheet->cell('C4', function ($cell) use ($total) {

                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));
                        $cuenta = Session::get('misession');
                        $cell->setValue($cuenta);
                        $cell->setAlignment('left');
                    });
                    //fecha de impresion
                    $sheet->cell('E' . (4) . '', function ($cell) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '14',
                            'bold' => true
                        ));
                        $cell->setValue('Fecha de impresion: ');
                        $cell->setAlignment('left');
                    });
                    $sheet->cell('F4', function ($cell) use ($fechahoy) {

                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));

                        $cell->setValue($fechahoy);
                        $cell->setAlignment('left');
                    });
                    //Datos de impresion
                    $sheet->cell('B' . (5) . '', function ($cell) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '14',
                            'bold' => true
                        ));
                        $cell->setValue('Datos de impresion');
                        $cell->setAlignment('left');
                    });

                    $sheet->cell('C4', function ($cell) use ($total) {

                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));
                        $cuenta = Session::get('misession');
                        $cell->setValue($cuenta);
                    });
                    //opciones de busqueda
                    $sheet->mergeCells('C5:f5');
                    $sheet->cell('C5', function ($cell) use ($opiones) {

                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));
                        $cell->setValue($opiones);
                    });

                    //*************************************************
                    //*******************cabecera de tabla
                    $sheet->cells('B7:F7', function ($cells) {
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
                    $sheet->cells('B8:B' . ($cont + 7) . '', function ($cells) {
                        $cells->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));
                        $cells->setAlignment('center');
                    });
                    $sheet->cells('C8:C' . ($cont + 7) . '', function ($cells) {
                        $cells->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));
                        $cells->setAlignment('center');
                    });
                    $sheet->cells('E8:E' . ($cont + 7) . '', function ($cells) {
                        $cells->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));
                        $cells->setAlignment('center');
                    });
                    $sheet->cells('F8:F' . ($cont + 7) . '', function ($cells) {
                        $cells->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));
                        $cells->setAlignment('center');
                    });


                    //bordes de la hoja
                    $sheet->setBorder('B8:B' . ($cont + 7) . '');
                    $sheet->setBorder('C8:C' . ($cont + 7) . '');
                    $sheet->setBorder('D8:D' . ($cont + 7) . '');
                    $sheet->setBorder('E8:E' . ($cont + 7) . '');
                    $sheet->setBorder('F8:F' . ($cont + 7) . '');
                    //Firma
                    $sheet->cell('E' . ($cont + 10), function ($cell) {

                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12',
                            'bold' => true
                        ));
                        $cuenta = Session::get('misession');
                        $cell->setValue('Firma : ' . $cuenta);
                    });

                    $sheet->cells('E' . ($cont + 10), function ($cells) {

                        $cells->setBorder('thin', null, null, null);
                        $cells->setAlignment('center');
                    });

                    //ubicacion de la data
                    $sheet->fromArray($data, null, 'B7', false);
                    //nombre de hoja
                    $sheet->setTitle('Lista de reportes resumido');
                    //par que la data se ajuste
                    $sheet->setAutoSize(true);
                }
            });
        })->export('xls');
    }


//Consultar contador del subtramite
    function contadorSubtramite($codSubtramite)
    {
        $cont = null;
        $contador = DB::select('select contador from subtramite where subtramite.estado=1 and subtramite.codSubtramite="' . $codSubtramite . '"');

        foreach ($contador as $c) {
            $cont = $c->contador;
        }
        return $cont;
    }

}