<?php

namespace App\Http\Controllers;

use App\alumnomodel;
use App\clientemodel;
use App\escuelamodel;
use App\facultadmodel;
use App\pagomodel;
use App\personamodel;
use App\sedemodel;
use App\subtramitemodel;
use App\tramitemodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;


class pagoController extends Controller
{
    //Registrar pagos
    /*public function registrarPago(Request $request)
    {
        $csiaf = null;
        $cont = 0;
        $pers = new personamodel();
        $cli = new clientemodel();
        $al = new alumnomodel();
        $subt = new subtramitemodel();
        $codper = null;
        $codSubtramite = null;
        if ($request->select == 'Dni') {
            $codper = $pers->obtnerIdDni($request->text);//SQL, obtener datos de la persona por su dni
        } else {
            if ($request->select == 'Ruc') {
                $codper = $cli->consultarClienteRUC($request->text);//SQL, obtener datos del cliente por su ruc
            } else {
                if ($request->select == 'Codigo de alumno') {
                    $codper = $al->consultaridPersonaAlumno($request->text);//SQL, obtener datos del alumno por su codigo de alumno
                }
            }
        }
        if ($request->subtramite) {//si existe nombre de la tasa
            $codSubtramite = $subt->consultarSubtramiteidNombre($request->subtramite);//SQL, obtener id de la tasa por nombre de tasa
            $csiaf = $subt->consultarSiafNombreSubtramite($request->subtramite);//SQL, obtener clasificador siaf por el nombre de tasa
            $cont = $this->contadorSubtramite($request->subtramite);//SQL, obtener contador de la tasa por nombre de tasa
        } elseif ($request->txtsub) {//si existe codigo de la tasa
            $codSubtramite = $subt->consultarSubtramiteidNombre($request->txtsub);//SQL, obtener id de la tasa por nombre de tasa
            $csiaf = $subt->consultarSiafNombreSubtramite($request->txtsub);//SQL, obtener clasificador siaf por el nombre de tasa
            $cont = $this->contadorSubtramite($request->txtsub);//SQL, obtener contador de la tasa por nombre de tasa
        }
        $codigoS = $subt->consultarCodigoSubtramiteCodSubtramite($codSubtramite);//SQL, obtener codigoSubtramite de la tasa por su id de tasa
        date_default_timezone_set('America/Lima');
        $dato = date('Y-m-d H:i:s');
        $pago = $request->pagar;
        $total = $request->total;
        $cantidad = $request->multiplicador;
        $p = new pagomodel();
        if ($request->voucher) {
            $vfecha = $request->vfecha;
            $fecha = date('Y-m-d', strtotime($vfecha));
            $p->setNroVoucher($request->voucher);
            $p->setNroCuenta($request->vcuenta);
            $p->setModalidad('banco');
            if ($request->detalle) {
                $p->setDetalle($request->detalle . '-' . $request->voucher . '-' . $request->vcuenta . '/' . $fecha);
            } else {
                $p->setDetalle($request->voucher . '-' . $request->vcuenta . '/' . $fecha);
            }
        } else {
            $p->setModalidad('ventanilla');
            $p->setDetalle($request->detalle);
        }
        $p->setFecha($dato);
        $idper = Session::get('idpersonal', 'No existe session');
        $p->setCoPersonal($idper);
        $p->setIdPersona($codper);
        $p->setIdSubtramite($codSubtramite);
        $p->setCantidad($cantidad);
        if ($request->selectP) {
            $cpro = $al->bdProduccion($request->selectP);
            $cod = $al->obtenerCodAlumnoxCodPersona($codper);
            $ipa = $p->obteneridProduccionAlumno($cpro, $cod);
            $p->setIdProduccionAlumno($ipa);
        }
        $contaux = $cont + 1;
        if ($request->checkbox == 1) {
            $p->setDeuda(1);
        }
        $valid = $p->savePago($contaux);//SQL, insersion del pago
        $contador = $codigoS . '-' . $contaux;
        $buscar = $request->text;
        $val = Session::get('txt', 'No existe session');
        if ($valid == true) {
            if ($val == $request->text) {
                $totalp = $total + $pago;
                session()->put('text', $request->text);
                return view('/Ventanilla/Pagos/boleta2')->with(['buscar' => $buscar, 'total' => $totalp, 'nombre' => $request->nombres, 'apellidos' => $request->apellidos, 'escuela' => $request->escuela,
                    'facultad' => $request->facultad, 'sede' => $request->sede, 'detalle' => $request->detalle, 'fecha' => $dato, 'boleta' => $request->pagar, 'siaf' => $csiaf, 'contador' => $contador, 'select' => $request->select, 'tasa' => $request->subtramite]);
            } else {
                Session::forget('txt');
                Session::put('txt', $request->text);
                return view('/Ventanilla/Pagos/boleta2')->with(['buscar' => $buscar, 'total' => $request->boletapagar, 'nombre' => $request->nombres, 'apellidos' => $request->apellidos, 'escuela' => $request->escuela,
                    'facultad' => $request->facultad, 'sede' => $request->sede, 'detalle' => $request->detalle, 'fecha' => $dato, 'boleta' => $request->boletapagar, 'siaf' => $csiaf, 'contador' => $contador, 'select' => $request->select, 'tasa' => $request->subtramite]);
            }
        } else {
            return back()->with('false', 'Error cliente o alumno no registrador');
        }
    }*/
    public function registrarPago(Request $request)
    {
        $csiaf = null;
        $cont = 0;
        $pers = new personamodel();
        $cli = new clientemodel();
        $al = new alumnomodel();
        $subt = new subtramitemodel();
        $codper = null;
        $codSubtramite = null;
        if ($request->select == 'Dni') {
            $codper = $pers->obtnerIdDni($request->text);//SQL, obtener datos de la persona por su dni
        } else {
            if ($request->select == 'Ruc') {
                $codper = $cli->consultarClienteRUC($request->text);//SQL, obtener datos del cliente por su ruc
            } else {
                if ($request->select == 'Codigo de alumno') {
                    $codper = $al->consultaridPersonaAlumno($request->text);//SQL, obtener datos del alumno por su codigo de alumno
                }
            }
        }
        if ($request->subtramite) {//si existe nombre de la tasa
            $codSubtramite = $subt->consultarSubtramiteidNombre($request->subtramite);//SQL, obtener id de la tasa por nombre de tasa
            $csiaf = $subt->consultarSiafNombreSubtramite($request->subtramite);//SQL, obtener clasificador siaf por el nombre de tasa
            $cont = $this->contadorSubtramite($request->subtramite);//SQL, obtener contador de la tasa por nombre de tasa
        } elseif ($request->txtsub) {//si existe codigo de la tasa
            $codSubtramite = $subt->consultarSubtramiteidNombre($request->txtsub);//SQL, obtener id de la tasa por nombre de tasa
            $csiaf = $subt->consultarSiafNombreSubtramite($request->txtsub);//SQL, obtener clasificador siaf por el nombre de tasa
            $cont = $this->contadorSubtramite($request->txtsub);//SQL, obtener contador de la tasa por nombre de tasa
        }
        $codigoS = $subt->consultarCodigoSubtramiteCodSubtramite($codSubtramite);//SQL, obtener codigoSubtramite de la tasa por su id de tasa
        date_default_timezone_set('America/Lima');
        $dato = date('Y-m-d H:i:s');
        $pago = $request->pagar;
        $total = $request->total;
        $cantidad = $request->multiplicador;
        $p = new pagomodel();
        if ($request->voucher) {
            $vfecha = $request->vfecha;
            $fecha = date('Y-m-d', strtotime($vfecha));
            $p->setNroVoucher($request->voucher);
            $p->setNroCuenta($request->vcuenta);
            $p->setModalidad('banco');
            if ($request->detalle) {
                $p->setDetalle($request->detalle . '-' . $request->voucher . '-' . $request->vcuenta . '/' . $fecha);
            } else {
                $p->setDetalle($request->voucher . '-' . $request->vcuenta . '/' . $fecha);
            }
        } else {
            $p->setModalidad('ventanilla');
            $p->setDetalle($request->detalle);
        }
        $p->setFecha($dato);
        $idper = Session::get('idpersonal', 'No existe session');
        $p->setCoPersonal($idper);
        $p->setIdPersona($codper);
        $p->setIdSubtramite($codSubtramite);
        $p->setCantidad($cantidad);
        if ($request->selectP) {
            $cpro = $al->bdProduccion($request->selectP);
            $cod = $al->obtenerCodAlumnoxCodPersona($codper);
            $ipa = $p->obteneridProduccionAlumno($cpro, $cod);
            $p->setIdProduccionAlumno($ipa);
        }
        $contaux = $cont + 1;
        if ($request->checkbox == 1) {
            $p->setDeuda(1);
        }
        $valid = $p->savePago($contaux);//SQL, insersion del pago
        $contador = $codigoS . '-' . $contaux;
        $buscar = $request->text;
        $val = Session::get('txt', 'No existe session');
        if ($valid == true) {
            if ($val == $request->text) {
                $totalp = $total + $pago;
                session()->put('text', $request->text);
                $this->imprimirBoleta($contador, $csiaf, $request->nombres, $request->apellidos, $request->escuela, $request->subtramite, $request->detalle, $dato, $request->pagar, $value = Session::get('misession'));
                return view('/Ventanilla/Pagos/RealizarPago')->with(['buscar' => $buscar, 'total' => $totalp, 'nombre' => $request->nombres, 'apellidos' => $request->apellidos, 'escuela' => $request->escuela,
                    'facultad' => $request->facultad, 'sede' => $request->sede, 'detalle' => $request->detalle, 'fecha' => $dato, 'boleta' => $request->pagar, 'siaf' => $csiaf, 'contador' => $contador, 'select' => $request->select, 'tasa' => $request->subtramite]);
            } else {
                Session::forget('txt');
                Session::put('txt', $request->text);
                $this->imprimirBoleta($contador, $csiaf, $request->nombres, $request->apellidos, $request->escuela, $request->subtramite, $request->detalle, $dato, $request->boletapagar, $value = Session::get('misession'));
                return view('/Ventanilla/Pagos/RealizarPago')->with(['buscar' => $buscar, 'total' => $request->boletapagar, 'nombre' => $request->nombres, 'apellidos' => $request->apellidos, 'escuela' => $request->escuela,
                    'facultad' => $request->facultad, 'sede' => $request->sede, 'detalle' => $request->detalle, 'fecha' => $dato, 'boleta' => $request->boletapagar, 'siaf' => $csiaf, 'contador' => $contador, 'select' => $request->select, 'tasa' => $request->subtramite]);
            }
        } else {
            return back()->with('false', 'Error cliente o alumno no registrador');
        }
    }

