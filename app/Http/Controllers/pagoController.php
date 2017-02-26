<?php

namespace App\Http\Controllers;

use App\alumnomodel;
use App\clientemodel;
use App\pagomodel;
use App\personamodel;
use App\subtramitemodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
        date_default_timezone_set('America/Lima');
        $dato = date('Y-m-d ');
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
        $valid = $p->savePago();
        $buscar = $request->text;
        $val = Session::get('txt', 'No existe session');
        if ($valid == true) {
            if ($val == $request->text) {
                $totalp = $total + $pago;
                session()->put('text', $request->text);
                return view('/Ventanilla/Pagos/RealizarPago')->with(['buscar' => $buscar, 'total' => $totalp, 'nombre' => $request->nombres, 'apellidos' => $request->apellidos, 'escuela' => $request->escuela, 'facultad' => $request->facultad]);
            } else {
                Session::forget('txt');
                Session::put('txt', $request->text);
                return view('/Ventanilla/Pagos/RealizarPago')->with(['buscar' => $buscar, 'total' => $total, 'nombre' => $request->nombres, 'apellidos' => $request->apellidos, 'escuela' => $request->escuela, 'facultad' => $request->facultad]);
            }
        } else {
            return back()->with('false', 'Error cliente o alumno no registrador');
        }
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
        $total = 0;
        $pag = null;
        $pago = new pagomodel();

        if ($request->select == 'Dni') {
            $pag = $pago->consultarAlumnoDNI($request->text);
        } else {
            if ($request->select == 'Codigo alumno') {
                $pag = $pago->consultarAlumnoCodigo($request->text);
            } else {
                if ($request->select == 'Ruc') {
                    $pag = $pago->consultarClienteRuc($request->text);
                } else {
                    if ($request->select == 'Codigo pago') {
                        $pag = $pago->consultarCodigoPago($request->text);
                    } else {
                        if ($request->select == 'Codigo personal') {
                            $pag = $pago->consultarCodigoPersonal($request->text);
                        }
                    }
                }
            }
        }

        foreach ($pag as $p) {
            $total = $total + $p->precio;
        }

        return view('Ventanilla/Pagos/ReportPago')->with(['pago' => $pag, 'txt' => $request->text, 'select' => $request->select, 'total' => $total]);
    }


    public function eliminarPago($codPago)
    {
        $pago = new pagomodel();
        $pago->eliminarPago($codPago);

        return view('Ventanilla/Pagos/ReportPago');
    }

    public function reportePagos(Request $request)
    {
        $pagoModel = new pagomodel();
        $estado = $request->estado;
        $modalidad = $request->modalidad;

        $fechaDesde = $request->fechaDesde; // El formato que te entrega MySQL es Y-m-d
        $fechaDesde = date("Y-m-d", strtotime($fechaDesde));
        $fechaHasta = $request->fechaHasta; // El formato que te entrega MySQL es Y-m-d
         $fechaHasta = date("Y-m-d", strtotime($fechaHasta));
         $result=$pagoModel->listarPagosfacultad($estado,$modalidad,$fechaDesde,$fechaHasta,null,null);
        foreach ($result as $res)
        {
            echo 'codPago'. $res->codPago.'fecha'.$res->fechaPago;
            echo '<br>';
        }
       // return view('Administrador/Reporte/report')->with('result',$result);*/

    }

}
