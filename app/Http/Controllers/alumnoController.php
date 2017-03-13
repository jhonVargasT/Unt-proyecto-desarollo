<?php

namespace App\Http\Controllers;

use App\alumnomodel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class alumnoController extends Controller
{
    public function registrarAlumno(Request $request)
    {
        $alumno = new alumnomodel();
        $alumno->setDni($request->dni);
        $alumno->setNombres($request->nombres);
        $alumno->setApellidos($request->apellidos);
        $alumno->setCodAlumno($request->codAlumno);
        $alumno->setCodMatricula($request->codMatricula);
        $d = $request->fecha;
        $date = implode("-", array_reverse(explode("/", $d)));
        $alumno->setFecha($date);
        $idE = $alumno->bdEscuela($request->nombreEscuela);
        $alumno->setIdEscuela($idE);
        $al = $alumno->savealumno();

        if ($al == true) {
            return back()->with('true', 'Alumno ' . $request->nombres . ' guardada con exito')->withInput();
        } else {
            return back()->with('false', 'Alumno ' . $request->nombres . ' no guardada, puede que ya exista');
        }
    }

    public function cargarAlumno($codPersona)
    {
        $valueA = Session::get('tipoCuentaA');
        $valueV = Session::get('tipoCuentaV');

        $alumno = new alumnomodel();
        $alu = $alumno->consultarAlumnoid($codPersona);

        if ($valueA == 'Administrador')
            return view('Administrador/Alumno/Edit')->with(['alumno' => $alu]);
        if ($valueV == 'Ventanilla')
            return view('Ventanilla/Alumno/Edit')->with(['alumno' => $alu]);
    }

    public function editarAlumno($codPersona, Request $request)
    {
        $valueA = Session::get('tipoCuentaA');
        $valueV = Session::get('tipoCuentaV');

        $alumno = new alumnomodel();
        $alumno->setDni($request->dni);
        $alumno->setNombres($request->nombres);
        $alumno->setApellidos($request->apellidos);
        $alumno->setCodAlumno($request->codAlumno);
        $alumno->setCodMatricula($request->codMatricula);
        $alumno->setFecha($request->fecha);
        $alumno->editarAlumno($codPersona);

        if ($valueA == 'Administrador')
            return view('Administrador/Alumno/Search')->with(['nombre' => $request->nombres]);
        if ($valueV == 'Ventanilla')
            return view('Ventanilla/Alumno/Search')->with(['nombre' => $request->nombres]);
    }

    public function listarAlumno(Request $request)
    {
        $valueA = Session::get('tipoCuentaA');
        $valueV = Session::get('tipoCuentaV');
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

        if ($valueA == 'Administrador')
            return view('Administrador/Alumno/Search')->with(['alumno' => $alu, 'txt' => $request->text, 'select' => $request->select]);
        if ($valueV == 'Ventanilla')
            return view('Ventanilla/Alumno/Search')->with(['alumno' => $alu, 'txt' => $request->text, 'select' => $request->select]);
    }

    public function eliminarAlumno($codPersona, Request $request)
    {
        $valueA = Session::get('tipoCuentaA');
        $valueV = Session::get('tipoCuentaV');

        $alumno = new alumnomodel();
        $alumno->eliminarAlumno($codPersona);

        if ($valueA == 'Administrador')
            return view('Administrador/Alumno/Search')->with(['nombre' => $request->nombres]);
        if ($valueV == 'Ventanilla')
            return view('Ventanilla/Alumno/Search')->with(['nombre' => $request->nombres]);
    }

    public function escuela(Request $request)
    {
        $data = DB::table('escuela')->select("nombre as name")->where("nombre", "LIKE", "%{$request->input('query')}%")->get();
        return response()->json($data);
    }

    public function facultad(Request $request)
    {
        $nombreE = $request->name;
        $facultadnombre = DB::select('select facultad.nombre from facultad left join escuela on facultad.idFacultad=escuela.codigoFacultad where facultad.idFacultad=escuela.codigoFacultad and escuela.nombre=:nombre', ['nombre' => $nombreE]);

        foreach ($facultadnombre as $fnom) {
            $fn = $fnom->nombre;
            return response()->json($fn);
        }
    }

    public function autoComplete(Request $request)
    {
        $products = DB::select('select escuela.nombre as nombre from escuela
        left join facultad on escuela.codigoFacultad=facultad.idFacultad
        left join sede on facultad.coSede=sede.codSede 
        where escuela.codigoFacultad=facultad.idFacultad and facultad.coSede=sede.codSede and sede.estado=1
        and facultad.estado=1 and escuela.estado=1 and sede.nombresede = "'.$request->sede.'"   and escuela.nombre like "%' . $request->term . '%" ');

        $data = array();
        foreach ($products as $product) {
            $data[] = array('value' => $product->nombre);
        }
        if (count($data))
            return $data;
        else
            return ['value' => 'No se encuentra'];
    }
}