    public function imprimirBoleta($contador, $siaf, $nombres, $apellidos, $escuela, $concepto, $detalle, $fecha, $monto, $personal)
    {
        //$connector = new FilePrintConnector("/dev/usb/lp0");
        $connector = new WindowsPrintConnector("EPSON FX-890");
        $printer = new Printer($connector);
        $printer->initialize();
        $printer->text("\n");
        $printer->text("\n");
        $printer->text("\n");
        $printer->text("\n");
        $printer->text("                                $contador                                                   ");
        $printer->text("                                $contador                                                   ");
        $printer->text("\n");
        $printer->text("SIAF: $siaf");
        $printer->text("                                                                              SIAF: $siaf");
        $printer->text("\n");
        $printer->text("RECIBIDO DE: $nombres $apellidos");
        $printer->text("                                                RECIBIDO DE: $nombres $apellidos");
        $printer->text("\n");
        $printer->text("ESCUELA: $escuela");
        $printer->text("                                                ESCUELA: $escuela");
        $printer->text("\n");
        $printer->text("CONCEPTO: $concepto");
        $printer->text("CONCEPTO: $concepto");
        $printer->text("                                                                                 CONCEPTO: $concepto");$printer->setPrintWidth(600);
        $printer->text("\n");
        $printer->text("DETALLE: $detalle");
        $printer->text("                                                                                 DETALLE: $detalle");
        $printer->text("\n");
        $printer->text("FECHA: $fecha");
        $printer->text("                                                                FECHA: $fecha");
        $printer->text("\n");
        $printer->text("MONTO: S/. $monto");
        $printer->text("                                                                             MONTO: S/. $monto");
        $printer->text("\n");
        $printer->text("DOS CIENTOS SOLES");
        $printer->text("                                                                         DOS CIENTOS SOLES");
        $printer->text("\n");
        $printer->text("CAJERO: $personal");
        $printer->text("                                                                         CAJERO: $personal");
        $printer->text("\n");
        $printer->text("\n");
        $printer->text("\n");
        $printer->close();
    }

