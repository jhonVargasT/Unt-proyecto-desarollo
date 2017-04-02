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
use PhpParser\Node\Expr\Empty_;

class pagoController extends Controller
{
    public function registrarPago(Request $request)
    {
        $pers = new personamodel();
        $cli = new clientemodel();
        $al = new alumnomodel();
        $subt = new subtramitemodel();
        $codper = null;
        $codSubtramite = null;
        if ($request->select == 'Dni') {
            $codper = $pers->obtnerIdDni($request->text);
        } else {
            if ($request->select == 'Ruc') {
                $codper = $cli->consultarClienteRUC($request->text);
            } else {
                if ($request->select == 'Codigo de alumno') {
                    $codper = $al->consultaridPersonaAlumno($request->text);
                }
            }
        }
        $codSubtramite = $subt->consultarSubtramiteidNombre($request->subtramite);
        $csiaf = $subt->consultarSiafNombreSubtramite($request->subtramite);
        $cuentaS = $subt->consultarCuentaSubtramiteCodSubtramite($codSubtramite);
        date_default_timezone_set('America/Lima');
        $dato = date('Y-m-d H:i:s');
        $total = $request->total;
        $pago = $request->boletapagar;
        $p = new pagomodel();
        $p->setDetalle($request->detalle);
        $p->setFecha($dato);
        $p->setModalidad('ventanilla');
        $idper = Session::get('idpersonal', 'No existe session');
        $p->setCoPersonal($idper);
        $p->setIdPersona($codper);
        $p->setIdSubtramite($codSubtramite);
        $cont = $this->contadorSubtramite($request->subtramite);
        $contaux = $cont + 1;
        if ($request->checkbox == 1) {
            $p->setDeuda(1);
        }
        $valid = $p->savePago($contaux);
        $contador = $cuentaS . '-' . $contaux;
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

    public function contadorSubtramite($nombreSubtramite)
    {
        $cont = null;
        $contador = DB::select('select contador from subtramite where subtramite.estado=1 and subtramite.nombre="' . $nombreSubtramite . '"');

        foreach ($contador as $c) {
            $cont = $c->contador;
        }
        return $cont;
    }

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

    public function autocompletes(Request $request)
    {
        $data = DB::table('subtramite')->select("nombre as name")->where("nombre", "LIKE", "%{$request->input('query')}%")->get();

        return response()->json($data);
    }

    public function listarPago(Request $request)
    {
        $val = 0;
        $total = 0;
        $pag = null;
        $pago = new pagomodel();

        if ($request->checkbox == 1) {
            $val = 1;
        }
        if ($request->selected == 'Dni') {
            $pag = $pago->consultarAlumnoDNI($request->text, $val);
        } else {
            if ($request->selected == 'Codigo alumno') {
                $pag = $pago->consultarAlumnoCodigo($request->text, $val);
            } else {
                if ($request->selected == 'Ruc') {
                    $pag = $pago->consultarClienteRuc($request->text, $val);
                } else {
                    if ($request->selected == 'Codigo pago') {
                        $pag = $pago->consultarCodigoPago($request->text, $val);
                    } else {
                        if ($request->selected == 'Codigo personal') {
                            $pag = $pago->consultarCodigoPersonal($request->text);
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
        return view('Ventanilla/Pagos/ReportPago')->with(['pagos' => $pag, 'txt' => $request->text, 'select' => $request->selected, 'total' => $total]);
    }

    public function eliminarPago($codPago)
    {
        $pago = new pagomodel();
        $pago->eliminarPago($codPago);

        return view('Ventanilla/Pagos/ReportPago');
    }

    public function eliminarDeuda($codPago)
    {
        $pago = new pagomodel();
        $pago->eliminarDeuda($codPago);

        return view('Ventanilla/Pagos/ReportPago');
    }

    public function reportePagos(Request $request)
    {
        $sede = new sedemodel();
        $fac = new facultadmodel();
        $esc = new escuelamodel();
        $subTramiteModel = new subtramitemodel();
        $pagoModel = new pagomodel();
        $tramiteModel = new  tramitemodel();
        $fechaDesde = $request->fechaDesde; // El formato que te entrega MySQL es Y-m-d
        $fechaDesde = date("Y-m-d H:i:s", strtotime($fechaDesde));
        $fechaHasta = $request->fechaHasta; // El formato que te entrega MySQL es Y-m-d
        $fechaHasta = date("Y-m-d H:i:s", strtotime($fechaHasta));
        $estado = $request->estado;
        $modalidad = $request->modalidad;
        $total = 0;
        $imput = $request->inputTram;
        $lugar = null;
        $codigo = null;
        if (empty($request->sed) != true) {
            if (empty($request->fac) != true) {
                if (empty($request->esc) != true) {

                    $codigo = $esc->obtenerId($request->esc);
                    $lugar = 'es.idEscuela';
                } else {
                    $codigo = $fac->obtenerId($request->fac);
                    $lugar = 'fac.idFacultad';
                }
            } else {
                $codigo = $sede->obtenerId($request->sed);
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
        if ($request->opcTramite == 'Tramite') {
            $tramites = $tramiteModel->consultarId($imput);
            $tram = 'tr.codTramite';
        } else {
            if ($request->opcTramite == 'SubTramite') {
                $tramites = $subTramiteModel->consultarId($imput);
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

        $result = $pagoModel->listarGeneral($estado, $modalidad, $fechaDesde, $fechaHasta, $tram, $tramites, $tipRe, $fuenfin, $lugar, $codigo);
        if (!is_null($result) && empty($result) != true) {
            foreach ($result as $sum) {
                $total = $total + $sum->precio;

            }
        } else {
            $total = 0;
        }

        return view('Administrador/Reporte/Report')->with(['result' => $result, 'total' => $total, 'Tram' => $request->inputTram, 'sede' => $request->sed, 'fac' => $request->fac, 'esc' => $request->esc, 'tramite' => $request->opcTramite,]);
    }


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

    public function obtenerPagosresumen(Request $request)
    {
        $pagoModel = new pagomodel();

        if ($request->tipreporte == 'Resumen total') {

            $tiempo = null;
            if ($request->tiempo == 'Año') {
                $tiempo = 'where Year(po.fecha) = ' . $request->fecha . '';
                $result = $pagoModel->listarpagosresumen($tiempo);
            } elseif ($request->tiempo == 'Mes') {
                $tiempo = 'where MONTH(po.fecha) = ' . $request->fecha . ' and Year(po.fecha)=(select Year (NOW()))';
                $result = $pagoModel->listarpagosresumen($tiempo);
            } elseif ($request->tiempo == 'Dia') {
                $tiempo = 'where DAY(po.fecha) =' . $request->fecha . ' and Month(po.fecha)=(select MONTH (NOW()))';
                $result = $pagoModel->listarpagosresumen($tiempo);
            }
            $total = 0;
            foreach ($result as $r) {
                $total += $r->importe;
            }
            return view('Administrador/Reporte/reporteresumido')->with(['resultresu' => $result, 'fecha' => $request->fecha, 'total' => $total]);
        } elseif ($request->tipreporte == 'Codigo S.I.A.F') {

            $tiempo = null;
            if ($request->tiempo == 'Año') {
                $tiempo = 'where Year(po.fecha) = ' . $request->fecha . '';
                $result = $pagoModel->obtenerPagosresumensiaf($tiempo);
            } elseif ($request->tiempo == 'Mes') {
                $tiempo = 'where MONTH(po.fecha) = ' . $request->fecha . ' and Year(po.fecha)=(select Year (NOW()))';
                $result = $pagoModel->obtenerPagosresumensiaf($tiempo);
            } elseif ($request->tiempo == 'Dia') {
                $tiempo = 'where DAY(po.fecha) =' . $request->fecha . ' and Month(po.fecha)=(select MONTH (NOW()))';
                $result = $pagoModel->obtenerPagosresumensiaf($tiempo);
            }
            $total = 0;
            foreach ($result as $r) {
                $total += $r->precio;
            }
            return view('Administrador/Reporte/reporteresumido')->with(['resultsiaf' => $result, 'fecha' => $request->fecha, 'total' => $total]);
        }
       


    }

    //macartur
    public function obtenerPagosDiariosPersonal()
    {
        $pagoModel = new pagomodel();
        $result = $pagoModel->listarPagosPersonal(null, null);
    }
}
