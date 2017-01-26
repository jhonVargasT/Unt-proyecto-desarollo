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
    private $val;
    private $campo;


    function __construct()
    {
        parent::__construct();

    }

    /**
     * @return mixed
     */
    public function getVal()
    {
        return $this->val;
    }

    /**
     * @param mixed $val
     * @return alumnomodel
     */
    public function setVal($val)
    {
        $this->val = $val;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCampo()
    {
        return $this->campo;
    }

    /**
     * @param mixed $campo
     * @return alumnomodel
     */
    public function setCampo($campo)
    {
        $this->campo = $campo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getObalumno()
    {
        return $this->obalumno;
    }

    /**
     * @param mixed $obalumno
     * @return alumnomodel
     */
    public function setObalumno($obalumno)
    {
        $this->obalumno = $obalumno;
        return $this;
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

    public function extraerCodigoAlumno($codigoMatricula)
    {
        $alumnocod = DB::select('select codAlumno from alumno where codigoMatricula=:codigoMatricula', ['codigoMatricula' => $codigoMatricula]);

        foreach ($alumnocod as $alumno) {
            $alc = $alumno->codAlumno;
        }

        return $alc;
    }

    public function savealumno()
    {
        $alumnoam = DB::select('select codAlumno, codMatricula from alumno where codAlumno=:codAlumno and codMatricula=:codMatricula',['codAlumno'=>$this->codAlumno,'codMatricula'=>$this->codMatricula]);

        if($alumnoam!=null)
        {
            return false;
        }
        else {
            DB::table('alumno')->insert(['codAlumno' => $this->codAlumno, 'codMatricula' => $this->codMatricula, 'fecha' => $this->fecha, 'idPersona' => $this->idPersona]);
            return true;
        }
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

    public function editarAlumno()
    {
        $alumnosbd= DB::select('select codPersona from persona left join alumno on persona.codPersona = alumno.idPersona where persona.dni=:dni',['dni'=>$this->getDni()]);

        foreach ($alumnosbd as $alumnos)
        {
            $als = $alumnos-> codPersona;
        }

        /*$escuela = DB::select('select codEscuela from facultad left join escuela on facultad.idFacultad = facultad.idFacultad where escuela.nombre=nombre',['nombre' => $nombreE]);

        foreach ($escuela as $es)
        {
            $e = $es->idEscuela;
        }*/

        DB::table('alumno')->where('idPersona', $als)->update(['codAlumno' => $this->codAlumno, 'codMatricula'=>$this->codMatricula, 'fecha'=>$this->fecha]);
    }

    /*public function eliminarAlumno()
    {

        DB::table('alumno')->where('codAlumno', $this->codAlumno)->update(['estado' => 0]);
    }*/

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
