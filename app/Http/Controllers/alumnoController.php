<?php

namespace App\Http\Controllers;

use App\alumnomodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class alumnoController extends Controller
{
    public function registrarAlumno(Request $request)
    {
        Session::put('personalC', 'asd');
        $alumno = new alumnomodel();
        $alumno->setDni($request->dni);
        $alumno->setNombres($request->nombres);
        $alumno->setApellidos($request->apellidos);
        $alumno->setCodAlumno($request->codAlumno);
        $alumno->setCodMatricula($request->codMatricula);
        $alumno->setFecha($request->fecha);
        $al = $alumno->savealumno();
        if ($al == true) {
            return back()->with('true', 'Alumno ' . $request->nombres . ' guardada con exito')->withInput();
        } else {
            return back()->with('false', 'Alumno ' . $request->nombres . ' no guardada, puede que ya exista');
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
        Session::put('personalC', 'asd');
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

    public function eliminarAlumno($codPersona, Request $request)
    {
        $alumno = new alumnomodel();
        $alumno->eliminarAlumno($codPersona);
        return view('Administrador/Alumno/Search')->with(['nombre' => $request->nombres]);
    }
}