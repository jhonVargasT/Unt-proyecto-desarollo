<?php

namespace App\Http\Controllers;

use App\alumnomodel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class alumnoController extends Controller
{
    //Registra al alumno y redirecciona a la pagina de registro
    public function registrarAlumno(Request $request)
    {
        $alumno = new alumnomodel();
        $alumno->setDni($request->dni);
        $alumno->setNombres($request->nombres);
        $alumno->setApellidos($request->apellidos);
        $alumno->setCodAlumno($request->codAlumno);
        $alumno->setCorreo($request->correo);
        //$date = implode("-", array_reverse(explode("/", $request->fecha)));
        $alumno->setFecha($request->fecha);
        $idE = $alumno->bdEscuela($request->nombreEscuela);//Consular el id de la escuela a la que va a pertenecer
        $alumno->setIdEscuela($idE);
        $al = $alumno->savealumno($request->dni);//Metodo de insercion en la bd al alumno (persona y alumno)

        if ($al == true) {
            return back()->with('true', 'Alumno ' . $request->nombres . ' guardada con exito')->withInput();
        } else {
            return back()->with('false', 'Alumno ' . $request->nombres . ' no se guardado');
        }
    }

    public function registrarAlumnoProduccion(Request $request)
    {
        $alumno = new alumnomodel();
        $alumno->setDni($request->dni);
        $alumno->setNombres($request->nombres);
        $alumno->setApellidos($request->apellidos);
        $alumno->setCodAlumno($request->codAlumno);
        $alumno->setCorreo($request->correo);
        //$date = implode("-", array_reverse(explode("/", $request->fecha)));
        $alumno->setFecha($request->fecha);
        $codProduccion = $alumno->bdProduccion($request->produccion);
        $alumno->setCodProduccion($codProduccion);
        $al = $alumno->savealumnoProduccion($request->dni);//Metodo de insercion en la bd al alumno (persona y alumno)

        if ($al == true) {
            return back()->with('true', 'Alumno ' . $request->nombres . ' guardada con exito')->withInput();
        } else {
            return back()->with('false', 'Alumno ' . $request->nombres . ' no se guardado');
        }
    }


    //Carga todos los datos del alumno para editar sus datos y redirecciona a Ventanilla/Alumno/Edit
    public function cargarAlumno($codPersona)
    {
        $valueA = Session::get('tipoCuentaA');
        $valueV = Session::get('tipoCuentaV');

        $alumno = new alumnomodel();
        $alu = $alumno->consultarAlumnoid($codPersona);//Obtiene los datos del alumno por su codigo de persona

        if ($valueA == 'Administrador')
            return view('Administrador/Alumno/Edit')->with(['alumno' => $alu]);
        if ($valueV == 'Ventanilla')
            return view('Ventanilla/Alumno/Edit')->with(['alumno' => $alu]);
    }

    public function cargarAlumnoP($codPersona, $codProduccion)
    {
        $valueA = Session::get('tipoCuentaA');
        $valueV = Session::get('tipoCuentaV');

        $alumno = new alumnomodel();
        $alu = $alumno->consultarAlumnoidP($codPersona, $codProduccion);//Obtiene los datos del alumno por su codigo de persona

        if ($valueA == 'Administrador')
            return view('Administrador/Alumno/EditP')->with(['alumno' => $alu]);
        if ($valueV == 'Ventanilla')
            return view('Ventanilla/Alumno/EditP')->with(['alumno' => $alu]);
    }

    //Edita los datos de los alumnos y redirecciona a Alumno/Search
    public function editarAlumno($codPersona, Request $request)
    {
        $valueA = Session::get('tipoCuentaA');
        $valueV = Session::get('tipoCuentaV');
        $alumno = new alumnomodel();
        $alumno->setDni($request->dni);
        $alumno->setNombres($request->nombres);
        $alumno->setApellidos($request->apellidos);
        $alumno->setCodAlumno($request->codAlumno);
        $alumno->setCorreo($request->correo);
        //$date = implode("-", array_reverse(explode("/", $request->fecha)));
        $alumno->setFecha($request->fecha);
        $idE = $alumno->bdEscuela($request->nombreEscuela);//Consular el id de la escuela a la que va a pertenecer
        $alumno->setIdEscuela($idE);
        $alumno->editarAlumno($codPersona);//Ejecuta la consulta de actualizar los datos del alumno

        if ($valueA == 'Administrador')
            return view('Administrador/Alumno/Search')->with(['nombre' => $request->nombres]);
        if ($valueV == 'Ventanilla')
            return view('Ventanilla/Alumno/Search')->with(['nombre' => $request->nombres]);
    }

    public function editarAlumnoP($codPersona, Request $request)
    {
        $valueA = Session::get('tipoCuentaA');
        $valueV = Session::get('tipoCuentaV');
        $alumno = new alumnomodel();
        $alumno->setDni($request->dni);
        $alumno->setNombres($request->nombres);
        $alumno->setApellidos($request->apellidos);
        $alumno->setCodAlumno($request->codAlumno);
        $alumno->setCorreo($request->correo);
        //$date = implode("-", array_reverse(explode("/", $request->fecha)));
        $alumno->setFecha($request->fecha);
        $codProduccion = $alumno->bdProduccion($request->produccion);
        $alumno->setCodProduccion($codProduccion);
        $alumno->editarAlumnoP($codPersona);//Ejecuta la consulta de actualizar los datos del alumno

        if ($valueA == 'Administrador')
            return view('Administrador/Alumno/Search')->with(['nombre' => $request->nombres]);
        if ($valueV == 'Ventanilla')
            return view('Ventanilla/Alumno/Search')->with(['nombre' => $request->nombres]);
    }

    //Busqueda de alumnos y redireccionar Alumno/Search
    public function listarAlumno(Request $request)
    {
        $valueA = Session::get('tipoCuentaA');
        $valueV = Session::get('tipoCuentaV');
        $valueR = Session::get('tipoCuentaR');

        $alu = null;
        $alumno = new alumnomodel();

        if ($request->select == 'Dni') {
            $alu = $alumno->consultarAlumnoDNI($request->text);//Consulta buscar alumnos o clientse mediante su dni
        } else {
            if ($request->select == 'Apellidos') {
                $alu = $alumno->consultarPersonaApellidos($request->text);//Consulta buscar alumnos o clientes mediante sus apellidos
            } else {
                if ($request->select == 'Codigo alumno') {
                    $alu = $alumno->consultarAlumnoCodigo($request->text);//Consulta buscar alumnos por su codigo de alumno
                } else {
                    if ($request->select == 'Escuela') {
                        $alu = $alumno->consultarAlumnoEscuela($request->text);//Consulta buscar alumnos por la escuela a la que pertenece
                    } else {
                        if ($request->select == 'Facultad') {
                            $alu = $alumno->consultarAlumnoFacultad($request->text);//Consulta buscar alumnos por la facultad a la que pertenece
                        }
                    }
                }
            }
        }
        if ($valueA == 'Administrador')
            return view('Administrador/Alumno/Search')->with(['alumno' => $alu, 'txt' => $request->text, 'select' => $request->select]);
        if ($valueV == 'Ventanilla')
            return view('Ventanilla/Alumno/Search')->with(['alumno' => $alu, 'txt' => $request->text, 'select' => $request->select]);
        if ($valueR == 'Reportes')
            return view('Reportes/Alumno/Search')->with(['alumno' => $alu, 'txt' => $request->text, 'select' => $request->select]);
    }

    public function listarAlumnoP(Request $request)
    {
        $valueA = Session::get('tipoCuentaA');
        $valueV = Session::get('tipoCuentaV');
        $valueR = Session::get('tipoCuentaR');

        $alu = null;
        $alumno = new alumnomodel();

        if ($request->select == 'Dni') {
            $alu = $alumno->consultarAlumnoDNIP($request->text);//Consulta buscar alumnos o clientse mediante su dni
        } else {
            if ($request->select == 'Apellidos') {
                $alu = $alumno->consultarPersonaApellidosP($request->text);//Consulta buscar alumnos o clientes mediante sus apellidos
            } else {
                if ($request->select == 'Codigo alumno') {
                    $alu = $alumno->consultarAlumnoCodigoP($request->text);//Consulta buscar alumnos por su codigo de alumno
                } else {
                    if ($request->select == 'Centro produccion') {
                        $alu = $alumno->consultarAlumnoProduccionP($request->text);//Consulta buscar alumnos por la escuela a la que pertenece
                    }
                }
            }
        }
        if ($valueA == 'Administrador')
            return view('Administrador/Alumno/SearchP')->with(['alumno' => $alu, 'txt' => $request->text, 'select' => $request->select]);
        if ($valueV == 'Ventanilla')
            return view('Ventanilla/Alumno/SearchP')->with(['alumno' => $alu, 'txt' => $request->text, 'select' => $request->select]);
        if ($valueR == 'Reportes')
            return view('Reportes/Alumno/SearchP')->with(['alumno' => $alu, 'txt' => $request->text, 'select' => $request->select]);
    }

    //Elimina (cambia de estado 1 a 0) al alumno regresando a la view donde esta. Cambia de estado a la persona y alumno.
    public function eliminarAlumno($codPersona, Request $request)
    {
        $valueA = Session::get('tipoCuentaA');
        $valueV = Session::get('tipoCuentaV');

        $alumno = new alumnomodel();
        $val = $alumno->eliminarAlumno($codPersona);//Sentencia SQL que elimina al alumno

        if ($valueA == 'Administrador') {
            if ($val == true) {
                return back()->with('true', 'Alumno ' . $request->nombres . ' eliminada con exito')->withInput();
            } else {
                return back()->with('false', 'Alumno ' . $request->nombres . ' no se elimino')->withInput();
            }
        } else {
            if ($valueV == 'Ventanilla') {
                if ($val == true) {
                    return back()->with('true', 'Alumno ' . $request->nombres . ' eliminada con exito')->withInput();
                } else {
                    return back()->with('false', 'Alumno ' . $request->nombres . ' no se elimino')->withInput();
                }
            }
        }
    }

    public function eliminarAlumnoP($codPersona, Request $request)
    {
        $valueA = Session::get('tipoCuentaA');
        $valueV = Session::get('tipoCuentaV');

        $alumno = new alumnomodel();
        $val = $alumno->eliminarAlumnoP($codPersona);//Sentencia SQL que elimina al alumno

        if ($valueA == 'Administrador') {
            if ($val == true) {
                return back()->with('true', 'Alumno ' . $request->nombres . ' eliminada con exito')->withInput();
            } else {
                return back()->with('false', 'Alumno ' . $request->nombres . ' no se elimino')->withInput();
            }
        } else {
            if ($valueV == 'Ventanilla') {
                if ($val == true) {
                    return back()->with('true', 'Alumno ' . $request->nombres . ' eliminada con exito')->withInput();
                } else {
                    return back()->with('false', 'Alumno ' . $request->nombres . ' no se elimino')->withInput();
                }
            }
        }
    }

    //Typeahead(autollenado) - Javascript busca todos los nombres de las escuelas
    public function escuela(Request $request)
    {
        $data = DB::table('escuela')->select("nombre as name")->where("nombre", "LIKE", "%{$request->input('query')}%")->get();
        return response()->json($data);
    }

    //Ajax para autollenado del nombre de la facultad con el nombre de la escuela
    public function facultad(Request $request)
    {
        $nombreE = $request->name;
        $facultadnombre = DB::select('select facultad.nombre from facultad left join escuela on facultad.idFacultad=escuela.codigoFacultad where facultad.idFacultad=escuela.codigoFacultad and escuela.nombre=:nombre', ['nombre' => $nombreE]);

        foreach ($facultadnombre as $fnom) {
            $fn = $fnom->nombre;
            return response()->json($fn);
        }
    }

    //Ajax para el autollenado del nombre de la escuela escogiendo el nombre de la sede a la que pertence dicha escuela
    public function autoComplete(Request $request)
    {
        $products = DB::select('select escuela.nombre as nombre from escuela
        left join facultad on escuela.codigoFacultad=facultad.idFacultad
        left join sede on facultad.coSede=sede.codSede 
        where escuela.codigoFacultad=facultad.idFacultad and facultad.coSede=sede.codSede and sede.estado=1
        and facultad.estado=1 and escuela.estado=1 and sede.nombresede = "' . $request->sede . '"   and escuela.nombre like "%' . $request->term . '%" ');
        $data = array();
        foreach ($products as $product) {
            $data[] = array('value' => $product->nombre);
        }
        if (count($data))
            return $data;
        else
            return ['value' => 'No se encuentra'];
    }

    public function buscarAlumno(Request $request)
    {
        $dato = array();
        $products = DB::select('select * from alumno left join persona on alumno.idPersona = persona.codPersona where dni = ' . $request->dni . ' ');

        foreach ($products as $n) {
            $dato[0] = $n->nombres;
            $dato[1] = $n->apellidos;
            $dato[2] = $n->correo;
            $dato[3] = $n->codAlumno;
            $dato[4] = $n->fecha;

            return response()->json($dato);
        }
    }
}