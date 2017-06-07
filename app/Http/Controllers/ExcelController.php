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

    //Importar lista de alumno a la bd , en prueba
    public function importarAlumnos(Request $request)
    {

        $archivo = $request->file('import_file');
        $nombreOriginal = $archivo->getClientOriginalName();
        $extension = $archivo->getClientOriginalExtension();
        $rl = Storage::disk('excelalumnos')->put($nombreOriginal, \File::get($archivo));
        $ruta = storage_path('excelalumnos') . '/' . $nombreOriginal;
        if ($rl) {

            $ct = 0;
            Excel::selectSheetsByIndex(0)->load($ruta, function ($hoja) use ($ct) {

                $hoja->each(function ($fila) {
                    $alumno = new alumnomodel();
                    $alumno = new alumnomodel();
                    $alumno->setDni($fila->dni);
                    echo $fila->dni;
                    $alumno->setNombres($fila->nombres);
                    $alumno->setApellidos($fila->apellido_paterno . ' ' . $fila->apellido_materno);
                    $alumno->setCodAlumno($fila->codigo_alumno);
                    $alumno->setFecha($fila->fecha);
                    $alumno->setIdEscuela(1);
                    $alumno->setCorreo('asdasd');
                    $al = $alumno->savealumno($fila->dni);

                });
                echo $ct;
            });

        }


        $val = null;
        $contaux = null;
        $sede = new sedemodel();
        $facultad = new facultadmodel();
        $escuela = new escuelamodel();
        if ($request->hasFile('D:\TesoreriaAlumnos_Huamachuco')) {
            $path = Input::file('Alumnos_Huamachuco')->getRealPath();
            $data = Excel::load($path, function ($reader) {
            })->get();
            if (!empty($data) && $data->count()) {
                foreach ($data->toArray() as $key => $value) {
                    echo 'aqui';
                    if (!empty($value)) {
                        foreach ($value as $v) {
                            $codSede = $sede->obtenerId($request->nombreSede);
                            $codfacultad = $facultad->obteneridSede($codSede, $v['Facultad']);
                            $codescuela = $escuela->obtenerIdEscuela($codfacultad, $v['Escuela']);
                            echo 'codise' . $codSede . 'fac' . $codfacultad . 'cod' . $codescuela;

                        }
                    }
                }
            }
        }
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

    //Importar datos del banco, excel
    /*public function importExcel(Request $request)
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
    }*/

    public function importExcelAlumno(Request $request)
    {
        $alumno = new alumnomodel();

        if ($request->hasFile('import_file')) {
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function ($reader) {
            })->get();
            if (!empty($data) && $data->count()) {
                foreach ($data->toArray() as $key => $value) {
                    if (!empty($value)) {
                        foreach ($value as $v) {
                            $alumno->setDni($v['dni']);
                            $alumno->setNombres($v['nombres']);
                            $alumno->setApellidos($v['apeliidos']);
                            $alumno->setCodAlumno($v['codAlumno']);
                            $alumno->setCorreo($v['correo']);
                            $alumno->setFecha($v['fecha']);
                            $idE = $alumno->bdEscuelaSede($v['escuela'], $v['sede']);//Consular el id de la escuela a la que va a pertenecer
                            $alumno->setIdEscuela($idE);
                            $alumno->savealumno($v['dni']);
                        }
                        return back()->with('true', 'Se subio el archivo');
                    }
                }
            }
        }
        return back()->with('error', 'Por favor, revisar su archivo.');
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
                        foreach ($value as $v) {
                            $tramite->setClasificador($v['clasificador']);;
                            $tramite->setNombre($v['nombre']);
                            $tramite->save();
                        }
                        return back()->with('true', 'Se subio el archivo');
                    }
                }
            }
        }
        return back()->with('error', 'Por favor, revisar su archivo.');
    }

    public function importExcelTasa(Request $request)
    {
        $subtramite = new subtramitemodel();

        if ($request->hasFile('import_file')) {
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function ($reader) {
            })->get();
            if (!empty($data) && $data->count()) {
                foreach ($data->toArray() as $key => $value) {
                    if (!empty($value)) {
                        foreach ($value as $v) {
                            $subtramite->setCodigotasa($v['codigo']);
                            $subtramite->setNombre($v['nombre']);
                            $subtramite->setPrecio($v['precio']);
                            $idTra = $subtramite->bdTramitexClasificador($v['siaf']);
                            $subtramite->setIdTramite($idTra);
                            $subtramite->save();
                        }
                        return back()->with('true', 'Se subio el archivo');
                    }
                }
            }
        }
        return back()->with('error', 'Por favor, revisar su archivo.');
    }

    public function importExcelSede(Request $request)
    {
        $val = null;
        $sede = new sedemodel();

        if ($request->hasFile('import_file')) {
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function ($reader) {
            })->get();
            if (!empty($data) && $data->count()) {
                foreach ($data->toArray() as $key => $value) {
                    if (!empty($value)) {
                        foreach ($value as $v) {
                            $sede->setNombreSede($v['sede']);
                            $sede->setCodigoSede($v['codigo']);
                            $sede->setDireccion($v['direccion']);
                            $sede->save();
                        }
                        return back()->with('true', 'Se subio el archivo')->withInput();
                    }
                }
            }
        }
        return back()->with('error', 'Por favor, revisar su archivo.');
    }

    public function importExcelFacultad(Request $request)
    {
        $val = null;
        $facultad = new facultadmodel();

        if ($request->hasFile('import_file')) {
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function ($reader) {
            })->get();
            if (!empty($data) && $data->count()) {
                foreach ($data->toArray() as $key => $value) {
                    if (!empty($value)) {
                        foreach ($value as $v) {
                            $facultad->setNombre($v['facultad']);
                            $facultad->setCodFacultad($v['codigo']);
                            $facultad->setNroCuenta($v['cuenta']);
                            $codsede = $facultad->bscSedeId($v['sede']);//SQL, buscar id de la sede por su nombre
                            $facultad->setCodSede($codsede);
                            $facultad->save();
                        }
                        return back()->with('true', 'Se subio el archivo')->withInput();
                    }
                }
            }
        }
        return back()->with('error', 'Por favor, revisar su archivo.');
    }

    public function importExcelEscuela(Request $request)
    {
        $val = null;
        $escuela = new escuelamodel();

        if ($request->hasFile('import_file')) {
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function ($reader) {
            })->get();
            if (!empty($data) && $data->count()) {
                foreach ($data->toArray() as $key => $value) {
                    if (!empty($value)) {
                        foreach ($value as $v) {
                            $escuela->setNombre($v['escuela']);
                            $escuela->setCodEscuela($v['codigo']);
                            $escuela->setNroCuenta($v['cuenta']);
                            $coF = $escuela->buscarFacultad($v['facultad'], $v['sede']);
                            $escuela->setFacultad($coF);
                            $escuela->saveescuela();
                        }
                        return back()->with('true', 'Se subio el archivo')->withInput();
                    }
                }
            }
        }
        return back()->with('error', 'Por favor, revisar su archivo.');
    }

    //Jhon, no encuentro donde esta esto
    public function reportepagodetalle($estado, $modalidad, $opctram, $valtram, $sede, $facultad, $escuela, $tipre, $fuefi, $fechades, $fechahas)
    {
        date_default_timezone_set('America/Lima');
        $fechahoy = date('Y-m-d');
        Excel::create('Reporte detallado :  ' . $fechahoy . '', function ($excel) use ($estado, $modalidad, $opctram, $valtram, $sede, $facultad, $escuela, $tipre, $fuefi, $fechades, $fechahas) {
            $excel->sheet('resumen', function ($sheet) use ($estado, $modalidad, $opctram, $valtram, $sede, $facultad, $escuela, $tipre, $fuefi, $fechades, $fechahas) {

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

        list($estado, $modalidad, $fechaDesde, $fechaHasta, $tram, $tramites, $tipRe, $fuenfin, $lugar, $codigo) = explode(';', $encriptado);
        date_default_timezone_set('America/Lima');
        $fechahoy = date('Y-m-d');

        Excel::create('Reporte resumido  :  ' . $fechahoy . '', function ($excel) use ($estado, $modalidad, $fechaDesde, $fechaHasta, $tram, $tramites, $tipRe, $fuenfin, $lugar, $codigo, $fechahoy) {
            $excel->sheet('resumen', function ($sheet) use ($estado, $modalidad, $fechaDesde, $fechaHasta, $tram, $tramites, $tipRe, $fuenfin, $lugar, $codigo, $fechahoy) {
                $pagoModel = new pagomodel();
                $data = null;
                $result = $pagoModel->listarGeneral($estado, $modalidad, $fechaDesde, $fechaHasta, $tram, $tramites, $tipRe, $fuenfin, $lugar, $codigo);//pago,personal,subtramite,escuela,facultad
                $total = 0;
                $cont = 0;

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
                    , "TIP REC" => $r->tiporecurso
                    , "FUE FIN" => $r->fuentefinanc
                    , "CLASIFICADOR" => $r->nombretramite
                    , "TASA" => $r->nombresubtramite
                    , "FECHA" => $r->fechapago
                    , "PRECIO" => $r->precio
                    , "DETALLE" => $r->pagodetalle

                    );
                }

                $sheet->mergeCells('B1:N1');

                $sheet->cell('B1', function ($cell) {
                    $cell->setFont(array(
                        'family' => 'Arial',
                        'size' => '12',
                        'bold' => true
                    ));
                    $cell->setValue('UNIVERSIDAD NACIONAL DE TRUJILLO');
                    $cell->setAlignment('center');
                });
                $sheet->mergeCells('B2:N2');
                $sheet->cell('B2', function ($cell) {
                    $cell->setFont(array(
                        'family' => 'Arial',
                        'size' => '12',
                        'bold' => false
                    ));
                    $cell->setValue('OGSEF- OF.TEC. TESORERIA');
                    $cell->setAlignment('center');
                });
                $sheet->mergeCells('B3:N3');

                $sheet->cell('B3', function ($cell) {
                    $cell->setFont(array(
                        'family' => 'Arial',
                        'size' => '12',
                        'bold' => true
                    ));
                    $cell->setValue('Reporte de pagos detallado');
                    $cell->setAlignment('center');
                });

                //total
                $sheet->cell('M6', function ($cell) {
                    $cell->setFont(array(
                        'family' => 'Arial',
                        'size' => '12',
                        'bold' => true
                    ));
                    $cell->setValue('Total de ingresos :');
                    $cell->setAlignment('right');
                });
                $sheet->cell('N6', function ($cell) use ($total) {
                    $cell->setValue($total);
                });
                $sheet->cells('N6', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '12'
                    ));
                    $cells->setAlignment('center');
                });

                //*************************************************
                //*******************cabecera de tabla
                $sheet->cells('B7:N7', function ($cells) {
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
                $sheet->cells('M7:M' . ($cont + 7) . '', function ($cells) {
                    $cells->setFont(array(
                        'family' => 'Arial',
                        'size' => '12'
                    ));
                    $cells->setAlignment('center');
                });
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
                $sheet->setBorder('M7:M' . ($cont + 7) . '');
                $sheet->setBorder('N7:N' . ($cont + 7) . '');
                //ubicacion de la data
                $sheet->fromArray($data, null, 'B7', false);
                //nombre de hoja
                $sheet->setTitle('Lista de reportes resumido');
                //par que la data se ajuste
                $sheet->setAutoSize(true);


            });
        })->export('xls');
    }

    //Reporte resumido, formato excel
    function reportePagoresu($tiporep, $varopc, $tiempo, $numero)
    {
        date_default_timezone_set('America/Lima');
        $fechahoy = date('Y-m-d');
        Excel::create('Reporte resumido  :  ' . $fechahoy . '', function ($excel) use ($tiporep, $varopc, $tiempo, $fechahoy, $numero) {
            $excel->sheet('resumen', function ($sheet) use ($tiporep, $varopc, $tiempo, $fechahoy, $numero) {
                $pagoModel = new pagomodel();
                $fecha = '';
                if ($varopc == 'Resumen total') {
                    $data = null;
                    $tiempo = null;
                    $result = null;
                    if ($tiporep == 1) {
                        $result = $pagoModel->listarpagosresumen($tiempo);//SQL, buscar pagos por fecha
                        $fecha = 'AÑO';
                    } elseif ($tiporep == 2) {
                        $result = $pagoModel->listarpagosresumen($tiempo);//SQL, buscar pagos por fecha
                        $fecha = 'MES';
                    } elseif ($tiporep == 3) {
                        $result = $pagoModel->listarpagosresumen($tiempo);//SQL, buscar pagos por fecha
                        $fecha = 'DIA';
                    }
                    $total = 0;
                    $cont = 0;
                    foreach ($result as $r) {
                        $total += $r->importe;
                    }
                    foreach ($result as $p) {
                        $cont++;
                        $data[] = array(
                            "CLASIFICADOR S.I.A.F" => $p->clasificadorsiaf,
                            "NOMBRE DE CLASIFICADOR" => $p->nombreTramite,
                            "IMPORTE" => $p->importe,
                        );
                    }

                    $var = 'CAPTACION DE INGRESOS DEL ' . $fecha . ' - ' . $numero;
                    //************************Cabeza de hoja
                    //titulo
                    $sheet->mergeCells('B1:D1');

                    $sheet->cell('B1', function ($cell) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12',
                            'bold' => true
                        ));
                        $cell->setValue('UNIVERSIDAD NACIONAL DE TRUJILLO');
                        $cell->setAlignment('center');
                    });
                    $sheet->mergeCells('B2:D2');
                    $sheet->cell('B2', function ($cell) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12',
                            'bold' => false
                        ));
                        $cell->setValue('OGSEF- OF.TEC. TESORERIA');
                        $cell->setAlignment('center');
                    });
                    $sheet->mergeCells('B3:D3');

                    $sheet->cell('B3', function ($cell) use ($var) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12',
                            'bold' => true
                        ));
                        $cell->setValue($var);
                        $cell->setAlignment('center');
                    });
                    //total
                    $sheet->cell('C' . ($cont + 5) . '', function ($cell) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12',
                            'bold' => true
                        ));
                        $cell->setValue('Total de ingresos :');
                        $cell->setAlignment('right');
                    });
                    $sheet->cell('D' . ($cont + 5) . '', function ($cell) use ($total) {
                        $cell->setValue($total);
                    });
                    $sheet->cells('D' . ($cont + 5) . '', function ($cells) {
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
                    $sheet->cells('B4:B' . ($cont + 4) . '', function ($cells) {
                        $cells->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));
                        $cells->setAlignment('center');
                    });
                    $sheet->cells('D4:D' . ($cont + 4) . '', function ($cells) {
                        $cells->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));
                        $cells->setAlignment('center');
                    });


                    //bordes de la hoja
                    $sheet->setBorder('B4:B' . ($cont + 3) . '');
                    $sheet->setBorder('C4:C' . ($cont + 3) . '');
                    $sheet->setBorder('D4:D' . ($cont + 3) . '');

                    //ubicacion de la data
                    $sheet->fromArray($data, null, 'B4', false);
                    //nombre de hoja
                    $sheet->setTitle('Lista de reportes resumido');
                    //par que la data se ajuste
                    $sheet->setAutoSize(true);

                } elseif ($varopc == 'Clasificador S.I.A.F') {
                    $data = null;
                    $var = '';
                    $tiempo = null;
                    if ($tiporep == 1) {
                        $result = $pagoModel->obtenerPagosresumensiaf($tiempo);
                        $fecha = 'AÑO';
                    } elseif ($tiporep == 2) {
                        $result = $pagoModel->obtenerPagosresumensiaf($tiempo);
                        $fecha = 'MES';
                        // $valor = $meses[$valor - 1];
                    } elseif ($tiporep == 3) {
                        $result = $pagoModel->obtenerPagosresumensiaf($tiempo);
                        $fecha = 'DIA';
                    }
                    $var = 'RESUMEN DEL ' . $fecha . ' - ' . $numero;
                    $total = 0;
                    $cont = 0;
                    echo $tiempo;
                    foreach ($result as $r) {
                        $total += $r->precio;
                        $cont++;
                    }
                    foreach ($result as $p) {
                        $data[] = array(

                            "CLASIFICADOR S.I.A.F" => $p->clasificadorsiaf,
                            "NOMBRE DE CLASIFICADOR" => $p->nombreTramite,
                            "CUENTA" => $p->cuenta,
                            "NOMBRE DE TASA" => $p->nombresubtramite,
                            "NRO PAGOS" => $p->nurPagos,
                            "IMPORTE" => $p->precio
                        );

                    }

                    //************************Cabeza de hoja
                    //titulo
                    $sheet->mergeCells('B1:G1');

                    $sheet->cell('B1', function ($cell) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12',
                            'bold' => true
                        ));
                        $cell->setValue('UNIVERSIDAD NACIONAL DE TRUJILLO');
                        $cell->setAlignment('center');
                    });
                    $sheet->mergeCells('B2:G2');
                    $sheet->cell('B2', function ($cell) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12',
                            'bold' => false
                        ));
                        $cell->setValue('OGSEF- OF.TEC. TESORERIA');
                        $cell->setAlignment('center');
                    });
                    $sheet->mergeCells('B3:G3');
                    $sheet->cell('B3', function ($cell) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12',
                            'bold' => true
                        ));
                        $cell->setValue('CAPTACION DE INGRESOS');
                        $cell->setAlignment('center');
                    });
                    $sheet->mergeCells('B4:G4');
                    $sheet->cell('B4', function ($cell) use ($var) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12',
                            'bold' => true
                        ));
                        $cell->setValue($var);
                        $cell->setAlignment('center');
                    });

                    //cuerpo
                    $sheet->cell('B5', function ($cell) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12',
                            'bold' => true
                        ));
                        $cell->setValue('FECHA DE IMPRESION :');
                        $cell->setAlignment('left');
                    });
                    $sheet->cell('C5', function ($cell) use ($fechahoy) {
                        $cell->setFont(array(
                            'family' => 'Arial',
                            'size' => '12',
                            'bold' => false
                        ));
                        $cell->setValue($fechahoy);
                        $cell->setAlignment('left');
                    });

                    //total
                    $sheet->cell('F5', function ($cell) {
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
                    $sheet->cell('G5', function ($cell) use ($total) {
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
                    $sheet->cells('B6:B' . ($cont + 6) . '', function ($cells) {
                        $cells->setFont(array(
                            'family' => 'Arial',
                            'size' => '12'
                        ));
                        $cells->setAlignment('center');
                    });
                    $sheet->cells('D6:D' . ($cont + 6) . '', function ($cells) {
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
                    $sheet->cells('G6:G' . ($cont + 6) . '', function ($cells) {
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
                    $sheet->setBorder('G6:G' . ($cont + 6) . '');

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