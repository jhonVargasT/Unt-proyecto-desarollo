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


class pagoController extends Controller
{
    //Registrar pagos
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
        $pago = $request->boletapagar;
        $total = $request->total;
        $p = new pagomodel();
        $p->setDetalle($request->detalle);
        $p->setFecha($dato);
        $p->setModalidad('ventanilla');
        $idper = Session::get('idpersonal', 'No existe session');
        $p->setCoPersonal($idper);
        $p->setIdPersona($codper);
        $p->setIdSubtramite($codSubtramite);
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
                return view('/Ventanilla/Pagos/boleta')->with(['buscar' => $buscar, 'total' => $totalp,
                    'nombre' => $request->nombres, 'apellidos' => $request->apellidos, 'escuela' => $request->escuela,
                    'facultad' => $request->facultad, 'detalle' => $request->detalle, 'fecha' => $dato, 'boleta' => $request->boletapagar, 'siaf' => $csiaf, 'contador' => $contador]);
            } else {
                Session::forget('txt');
                Session::put('txt', $request->text);
                return view('/Ventanilla/Pagos/boleta')->with(['buscar' => $buscar, 'total' => $request->boletapagar,
                    'nombre' => $request->nombres, 'apellidos' => $request->apellidos, 'escuela' => $request->escuela,
                    'facultad' => $request->facultad, 'detalle' => $request->detalle, 'fecha' => $dato, 'boleta' => $request->boletapagar, 'siaf' => $csiaf, 'contador' => $contador]);
            }
        } else {
            return back()->with('false', 'Error cliente o alumno no registrador');
        }
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
        $var = $request->name;
        $nombresa = DB::select('select * from persona
        left join alumno on persona.codPersona = alumno.idPersona
        where persona.codPersona = alumno.idPersona and persona.dni=:dni and persona.estado=1 and alumno.estado=1', ['dni' => $var]);
        foreach ($nombresa as $np) {
            $na = $np->nombres;
            return response()->json($na);
        }
    }

    //Ajax autollenado, buscar datos del cliente por su dni
    public function buscarNombresDR(Request $request)
    {
        $var = $request->name;
        $nombres = DB::select('select * from persona
        left join cliente on persona.codPersona = cliente.idPersona
        where persona.codPersona = cliente.idPersona and persona.dni=:dni and persona.estado=1 and cliente.estado=1', ['dni' => $var]);
        foreach ($nombres as $np) {
            $nombres = $np->nombres;
            return response()->json($nombres);
        }
    }

    //Ajax autollenado, buscar datos del cliente por su ruc
    public function buscarNombresR(Request $request)
    {
        $var = $request->name;
        $nombres = DB::select('select * from persona left join cliente on persona.codPersona = cliente.idPersona
        where persona.codPersona = cliente.idPersona and cliente.ruc=:ruc and persona.estado=1 and cliente.estado=1', ['ruc' => $var]);
        foreach ($nombres as $np) {
            $nombres = $np->nombres;
            return response()->json($nombres);
        }
    }

    //Ajax autollenado, buscar datos del alumno por el codigo de alumno
    public function buscarNombresC(Request $request)
    {
        $var = $request->name;
        $nombres = DB::select('select * from persona left join alumno on persona.codPersona = alumno.idPersona
        where persona.codPersona = alumno.idPersona and alumno.codAlumno=:codAlumno and persona.estado=1 and alumno.estado=1', ['codAlumno' => $var]);
        foreach ($nombres as $np) {
            $nombres = $np->nombres;
            return response()->json($nombres);
        }
    }

    //Ajax autollenado, buscar cliente por su ruc
    public function buscarApellidosR(Request $request)
    {
        $var = $request->name;
        $nombres = DB::select('select * from persona left join cliente on persona.codPersona = cliente.idPersona
        where persona.codPersona = cliente.idPersona and cliente.ruc=:ruc and persona.estado=1 and cliente.estado=1', ['ruc' => $var]);
        foreach ($nombres as $np) {
            $apellidos = $np->apellidos;
            return response()->json($apellidos);
        }
    }

    //Ajax autollenado, buscar datos del cliente por su dni
    public function buscarApellidosD(Request $request)
    {
        $var = $request->name;
        $nombresP = DB::select('select * from persona
        left join alumno on persona.codPersona = alumno.idPersona
        where persona.codPersona = alumno.idPersona and persona.dni=:dni and persona.estado=1 and alumno.estado=1', ['dni' => $var]);
        foreach ($nombresP as $np) {
            $apellidos = $np->apellidos;
            return response()->json($apellidos);
        }
    }

    //Ajax autollenado, buscar datos del cliente por su dni
    public function buscarApellidosDR(Request $request)
    {
        $var = $request->name;
        $nombresP = DB::select('select * from persona
        left join cliente on persona.codPersona = cliente.idPersona
        where persona.codPersona = cliente.idPersona and persona.dni=:dni and persona.estado=1 and cliente.estado=1', ['dni' => $var]);
        foreach ($nombresP as $np) {
            $apellidos = $np->apellidos;
            return response()->json($apellidos);
        }
    }

    //Ajax autollenado, buscar datos del alumno por codigo de alumno
    public function buscarApellidosC(Request $request)
    {
        $var = $request->name;
        $nombresP = DB::select('select * from persona
        left join alumno on persona.codPersona = alumno.idPersona
        where persona.codPersona = alumno.idPersona and alumno.codAlumno=:codAlumno and persona.estado=1 and alumno.estado=1', ['codAlumno' => $var]);
        foreach ($nombresP as $np) {
            $apellidos = $np->apellidos;
            return response()->json($apellidos);
        }
    }

    //Ajax autollenado, buscar escuela del paciente por dni
    public function buscarEscuelaD(Request $request)
    {
        $var = $request->name;
        $nombresE = DB::select('select escuela.nombre from persona
        left join alumno on persona.codPersona = alumno.idPersona
        left join escuela on escuela.idEscuela = alumno.coEscuela
        where persona.codPersona = alumno.idPersona
        and escuela.idEscuela = alumno.coEscuela
        and persona.dni=:dni and persona.estado=1 and alumno.estado=1 and escuela.estado =1', ['dni' => $var]);
        foreach ($nombresE as $ne) {
            $escuelan = $ne->nombre;
            return response()->json($escuelan);
        }
    }

    //Ajax autollenado, buscar escuela del alumno por codigo de alumno
    public function buscarEscuelaC(Request $request)
    {
        $var = $request->name;
        $nombresE = DB::select('select escuela.nombre from persona
        left join alumno on persona.codPersona = alumno.idPersona
        left join escuela on escuela.idEscuela = alumno.coEscuela
        where persona.codPersona = alumno.idPersona
        and escuela.idEscuela = alumno.coEscuela
        and alumno.codAlumno=:codAlumno and persona.estado=1 and alumno.estado=1 and escuela.estado =1', ['codAlumno' => $var]);
        foreach ($nombresE as $ne) {
            $escuelan = $ne->nombre;
            return response()->json($escuelan);
        }
    }

    //Ajax autollenado, buscar facultad del alumno por dni
    public function buscarFacultadD(Request $request)
    {
        $var = $request->name;
        $nombresF = DB::select('select facultad.nombre from persona
        left join alumno on persona.codPersona = alumno.idPersona
        left join escuela on escuela.idEscuela = alumno.coEscuela
        left join facultad on facultad.idFacultad = escuela.codigoFacultad
        where persona.codPersona = alumno.idPersona
        and escuela.idEscuela = alumno.coEscuela
        and facultad.idFacultad = escuela.codigoFacultad
        and persona.dni=:dni and persona.estado=1 and alumno.estado=1 and escuela.estado =1 and facultad.estado=1', ['dni' => $var]);
        foreach ($nombresF as $nf) {
            $facultadn = $nf->nombre;
            return response()->json($facultadn);
        }
    }

    //Ajax autollenado, buscar facultad del alumno por codigo de alumno
    public function buscarFacultadC(Request $request)
    {
        $var = $request->name;
        $nombresF = DB::select('select facultad.nombre from persona
        left join alumno on persona.codPersona = alumno.idPersona
        left join escuela on escuela.idEscuela = alumno.coEscuela
        left join facultad on facultad.idFacultad = escuela.codigoFacultad
        where persona.codPersona = alumno.idPersona
        and escuela.idEscuela = alumno.coEscuela
        and facultad.idFacultad = escuela.codigoFacultad
        and alumno.codAlumno=:codAlumno and persona.estado=1 and alumno.estado=1 and escuela.estado =1 and facultad.estado=1', ['codAlumno' => $var]);
        foreach ($nombresF as $nf) {
            $facultadn = $nf->nombre;
            return response()->json($facultadn);
        }
    }

    //Ajax autollenado, buscar precio de la tasa por nombre de tasa
    public function precioSubtramite(Request $request)
    {
        $var = $request->name;
        $precioS = DB::select('select precio from subtramite
        where nombre=:nombre and estado=1', ['nombre' => $var]);
        foreach ($precioS as $ps) {
            $precio = $ps->precio;
            return response()->json($precio);
        }
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
                        if ($request->selected == 'Codigo personal') {//Reporte del reporte diario del personal logueado
                            Excel::create('Laravel Excel', function ($excel) use ($request) {
                                $excel->sheet('Reporte Diario', function ($sheet) use ($request) {
                                    $data = null;
                                    $pag = null;
                                    $total = 0;
                                    $cont = 0;
                                    $pago = new pagomodel();
                                    $pag = $pago->listarPagosPersonal($request->text);//SQL, obtener datos del pago realizado por el personal (diario)

                                    foreach ($pag as $p) {
                                        $total += $p->precio;
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

                                    //$sheet->FromArray($data);
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
                                    //ubicacion de la data
                                    $sheet->fromArray($data, null, 'B7', false);
                                    //nombre de hoja
                                    $sheet->setTitle('Lista de reportes resumido');
                                    //par que la data se ajuste
                                    $sheet->setAutoSize(true);
                                });
                            })->export('xls');
                        } else {
                            if ($request->selected == 'Reporte diario') {
                                $pag = $pago->listarPagosPersonal($request->text);
                            } else {
                                $pag = $pago->consultarPagos($val);
                            }
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
        $valueA = Session::get('tipoCuentaA');
        $valueR = Session::get('tipoCuentaR');
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
        $total = 0;
        $imput = $request->inputTram;
        $lugar = null;
        $codigo = null;
        if (empty($request->sed) != true) {
            if (empty($request->fac) != true) {
                if (empty($request->esc) != true) {
                    $codigo = $esc->obtenerId($request->esc);//SQL, obtener id de la escuela por su nombre
                    $lugar = 'es.idEscuela';
                } else {
                    $codigo = $fac->obtenerId($request->fac);//SQL, obtener id de la facultad por su nombre
                    $lugar = 'fac.idFacultad';
                }
            } else {
                $codigo = $sede->obtenerId($request->sed);//SQL, obtener id de la sede por su nombre
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
        } else {
            $fuenfin = null;
        }
        if (empty($request->tr) != true) {
            $tipRe = $request->tr;
        } else {
            $tipRe = null;
        }

        $result = $pagoModel->listarGeneral($estado, $modalidad, $fechaDesde, $fechaHasta, $tram, $tramites, $tipRe, $fuenfin, $lugar, $codigo);//Listar: pago,personal,subtramite,escuela,facultad
        if (!is_null($result) && empty($result) != true) {
            foreach ($result as $sum) {
                $total = $total + $sum->precio;
            }
        } else {
            $total = 0;
        }
        $cadena = $estado . ';' . $modalidad . ';' . $fechaDesde . ';' . $fechaHasta . ';' . $tram . ';' . $tramites . ';' . $tipRe . ';' . $fuenfin . ';' . $lugar . ';' . $codigo;

        //  $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $cadena, MCRYPT_MODE_CBC, md5(md5($key))));
        if ($valueA == 'Administrador')
            return view('Administrador/Reporte/Report')->with(['result' => $result, 'total' => $total, 'estado' => $estado, 'modalidad' => $modalidad, 'fechaDesde' => $fechaDesde, 'fechaHasta' => $fechaHasta, 'tram' => $tram, 'tramites' => $tramites, 'tipRe' => $tipRe, 'fuenfin' => $fuenfin, 'lugar' => $lugar, 'codigo' => $codigo, 'encript' => $cadena]);

        if ($valueR == 'Reportes')
            return view('Reportes/Reporte/Report')->with(['result' => $result, 'total' => $total, 'estado' => $estado, 'modalidad' => $modalidad, 'fechaDesde' => $fechaDesde, 'fechaHasta' => $fechaHasta, 'tram' => $tram, 'tramites' => $tramites, 'tipRe' => $tipRe, 'fuenfin' => $fuenfin, 'lugar' => $lugar, 'codigo' => $codigo, 'encript' => $cadena]);


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
        return view('/Ventanilla/Pagos/RealizarPago')->with(['buscar' => $buscar, 'total' => $total,
            'nombre' => $nombre, 'apellidos' => $apellidos, 'escuela' => $escuela,
            'facultad' => $facultad, 'detalle' => $detalle, 'fecha' => $fecha]);
    }

    public function  reporteCentrosDeProduccion(Request $request)
    {
        echo 'asdasd';
    }

    //Reporte de pagos, resumen
    public function obtenerPagosresumen(Request $request)
    {

        $valueA = Session::get('tipoCuentaA');
        $valueR = Session::get('tipoCuentaR');
        if ($request->combito !== 'Escojer') {
            $numero = '';
            $result = null;
            $pagoModel = new pagomodel();
            $varOpc = $request->tipreporte;
            $vartiemp = $request->combito;
            $varaño = $request->año1;
            if ($varOpc == 'Resumen total') {//Si se escoge: Resumen total
                $tiempo = null;

                if ($vartiemp == 1) {

                    $tiempo = 'where Year(po.fecha) = ' . $varaño . '';
                    $result = $pagoModel->listarpagosresumen($tiempo);//SQL, obtener pagos por año
                    $numero = $varaño;

                } else {
                    if ($vartiemp == 2) {
                        $tiempo = 'where MONTH(po.fecha) = ' . $request->mes2 . ' and Year(po.fecha)=' . $request->año2 . '';
                        $result = $pagoModel->listarpagosresumen($tiempo);//SQL, obtener pagos por mes
                        $meses = array("ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE");
                        $valor = $meses[$request->mes2 - 1];
                        $numero = 'DE ' . $valor . ' DEL ' . $request->año2;
                    } else {
                        if ($vartiemp == 3) {
                            $originalDate = $request->fecha;
                            $fecha = date("Y-m-d", strtotime($originalDate));
                            $tiempo = 'where DATE(po.fecha) =\'' . $fecha . '\'';
                            $result = $pagoModel->listarpagosresumen($tiempo);//SQL, obtener pagos por fecha
                            $numero = $fecha;
                        }
                    }
                }
                $total = 0;

                foreach ($result as $r) {
                    $total += $r->importe;
                }
                if ($valueA == 'Administrador')
                    return view('Administrador/Reporte/reporteresumido')->with(['resultresu' => $result, 'total' => $total, 'varopc' => $varOpc, 'tiprep' => $vartiemp, 'tiempo' => $tiempo, 'numero' => $numero]);

                if ($valueR == 'Reportes')
                    return view('Reportes/Reporte/reporteresumido')->with(['resultresu' => $result, 'total' => $total, 'varopc' => $varOpc, 'tiprep' => $vartiemp, 'tiempo' => $tiempo, 'numero' => $numero]);

            } elseif ($varOpc == 'Clasificador S.I.A.F') {//Si se escoge Clasificador SIAF

                $tiempo = null;
                if ($vartiemp == 1) {

                    $tiempo = 'where Year(po.fecha) = ' . $varaño . '';
                    $result = $pagoModel->obtenerPagosresumensiaf($tiempo);//SQL, obtener pagos resumidos por año resumido
                    $numero = $varaño;
                } elseif ($vartiemp == 2) {
                    $tiempo = 'where MONTH(po.fecha) = ' . $request->mes2 . ' and Year(po.fecha)=' . $request->año2 . '';
                    $result = $pagoModel->obtenerPagosresumensiaf($tiempo);//SQL, obtener pagos resumidos por mes
                    $meses = array("ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE");
                    $valor = $meses[$request->mes2 - 1];
                    $numero = 'DE ' . $valor . ' DEL ' . $request->año2;

                } elseif ($vartiemp == 3) {
                    $originalDate = $request->fecha;
                    $fecha = date("Y-m-d", strtotime($originalDate));
                    $tiempo = 'where DATE(po.fecha) =\'' . $fecha . '\'';
                    $result = $pagoModel->obtenerPagosresumensiaf($tiempo);//SQL, obtener pagos resumido por fecha
                    $numero = $fecha;
                }
                $total = 0;
                foreach ($result as $r) {
                    $total += $r->precio;
                }
                if ($valueA == 'Administrador')
                    return view('Administrador/Reporte/reporteresumido')->with(['resultsiaf' => $result, 'total' => $total, 'varopc' => $varOpc, 'tiprep' => $vartiemp, 'tiempo' => $tiempo, 'numero' => $numero]);

                if ($valueR == 'Reportes')
                    return view('Reportes/Reporte/reporteresumido')->with(['resultsiaf' => $result, 'total' => $total, 'varopc' => $varOpc, 'tiprep' => $vartiemp, 'tiempo' => $tiempo, 'numero' => $numero]);


            }
        } else {
            if ($valueA == 'Administrador')
                return view('Administrador/Reporte/reporteresumido');
            if ($valueR == 'Reportes')
                return view('Reportes/Reporte/reporteresumido');

        }
    }
}
