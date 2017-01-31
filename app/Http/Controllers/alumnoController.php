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
        $per = $persona->save('alumno', $request->codMatricula);

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

    public function cargarAlumno($codPersona)
    {
        $alumno = new alumnomodel();
        $alu = $alumno->consultarAlumnoid($codPersona);
        return view('Administrador/Alumno/Edit')->with(['alumno' => $alu]);
    }

    public function editarAlumno($codPersona, Request $request)
    {
        $alumno = new alumnomodel();
        $alumno->setDni($request->dni);
        $alumno->setNombres($request->nombres);
        $alumno->setApellidos($request->apellidos);
        $alumno->setCodAlumno($request->codAlumno);
        $alumno->setCodMatricula($request->codMatricula);
        $alumno->setFecha($request->fecha);
        $alumno->editarAlumno($codPersona);
        return view('Administrador/Alumno/Search')->with(['nombre' => $request->nombres]);
    }

    public function listarAlumno(Request $request)
    {
        $alu = null;
        $alumno = new alumnomodel();

        if ($request->select == 'Dni') {
            $alu = $alumno->consultarAlumnoDNI($request->text);
        } else {
            if ($request->select == 'Apellidos') {
                $alu = $alumno->consultarAlumnoApellidos($request->text);
            } else {
                if ($request->select == 'Codigo alumno') {
                    $alu = $alumno->consultarAlumnoCodigo($request->text);
                } else {
                    if ($request->select == 'Codigo Matricula') {
                        $alu = $alumno->consultarAlumnoCodigoMatricula($request->text);
                    } else {
                        if ($request->select == 'Fecha de Matricula') {
                            $alu = $alumno->consultarAlumnoFechaMatricula($request->text);
                        } else {
                            if ($request->select == 'Escuela') {
                                $alu = $alumno->consultarAlumnoEscuela($request->text);
                            } else {
                                if ($request->select == 'Facultad') {
                                    $alu = $alumno->consultarAlumnoFacultad($request->text);
                                }
                            }
                        }
                    }
                }
            }
        }
        return view('Administrador/Alumno/Search')->with(['alumno' => $alu, 'txt' => $request->text, 'select' => $request->select]);
    }
}