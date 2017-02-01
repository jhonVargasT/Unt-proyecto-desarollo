<?php

namespace App;

use Illuminate\Support\Facades\DB;
use PDOException;

class alumnomodel extends personamodel
{
    private $codAlumno;
    private $codMatricula;
    private $fecha;
    private $idPersona;

    function __construct()
    {
        parent::__construct();

    }

    /**
     * @return mixed
     */
    public function getCodAlumno()
    {
        return $this->codAlumno;
    }

    /**
     * @param mixed $codAlumno
     * @return alumnomodel
     */
    public function setCodAlumno($codAlumno)
    {
        $this->codAlumno = $codAlumno;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodMatricula()
    {
        return $this->codMatricula;
    }

    /**
     * @param mixed $codMatricula
     * @return alumnomodel
     */
    public function setCodMatricula($codMatricula)
    {
        $this->codMatricula = $codMatricula;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     * @return alumnomodel
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdPersona()
    {
        return $this->idPersona;
    }

    /**
     * @param mixed $idPersona
     * @return alumnomodel
     */
    public function setIdPersona($idPersona)
    {
        $this->idPersona = $idPersona;
        return $this;
    }

    public function bdEscuela($nombre)
    {
        $escuela = DB::select('select idEscuela from escuela where nombre=:nombre', ['nombre' => $nombre]);

        foreach ($escuela as $es) {
            return $e = $es->idEscuela;
        }
    }

    public function bdPersona($dni)
    {
        $persona = DB::select('select codPersona from persona where dni=:dni', ['dni' => $dni]);

        foreach ($persona as $pers) {
            return $per = $pers->codPersona;
        }
    }

    public function consultarAlumnoPorDni()
    {

        $alumnos = DB::select('select * from persona left join alumno on persona.codPersona = alumno.idPersona where persona.dni=dni', ['dni' => $this->getDni()]);

        return $alumnos;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function consultarAlumnos()
    {
        $alumnos = DB::select('select * from persona left join alumno on persona.codPersona = alumno.idPersona where persona.codPersona= alumno.idPersona 
                               and persona.dni =123 or persona.nombres=123 or persona.apellidos=123 or alumno.codAlumno=123 or alumno.codMatricula=123');
        return $alumnos;
    }

    public function savealumno()
    {
        try {
            DB::transaction(function () {
                DB::table('persona')->insert(['dni' => $this->getDni(), 'nombres' => $this->getNombres(), 'apellidos' => $this->getApellidos()]);
                DB::table('alumno')->insert(['codAlumno' => $this->codAlumno, 'codMatricula' => $this->codMatricula, 'fecha' => $this->fecha, 'idPersona' => $this->idPersona]);
            });
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function editarAlumno($codPersona)
    {
        DB::table('persona')->where('codPersona', $codPersona)->update(['dni' => $this->getDni(), 'nombres' => $this->getNombres(), 'apellidos' => $this->getApellidos()]);
        DB::table('alumno')->where('idPersona', $codPersona)->update(['codAlumno' => $this->codAlumno, 'codMatricula' => $this->codMatricula, 'fecha' => $this->fecha]);
    }

    public function consultarAlumnoDNI($dni)
    {
        $alumnobd = DB::select('select * from persona left join alumno on persona.codPersona = alumno.idPersona where 
        persona.codPersona = alumno.idPersona and persona.dni=:dni and persona.estado = 1 and alumno.estado=1', ['dni' => $dni]);
        return $alumnobd;
    }

    public function consultarAlumnoApellidos($apellidos)
    {
        $alumnobd = DB::select('select * from persona left join alumno on persona.codPersona = alumno.idPersona where 
        persona.codPersona = alumno.idPersona and persona.apellidos=:apellidos and persona.estado = 1 and alumno.estado=1', ['apellidos' => $apellidos]);
        return $alumnobd;
    }

    public function consultarAlumnoCodigo($codAlumno)
    {
        $alumnobd = DB::table('persona')->leftJoin('alumno', 'persona.codPersona', '=', 'alumno.idPersona')->where('alumno.codAlumno', '=', $codAlumno)
            ->where('persona.estado', '=', 1)->orderBy('persona.codPersona', 'desc')->get();
        return $alumnobd;
    }

    public function consultarAlumnoCodigoMatricula($codMatricula)
    {
        $alumnobd = DB::table('persona')->leftJoin('alumno', 'persona.codPersona', '=', 'alumno.idPersona')
            ->where('alumno.codMatricula', '=', $codMatricula)
            ->where('persona.estado', '=', 1)->orderBy('persona.codPersona', 'desc')->get();
        return $alumnobd;
    }

    public function consultarAlumnoFechaMatricula($fecha)
    {
        $alumnobd = DB::table('persona')->leftJoin('alumno', 'persona.codPersona', '=', 'alumno.idPersona')
            ->where('alumno.fecha', '=', $fecha)
            ->where('persona.estado', '=', 1)->orderBy('persona.codPersona', 'desc')->get();
        return $alumnobd;
    }

    public function consultarAlumnoEscuela($nombreEscuela)
    {
        $alumnobd = DB::select('select * from persona 
        left join alumno on persona.codPersona = alumno.idPersona 
        left join escuela on escuela.idEscuela = alumno.coEscuela 
        where persona.codPersona = alumno.idPersona 
        and escuela.idEscuela = alumno.coEscuela 
        and escuela.nombre=:nombre
        and persona.estado = 1', ['nombre' => $nombreEscuela]);
        return $alumnobd;
    }

    public function consultarAlumnoFacultad($nombreFacultad)
    {
        $alumnobd = DB::select('select * from persona 
        left join alumno on persona.codPersona = alumno.idPersona 
        left join escuela on escuela.idEscuela = alumno.coEscuela 
        left join facultad on facultad.idFacultad = escuela.codigoFacultad 
        where persona.codPersona = alumno.idPersona 
        and escuela.idEscuela = alumno.coEscuela 
        and facultad.idFacultad = escuela.codigoFacultad
        and facultad.nombre=:nombre
        and persona.estado=1', ['nombre' => $nombreFacultad]);
        return $alumnobd;
    }

    public function consultarAlumnoid($codPersona)
    {
        $alumnobd = DB::select('select * from persona left join alumno on persona.codPersona = alumno.idPersona where 
        persona.codPersona = alumno.idPersona and persona.codPersona=:codPersona', ['codPersona' => $codPersona]);
        return $alumnobd;
    }

    public function eliminarAlumno($codPersona)
    {
        DB::table('persona')->where('codPersona', $codPersona)->update(['estado' => 0]);
        DB::table('alumno')->where('idPersona', $codPersona)->update(['estado' => 0]);
    }
}
