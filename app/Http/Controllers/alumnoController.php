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
        $per = $persona->save('alumno',$request->codMatricula);

        $alumno = new alumnomodel();
        $alumno->setCodAlumno($request->codAlumno);
        $alumno->setCodMatricula($request->codMatricula);
        $alumno->setFecha($request->fecha);
        $idP = $alumno->bdPersona($request->dni);
        $alumno->setIdPersona($idP);
        $al = $alumno->savealumno();

        if ($per && $al == true) {
            return view('Administrador/Alumno/Add');
        } else {
            return view('Administrador/Alumno/Add');
        }
    }
}