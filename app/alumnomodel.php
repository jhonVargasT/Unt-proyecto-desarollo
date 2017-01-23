<?php

namespace App;

use Illuminate\Support\Facades\DB;

class alumnomodel extends personamodel
{
    private $codAlumno;
    private $codMatricula;
    private $fecha;
    private $idPersona;
    private $coEscuela;


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

    /**
     * @return mixed
     */
    public function getCoEscuela()
    {
        return $this->coEscuela;
    }

    /**
     * @param mixed $coEscuela
     * @return alumnomodel
     */
    public function setCoEscuela($coEscuela)
    {
        $this->coEscuela = $coEscuela;
        return $this;
    }

    public function bdEscuela($nombre)
    {
        $escuela = DB::select('select idEscuela from escuela where nombre=:nombre',['nombre' => $nombre]);

        foreach ($escuela as $es)
        {
            $e = $es->idEscuela;
        }

        return $e;
    }

    public function bdPersona($dni)
    {
        $persona= DB::select('select codPersona from persona where dni=:dni',['dni' => $dni]);

        foreach ($persona as $pers)
        {
            $per = $pers->codPersona;
        }

        return $per;
    }

    public function consultarAlumnoPorDni()
    {
        //$alumnosa = array();

        $alumnos = DB::select('select * from persona left join alumno on persona.codPersona = alumno.idPersona where persona.dni=dni', ['dni' => $this->getDni()]);

        /*foreach ($alumnosbd as $alumnos) {
            array_push($alumnosa, $alumnos->dni, $alumnos->nombres, $alumnos->codAlumno, $alumnos->codMatricula, $alumnos->fecha);
        }*/

        return $alumnos;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function consultarAlumnos($bsc, $da)
    {
        $alumnos = DB::select(DB::raw("select * from persona left join alumno on persona.codPersona = alumno.idPersona where persona.codPersona= alumno.idPersona and '$bsc'='$da'"));
        //return view('Administrador/Alumno/Search', ['alumnos' => $alumnos]);
        return $alumnos;
    }

    public function extraerCodigoAlumno($codigoMatricula)
    {
        $alumnocod = DB::select('select codAlumno from alumno where codigoMatricula=:codigoMatricula', ['codigoMatricula' => $codigoMatricula]);

        foreach ($alumnocod as $alumno) {
            $alc = $alumno->codAlumno;
        }

        return $alc;
    }

    public function save()
    {
        $save= DB::table('alumno')->insert(['codAlumno' => $this->codAlumno, 'codMatricula' => $this->codMatricula, 'fecha' => $this->fecha, 'idPersona' => $this->idPersona]);
        return $save;
    }

    public function consultarAlumno($idAlumno)
    {
        $alumnoid= DB::select('select * from persona left join alumno on persona.codPersona = alumno.idPersona where alumno.idAlumno=:idAlumno',['idAlumno' => $idAlumno]);

        foreach ($alumnoid as $alumno)
        {
            $al = $alumno-> todoslosatributos;
        }

        return $al;
    }

    public function consultarAlumnoCodAlumno($codAlumno)
    {
        $alumnoca= DB::select('select * from persona left join alumno on persona.codPersona = alumno.idPersona where alumno.codAlumno=:codAlumno',['codAlumno' => $codAlumno]);

        foreach ($alumnoca as $alumno)
        {
            $al = $alumno-> todoslosatributos;
        }

        return $al;
    }

    public function consultarAlumnoCodMatricula($codMatricula)
    {
        $alumnocm= DB::select('select * from persona left join alumno on persona.codPersona = alumno.idPersona where alumno.codMatricula=:codMatricula',['codMatricula' => $codMatricula]);

        foreach ($alumnocm as $alumno)
        {
            $al = $alumno-> todoslosatributos;
        }

        return $al;
    }

    public function editarAlumno($dni,$nombres, $apellidos, $codAlumno,$codMatricula,$fecha,$nombreE)
    {
        $alumnosbd= DB::select('select codPersona from persona left join alumno on persona.codPersona = alumno.idPersona where persona.dni=:dni',['dni'=>$dni]);

        foreach ($alumnosbd as $alumnos)
        {
            $als = $alumnos-> codPersona;
        }

        $escuela = DB::select('select codEscuela from facultad left join escuela on facultad.idFacultad = facultad.idFacultad where escuela.nombre=nombre',['nombre' => $nombreE]);

        foreach ($escuela as $es)
        {
            $e = $es->idEscuela;
        }

        DB::table('persona')->where('codPersona', $als)->update(['nombres' => $nombres, 'apellidos'=>$apellidos]);
        DB::table('alumno')->where('idPersona', $als)->update(['codAlumno' => $codAlumno, 'codMatricula'=>$codMatricula, 'fecha'=>$fecha,'coEscuela'=>$e]);
    }

    public function eliminarAlumno($dni)
    {
        $alumnosbd= DB::select('select codPersona from persona left join alumno on persona.codPersona = alumno.idPersona where persona.dni=:dni',['dni'=>$dni]);

        foreach ($alumnosbd as $alumnos)
        {
            $cod = $alumnos-> codPersona;
        }

        DB::table('persona')->where('codPersona', $cod)->update(['estado' => 0]);
        DB::table('alumno')->where('idPersona', $cod)->update(['estado' => 0]);
    }

    public function eliminarAlumnosEscuela($nombreEscuela)
    {
        $escuelace= DB::select('select codEscuela, estado from escuela where nombre=:nombre',['nombre'=>$nombreEscuela]);

        foreach ($escuelace as $escuela)
        {
            $cod = $escuela-> codEscuela;
            $est = $escuela->estado;
        }

        if($est==0)
        {
            DB::table('alumno')->where('coEscuela', $cod)->update(['estado' => 0]);
        }
    }
}
