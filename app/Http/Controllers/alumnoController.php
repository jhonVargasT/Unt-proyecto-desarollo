<?php

namespace App\Http\Controllers;

use App\alumnomodel;
use App\personamodel;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;

class alumnoController extends Controller
{
    public function registrarAlumno(Request $request)
    {
        $persona = new personamodel();
        $persona->setDni($request->dni);
        $persona->setNombres($request->nombres);
        $persona->setApellidos($request->apellidos);
        $persona->save();

        $alumno = new alumnomodel();
        $alumno->setCodAlumno($request->codAlumno);
        $alumno->setCodMatricula($request->codMatricula);
        $alumno->setFecha($request->fecha);
        /*$idE = $alumno->bdEscuela('nombre');
        $alumno->setCoEscuela($idE);*/
        $idP = $alumno->bdPersona($request->dni);
        $alumno->setIdPersona($idP);
        $al = $alumno->save();

        if ($al != null) {
            return view('Administrador/Alumno/Add');
        } else {
            return view('Administrador/Alumno/Add');
        }
    }

    /*public function llenar(Request $request)
    {
        $bsc= $request->bscAlumno;
        $da= $request->datoAlumno;
        $alumno = new alumnomodel();
        $dato = $alumno->consultarAlumnos($bsc,$da);


    }*/


    public function buscarAlumnoxDni(Request $request)
    {

        $alumno = new alumnomodel();
        $array = $alumno->consultarAlumnoPorDni();

        return $array;
    }



    public function buscarAlumno(Request $request)
    {
        $datos = $request->datos;
        $alumno = new alumnomodel();
        $alumno->consultarAlumnos($datos);

        return view('Administrador/Alumno/Search');
    }

    public function autocomplete(Request $request)
    {
        $data = DB::table('persona')->select("nombres as name")->where("nombres", "LIKE", "%{$request->input('query')}%")->get();

        return response()->json($data);
    }
}