    //Obtener contador de la tasa por su nombre de tasa
    public function contadorSubtramite($nombreSubtramite)
    {
        $cont = null;
        $contador = DB::select('select contador from subtramite where subtramite.estado=1 and subtramite.nombre="' . $nombreSubtramite . '"');
        foreach ($contador as $c) {
            $cont = $c->contador;
        }
        return $cont;
    }

    //Ajax autollenado, buscar datos del alumno por su dni
    public function buscarNombresD(Request $request)
    {
        $dato = array();
        $ar = array();
        $c = 0;
        $i = 0;
        $var = $request->name;
        $nombresa = DB::select('SELECT 
                nombres,
                apellidos,
                escuela.nombre enombre,
                facultad.nombre fnombre,
                produccion.nombre pnombre,
                nombresede
            FROM
                persona
                    LEFT JOIN
                alumno ON persona.codPersona = alumno.idPersona
                    LEFT OUTER JOIN
                produccionalumno ON produccionalumno.codAlumno = alumno.idAlumno
                    LEFT OUTER JOIN
                produccion ON produccionalumno.idProduccion = produccion.codProduccion
                    LEFT OUTER JOIN
                escuela ON escuela.idEscuela = alumno.coEscuela
                    LEFT OUTER JOIN
                facultad ON facultad.idFacultad = escuela.codigoFacultad
                    LEFT OUTER JOIN
                sede on sede.codSede = facultad.coSede
            WHERE
                persona.codPersona = alumno.idPersona
                    AND persona.dni = ' . $var . '
                    AND persona.estado = 1
                    AND alumno.estado = 1
                    AND sede.estado = 1');
        foreach ($nombresa as $np) {
            $dato[0] = $np->nombres;
            $dato[1] = $np->apellidos;
            $dato[2] = $np->enombre;
            $dato[3] = $np->fnombre;
            $dato[4] = $np->nombresede;
            $ar[$c] = $np->pnombre;
            $c++;
        }
        foreach ($ar as $p) {
            $dato[5][$i] = $p;
            $i++;
        }
        return response()->json($dato);
    }

    //Ajax autollenado, buscar datos del cliente por su dni
    public function buscarNombresDR(Request $request)
    {
        $dato = array();
        $var = $request->name;
        $nombres = DB::select('select * from persona
        left join cliente on persona.codPersona = cliente.idPersona
        where persona.codPersona = cliente.idPersona and persona.dni=:dni and persona.estado=1 and cliente.estado=1', ['dni' => $var]);
        foreach ($nombres as $np) {
            $dato[0] = $np->nombres;
            $dato[1] = $np->apellidos;
        }
        return response()->json($dato);

    }

    //Ajax autollenado, buscar datos del cliente por su ruc
    public function buscarNombresR(Request $request)
    {
        $dato = array();
        $var = $request->name;
        $nombres = DB::select('select * from persona left join cliente on persona.codPersona = cliente.idPersona
        where persona.codPersona = cliente.idPersona and cliente.ruc=:ruc and persona.estado=1 and cliente.estado=1', ['ruc' => $var]);
        foreach ($nombres as $np) {
            $dato[0] = $np->nombres;
            $dato[1] = $np->apellidos;
        }
        return response()->json($dato);

    }

    //Ajax autollenado, buscar datos del alumno por el codigo de alumno
    public function buscarNombresC(Request $request)
    {
        $dato = array();
        $ar = array();
        $c = 0;
        $i = 0;
        $var = $request->name;
        $nombresa = DB::select('SELECT 
                nombres,
                apellidos,
                escuela.nombre enombre,
                facultad.nombre fnombre,
                produccion.nombre pnombre,
                nombresede
            FROM
                persona
                    LEFT JOIN
                alumno ON persona.codPersona = alumno.idPersona
                    LEFT OUTER JOIN
                produccionalumno ON produccionalumno.codAlumno = alumno.idAlumno
                    LEFT OUTER JOIN
                produccion ON produccionalumno.idProduccion = produccion.codProduccion
                    LEFT OUTER JOIN
                escuela ON escuela.idEscuela = alumno.coEscuela
                    LEFT OUTER JOIN
                facultad ON facultad.idFacultad = escuela.codigoFacultad
                    LEFT OUTER JOIN
                sede on sede.codSede = facultad.coSede
            WHERE
                persona.codPersona = alumno.idPersona
                    AND alumno.codAlumno = "' . $var . '"
                    AND persona.estado = 1
                    AND alumno.estado = 1
                    AND sede.estado = 1');
        foreach ($nombresa as $np) {
            $dato[0] = $np->nombres;
            $dato[1] = $np->apellidos;
            $dato[2] = $np->enombre;
            $dato[3] = $np->fnombre;
            $dato[4] = $np->nombresede;
            $ar[$c] = $np->pnombre;
            $c++;
        }
        foreach ($ar as $p) {
            $dato[5][$i] = $p;
            $i++;
        }
        return response()->json($dato);
    }

    //Ajax autollenado, buscar precio de la tasa por nombre de tasa
    public function precioSubtramite(Request $request)
    {
        $pre = 0;
        //$var = $request->name;
        //$precioS = DB::select('select precio from subtramite where nombre= "' . $var . '" and estado=1');
        $precioS = DB::select('select precio from subtramite where nombre=:nombre and estado=1', ['nombre' => $request->name]);
        foreach ($precioS as $ps) {
            $pre = $ps->precio;
        }
        return $pre;
    }

    //Ajax autollenado, obtener nombre de las tasas
    public function autocompletes(Request $request)
    {
        $data = DB::table('subtramite')->select("nombre as name")->where("nombre", "LIKE", "%{$request->input('query')}%")->get();
        return response()->json($data);
    }

    //Buscar pagos
    public function listarPago(Request $request)
    {
        $valueA = Session::get('tipoCuentaA');
        $valueV = Session::get('tipoCuentaV');
        $valueR = Session::get('tipoCuentaR');
        date_default_timezone_set('America/Lima');
        $date = date('d-m-Y H:i:s');
        $val = 0;
        $total = 0;
        $pag = null;
        $pago = new pagomodel();
        if ($request->checkbox == 1) {
            $val = 1;
        }
        if ($request->selected == 'Dni') {
            $pag = $pago->consultarAlumnoDNI($request->text, $val);//SQL, buscar datos de la persona por dni
        } else {
            if ($request->selected == 'Codigo alumno') {
                $pag = $pago->consultarAlumnoCodigo($request->text, $val);//SQL, buscar datos del alumno por codigo de alumno
            } else {
                if ($request->selected == 'Ruc') {
                    $pag = $pago->consultarClienteRuc($request->text, $val);//SQL, buscar datos del cliente por ruc
                } else {
                    if ($request->selected == 'Codigo pago') {
                        $pag = $pago->consultarCodigoPago($request->text, $val);//SQL, buscar datos del pago por codigo del pago
                    } else {
                        if ($request->selected == 'Reporte diario') {//Reporte del reporte diario del personal logueado
                            Excel::create('Reporte diario/' . $date . '', function ($excel) use ($request, $date) {
                                $excel->sheet('Reporte Diario', function ($sheet) use ($request, $date) {
                                    $data = null;
                                    $pag = null;
                                    $total = 0;
                                    $cont = 0;
                                    $usuario = null;
                                    $pago = new pagomodel();
                                    $pag = $pago->listarPagosPersonal($request->text);//SQL, obtener datos del pago realizado por el personal (diario)

                                    foreach ($pag as $p) {
                                        $total += $p->precio;
                                    }

                                    foreach ($pag as $p) {
                                        $usuario = $p->papellidos . ', ' . $p->pnombres;
                                    }

                                    foreach ($pag as $p) {
                                        $cont++;
                                        $data[] = array(
                                            "Clasificador" => $p->clasificadorsiaf,
                                            "Nombre de Clasificador" => $p->nombreTramite,
                                            "Codigo Tasa" => $p->codigoSubtramite,
                                            "Tasa" => $p->nombre,
                                            "Total" => $p->precio,
                                            "Numero de Pagos" => $p->nurPagos,
                                        );
                                    }
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
                                        $cell->setValue('Reporte diaro');
                                        $cell->setAlignment('center');
                                    });

                                    $sheet->cell('B4', function ($cell) {
                                        $cell->setFont(array(
                                            'family' => 'Arial',
                                            'size' => '12',
                                            'bold' => true
                                        ));
                                        $cell->setValue('Fecha:');
                                        $cell->setAlignment('center');
                                    });

                                    $sheet->cell('C4', function ($cell) use ($date) {
                                        $cell->setFont(array(
                                            'family' => 'Arial',
                                            'size' => '12',
                                            'bold' => true
                                        ));
                                        $cell->setValue($date);
                                        $cell->setAlignment('center');
                                    });

                                    $sheet->cell('E4', function ($cell) {
                                        $cell->setFont(array(
                                            'family' => 'Arial',
                                            'size' => '12',
                                            'bold' => true
                                        ));
                                        $cell->setValue('Impreso por:');
                                        $cell->setAlignment('center');
                                    });

                                    $sheet->mergeCells('F4:G4');
                                    $sheet->cell('F4', function ($cell) use ($usuario) {
                                        $cell->setFont(array(
                                            'family' => 'Arial',
                                            'size' => '12',
                                            'bold' => true
                                        ));
                                        $cell->setValue($usuario);
                                        $cell->setAlignment('center');
                                    });

                                    //total
                                    $sheet->cell('F6', function ($cell) {
                                        $cell->setFont(array(
                                            'family' => 'Arial',
                                            'size' => '12',
                                            'bold' => true
                                        ));
                                        $cell->setValue('Total de ingresos :');
                                        $cell->setAlignment('right');
                                    });
                                    $sheet->cell('G6', function ($cell) use ($total) {
                                        $cell->setValue($total);
                                    });
                                    $sheet->cells('G6', function ($cells) {
                                        $cells->setFont(array(
                                            'family' => 'Arial',
                                            'size' => '12'
                                        ));
                                        $cells->setAlignment('center');
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
                                    $sheet->cells('G7:G' . ($cont + 7) . '', function ($cells) {
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
                                    $sheet->cells('G7:G' . ($cont + 7) . '', function ($cells) {
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
                                    //bordes de la hoja
                                    $sheet->setBorder('B7:B' . ($cont + 7) . '');
                                    $sheet->setBorder('C7:C' . ($cont + 7) . '');
                                    $sheet->setBorder('D7:D' . ($cont + 7) . '');
                                    $sheet->setBorder('E7:E' . ($cont + 7) . '');
                                    $sheet->setBorder('F7:F' . ($cont + 7) . '');
                                    $sheet->setBorder('G7:G' . ($cont + 7) . '');
                                    //ubicacion de la data
                                    $sheet->fromArray($data, null, 'B7', false);
                                    //nombre de hoja
                                    $sheet->setTitle('Lista de reportes resumido');
                                    //par que la data se ajuste
                                    $sheet->setAutoSize(true);
                                });
                            })->export('xls');
                        } else {
                            $pag = $pago->consultarPagos($val);
                        }
                    }
                }
            }
        }
        foreach ($pag as $p) {
            $total = $total + $p->precio;
        }
        if ($valueA == 'Administrador')
            return view('Adminnistrador/Pagos/ReportPago')->with(['pagos' => $pag, 'txt' => $request->text, 'select' => $request->selected, 'total' => $total]);
        if ($valueV == 'Ventanilla')
            return view('Ventanilla/Pagos/ReportPago')->with(['pagos' => $pag, 'txt' => $request->text, 'select' => $request->selected, 'total' => $total]);
        if ($valueR == 'Reportes')
            return view('Reportes/Pagos/ReportPago')->with(['pagos' => $pag, 'txt' => $request->text, 'select' => $request->selected, 'total' => $total]);
    }

    //Eliminar (cambiar estado de 1 a 0) registro del pago
    public function eliminarPago($codPago)
    {
        $pago = new pagomodel();
        $bool = $pago->eliminarPago($codPago);//SQL, eliminar pago
        if ($bool == true)
            return back()->with('true', 'Pago eliminado con exito')->withInput();
        if ($bool == false)
            return back()->with('false', 'Pago no eliminado')->withInput();
    }

    //Devolucion de pago
    public function DevolucionPago($codPago)
    {
        $pago = new pagomodel();
        $bool = $pago->devolucionPago($codPago);//SQL, devolucion de pago y establecer fecha de devolucion
        if ($bool == true)
            return back()->with('true', 'Devolucion exitosa')->withInput();
        if ($bool == false)
            return back()->with('false', 'Devolucion no exitosa')->withInput();
    }

    //Aun no se aplica...
    public function eliminarDeuda($codPago)
    {
        $pago = new pagomodel();
        $pago->eliminarDeuda($codPago);
        return view('Ventanilla/Pagos/ReportPago');
    }

    //Buscar pagos, detallado
    public function reportePagos(Request $request)
    {

        $sede = new sedemodel();
        $fac = new facultadmodel();
        $esc = new escuelamodel();
        $subTramiteModel = new subtramitemodel();
        $pagoModel = new pagomodel();
        $tramiteModel = new  tramitemodel();
        $fechaDesde = $request->fechaDesde; // El formato que te entrega MySQL es Y-m-d
        $fechaDesde = date("Y-m-d", strtotime($fechaDesde));
        $fechaHasta = $request->fechaHasta; // El formato que te entrega MySQL es Y-m-d
        $fechaHasta = date("Y-m-d", strtotime($fechaHasta));
        $estado = $request->estado;
        $modalidad = $request->modalidad;
        $centroProducion = $request->cp;
        $total = 0;
        $imput = $request->inputTram;
        $lugar = null;
        $codigo = null;
        $opcBusqueda = 'Fecha desde : ' . $fechaDesde . ' hasta :' . $fechaHasta . '| Estado :' . $estado;
        echo $centroProducion;

        if ($modalidad !== 'Todo') {
            $opcBusqueda .= '| Modalidad :' . $modalidad;
        }
        if ($request->opcTramite !== 'Todo') {
            $opcBusqueda .= '| ' . $request->opcTramite . ' : ' . $imput;
        }
        if (empty($centroProducion) != true) {
            $opcBusqueda .= '| Centro de produccion : ' . $centroProducion;
        }

        if (empty($request->sed) != true) {
            if (empty($request->fac) != true) {
                if (empty($request->esc) != true) {
                    $codigo = $esc->obtenerId($request->esc);//SQL, obtener id de la escuela por su nombre
                    $lugar = 'es.idEscuela';
                    $opcBusqueda .= '|Sede : ' . $request->sed . '| Facultad : ' . $request->fac . '| Escuela : ' . $request->esc;
                } else {
                    $codigo = $fac->obtenerId($request->fac);//SQL, obtener id de la facultad por su nombre
                    $lugar = 'fac.idFacultad';
                    $opcBusqueda .= '| Sede : ' . $request->sed . '| Facultad : ' . $request->fac . '';
                }
            } else {
                $codigo = $sede->obtenerId($request->sed);//SQL, obtener id de la sede por su nombre
                $lugar = 'se.codSede';
                $opcBusqueda .= '| Sede : ' . $request->sed;
            }
        } else {
            $lugar = null;
        }

        if ($estado == 'Anulado') {
            $estado = 3;
        } else {
            if ($estado == 'Eliminado') {
                $estado = 0;
            } else {
                $estado = 1;
            }
        }
        if ($request->opcTramite == 'Clasificador') {
            $tramites = $tramiteModel->consultarId($imput);//SQL, obtener id del clasificador por su nombre
            $tram = 'tr.codTramite';
        } else {
            if ($request->opcTramite == 'Tasa') {
                $tramites = $subTramiteModel->consultarId($imput);//SQL, obtener id de la tasa por su nombre
                $tram = 'st.codSubtramite';
            } else {
                $tramites = null;
                $tram = 'Todo';
            }
        }
        if (empty($request->fuf) != true) {
            $fuenfin = $request->fuf;
            $opcBusqueda .= '| Fuente de financiamiento : ' . $fuenfin;
        } else {
            $fuenfin = null;
        }
        if (empty($request->tr) != true) {
            $tipRe = $request->tr;
            $opcBusqueda .= '| Tipo reporte : ' . $tipRe;
        } else {
            $tipRe = null;
        }
        $result = $pagoModel->listarGeneral($estado, $modalidad, $fechaDesde, $fechaHasta, $tram, $tramites, $tipRe, $fuenfin, $lugar, $codigo, $centroProducion);//Listar: pago,personal,subtramite,escuela,facultad
        if (!is_null($result) && empty($result) != true) {
            foreach ($result as $sum) {
                $total = $total + $sum->precio;
            }
        } else {
            $total = 0;
        }


        $cadena = $estado . ';' . $modalidad . ';' . $fechaDesde . ';' . $fechaHasta . ';' . $tram . ';' . $tramites . ';' . $tipRe . ';' . $fuenfin . ';' . $lugar . ';' . $codigo . ';' . $centroProducion . ';' . $opcBusqueda;
        //  $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $cadena, MCRYPT_MODE_CBC, md5(md5($key))));
        return view('Administrador/Reporte/Report')->with(['centroproduccion' => $centroProducion, 'result' => $result, 'total' => $total, 'estado' => $estado, 'modalidad' => $modalidad, 'fechaDesde' => $fechaDesde, 'fechaHasta' => $fechaHasta, 'tram' => $tram, 'tramites' => $tramites, 'tipRe' => $tipRe, 'fuenfin' => $fuenfin, 'lugar' => $lugar, 'codigo' => $codigo, 'encript' => $cadena]);
    }

    //Reenviar datos de la boleta de pago a la vista de: RealizarPago
    public function obtenerDatos(Request $request)
    {
        $buscar = $request->buscar;
        $total = $request->total;
        $nombre = $request->nombres;
        $apellidos = $request->apellidos;
        $escuela = $request->escuela;
        $facultad = $request->facultad;
        $detalle = $request->detalle;
        $fecha = $request->fecha;
        $select = $request->selected;
        $tasa = $request->tasa;
        $sede = $request->sede;
        return view('/Ventanilla/Pagos/RealizarPago')->with(['buscar' => $buscar, 'total' => $total,
            'nombre' => $nombre, 'apellidos' => $apellidos, 'escuela' => $escuela, 'tasa' => $tasa, 'sede' => $sede,
            'facultad' => $facultad, 'detalle' => $detalle, 'fecha' => $fecha, 'selected' => $select]);
    }

    public function reporteCentrosDeProduccion(Request $request)
    {
        echo 'asdasd';
    }

    //Reporte de pagos, resumen
    public function obtenerPagosresumen(Request $request)
    {


        if ($request->combito !== 'Escojer') {
            $numero = '';
            $result = null;
            $pagoModel = new pagomodel();
            $varOpc = $request->tipreporte;
            $vartiemp = $request->combito;
            $unidadOpera = $request->textbox;
            $varaño = $request->año1;

            if ($varOpc == 'Resumen total') {//Si se escoge: Resumen total
                $tiempo = null;
                if ($vartiemp == 'Año') {
                    $tiempo = 'where Year(po.fecha) = ' . $varaño . '';
                    $result = $pagoModel->listarpagosresumen($tiempo, $unidadOpera);//SQL, obtener pagos por año
                    $numero = $varaño;
                } else {
                    if ($vartiemp == 'Mes') {
                        $tiempo = 'where MONTH(po.fecha) = ' . $request->mes2 . ' and Year(po.fecha)=' . $request->año2 . '';
                        $result = $pagoModel->listarpagosresumen($tiempo, $unidadOpera);//SQL, obtener pagos por mes
                        $meses = array("ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE");
                        $valor = $meses[$request->mes2 - 1];
                        $numero = 'DE ' . $valor . ' DEL ' . $request->año2;
                    } else {
                        if ($vartiemp == 'Dia') {
                            $originalDate = $request->fecha;
                            $fecha = date("Y-m-d", strtotime($originalDate));
                            $tiempo = 'where DATE(po.fecha) =\'' . $fecha . '\'';
                            $result = $pagoModel->listarpagosresumen($tiempo, $unidadOpera);//SQL, obtener pagos por fecha
                            $numero = $fecha;
                        }
                    }
                }
                $total = 0;

                foreach ($result as $r) {
                    $total += $r->importe;
                }
                return view('Administrador/Reporte/reporteresumido')->with(['resultresu' => $result, 'total' => $total, 'varopc' => $varOpc, 'tiprep' => $vartiemp, 'tiempo' => $tiempo, 'numero' => $numero, 'unop' => $unidadOpera]);
            } elseif ($varOpc == 'Clasificador S.I.A.F') {//Si se escoge Clasificador SIAF

                $tiempo = null;
                if ($vartiemp == 'Año') {
                    $tiempo = 'where Year(po.fecha) = ' . $varaño . '';
                    $result = $pagoModel->obtenerPagosresumensiaf($tiempo, $unidadOpera);//SQL, obtener pagos resumidos por año resumido
                    $numero = $varaño;
                } elseif ($vartiemp == 'Mes') {
                    $tiempo = 'where MONTH(po.fecha) = ' . $request->mes2 . ' and Year(po.fecha)=' . $request->año2 . '';
                    $result = $pagoModel->obtenerPagosresumensiaf($tiempo, $unidadOpera);//SQL, obtener pagos resumidos por mes
                    $meses = array("ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE");
                    $valor = $meses[$request->mes2 - 1];
                    $numero = 'DE ' . $valor . ' DEL ' . $request->año2;

                } elseif ($vartiemp == 'Dia') {
                    $originalDate = $request->fecha;
                    $fecha = date("Y-m-d", strtotime($originalDate));
                    $tiempo = 'where DATE(po.fecha) =\'' . $fecha . '\'';
                    $result = $pagoModel->obtenerPagosresumensiaf($tiempo, $unidadOpera);//SQL, obtener pagos resumido por fecha
                    $numero = $fecha;
                }
                $total = 0;
                foreach ($result as $r) {
                    $total += $r->precio;
                }
                return view('Administrador/Reporte/reporteresumido')->with(['resultsiaf' => $result, 'total' => $total, 'varopc' => $varOpc, 'tiprep' => $vartiemp, 'tiempo' => $tiempo, 'numero' => $numero, 'unop' => $unidadOpera]);
            }
        } else {
            return view('Administrador/Reporte/reporteresumido');
        }
    }
}