<?php

namespace App\Http\Controllers;

use App\pagomodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class pagoController extends Controller
{
    public function registrarPago(Request $request)

    {
        $pago= new pagomodel();
        $val = Session::get('txt', 'no hay session');
        if ($val == $request->text) {
            $pago->setLugar($request->lugar);
            $pago->setDetalle($request->detalle);
            date_default_timezone_set('Etc/GMT+5');
            $date = date('Y-d-m H:i:s', time());
            $pago->setFecha($date);
            if ($request->select == 'Dni') {
                $var = $pago->bdPersonaDni($request->text);
            } elseif ($request->select == 'Ruc') {
                $var = $pago->bdPersonaRuc($request->text);
            } elseif ($request->select == 'Codigo de alumno') {
                $var = $pago->bdPersonaCodigoAlumno($request->text);
            }
            $total = $request->total;
            $pago = $request->boletapagar;
            $totalp = $total + $pago;
           $pago->setIdPersona($var);$idtr = $pago->bdSubtramite($request->subtramite);
            $pago->setIdSubtramite($idtr);
            $pago->setPago($total);
            session()->put('text', $request->text);
            $pag = $pago->savePago();
            return view('/Ventanilla/Pagos/RealizarPago')->with('total', $totalp);
        } else {

            Session::forget('txt');
            Session::put('txt', $request->text);
            $total = $request->boletapagar;
            return view('/Ventanilla/Pagos/RealizarPago')->with('total', $total);
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
                    }
                }
            }
        }
        return view('Ventanilla/Pagos/ReportPago')->with(['pago' => $pag, 'txt' => $request->text, 'select' => $request->select]);
    }

    public function eliminarPago($codPago)
    {
        $pago = new pagomodel();
        $pago->eliminarPago($codPago);

        return view('Ventanilla/Pagos/ReportPago');
    }

}
