<?php

namespace App\Http\Controllers;

use App\pagomodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class pagoController extends Controller
{
    public function registrarPago(Request $request)
    {
        $var = null;
        $pago = new pagomodel();
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

        $pago->setIdPersona($var);
        $idtr = $pago->bdSubtramite($request->subtramite);
        $pago->setIdSubtramite($idtr);
        $pago->setPago($request->totalpagar);

        if($request->agregrar)
        {

        }else{
            $pag = $pago->savePago();

            if ($pag == true) {
                return back()->with('true', 'Cliente ' . $request->nombres . ' guardada con exito')->withInput();
            } else {
                return back()->with('false', 'Cliente ' . $request->nombres . ' no guardada, puede que ya exista');
            }
        }
    }

    public function buscarNombresD(Request $request)
    {
        $var = $request->name;
        $nombres = DB::select('select * from persona left join alumno on persona.codPersona = alumno.idPersona 
        where persona.codPersona = alumno.idPersona and persona.dni=:dni and persona.estado=1 and alumno.estado=1', ['dni' => $var]);

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

}
