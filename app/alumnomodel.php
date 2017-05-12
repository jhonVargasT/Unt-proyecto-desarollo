<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDOException;

class alumnomodel extends personamodel
{

    private $codAlumno;
    private $fecha;
    private $idPersona;
    private $idEscuela;
    private $codProduccion;

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

    /**
     * @return mixed
     */
    public function getIdEscuela()
    {
        return $this->idEscuela;
    }

    /**
     * @param mixed $idEscuela
     * @return alumnomodel
     */
    public function setIdEscuela($idEscuela)
    {
        $this->idEscuela = $idEscuela;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodProduccion()
    {
        return $this->codProduccion;
    }

    /**
     * @param mixed $codProduccion
     * @return alumnomodel
     */
    public function setCodProduccion($codProduccion)
    {
        $this->codProduccion = $codProduccion;
        return $this;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function grabr($codigo, $ap, $no, $dni)
    {
        DB::table('prueba')->insert(['codigo' => $codigo, 'ap' => $ap, 'nom' => $no, 'dni' => $dni]);

    }

    public function savealumno()
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('registrarAlumno');
        $logunt->setCodigoPersonal($codPers);
        echo $this->getFecha();
        try {
            DB::transaction(function () use ($logunt) {
                DB::table('persona')->insert(['dni' => $this->getDni(), 'nombres' => $this->getNombres(), 'apellidos' => $this->getApellidos(), 'correo' => $this->getCorreo()]);
                $personabd = DB::table('persona')->where('dni', $this->getDni())->get();
                foreach ($personabd as $pbd) {
                    $idp = $pbd->codPersona;
                    DB::table('alumno')->insert(['codAlumno' => $this->codAlumno, 'fecha' => $this->fecha, 'idPersona' => $idp, 'coEscuela' => $this->idEscuela]);
                }
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function savealumnoProduccion($dni)
    {
        $idp = null;
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('registrarAlumnoProduccion');
        $logunt->setCodigoPersonal($codPers);
        echo $this->getFecha();
        try {
            DB::transaction(function () use ($logunt, $idp, $dni) {
                $alumnobd = DB::select('select codPersona from persona left join alumno on persona.codPersona = alumno.idPersona where 
                persona.codPersona = alumno.idPersona and persona.dni = ' . $dni . ' and persona.estado = 1 and alumno.estado=1');
                foreach ($alumnobd as $pbd) {
                    $idp = $pbd->codPersona;
                }
                if ($idp != null) {
                    DB::table('persona')->where('dni', $dni)->update(['dni' => $this->getDni(), 'nombres' => $this->getNombres(), 'apellidos' => $this->getApellidos(), 'correo' => $this->getCorreo(), 'idProduccion' => $this->getCodProduccion()]);
                } else {
                    DB::table('persona')->insert(['dni' => $this->getDni(), 'nombres' => $this->getNombres(), 'apellidos' => $this->getApellidos(), 'correo' => $this->getCorreo(), 'idProduccion' => $this->getCodProduccion()]);
                    DB::table('alumno')->insert(['codAlumno' => $this->codAlumno, 'fecha' => $this->fecha, 'idPersona' => $idp]);
                }
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function bdProduccion($nombre)
    {
        $prod = null;
        $produccionbd = DB::select('select codProduccion from produccion where nombre = "' . $nombre . '"');

        foreach ($produccionbd as $p) {
            $prod = $p->codProduccion;
        }
        return $prod;
    }

    public function editarAlumno($codPersona)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('editarAlumno');
        $logunt->setCodigoPersonal($codPers);
        try {
            DB::transaction(function () use ($codPersona, $logunt) {
                DB::table('persona')->where('codPersona', $codPersona)->update(['dni' => $this->getDni(), 'nombres' => $this->getNombres(), 'apellidos' => $this->getApellidos(), 'correo' => $this->getCorreo()]);
                $personabd = DB::table('persona')->where('dni', $this->getDni())->get();
                foreach ($personabd as $pbd) {
                    $idp = $pbd->codPersona;
                    DB::table('alumno')->where('idPersona', $codPersona)->update(['codAlumno' => $this->codAlumno, 'fecha' => $this->fecha, 'idPersona' => $idp, 'coEscuela' => $this->idEscuela]);
                }
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function editarAlumnoP($codPersona)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('editarAlumnoProduccion');
        $logunt->setCodigoPersonal($codPers);
        try {
            DB::transaction(function () use ($codPersona, $logunt) {
                DB::table('persona')->where('codPersona', $codPersona)->update(['dni' => $this->getDni(), 'nombres' => $this->getNombres(), 'apellidos' => $this->getApellidos(), 'correo' => $this->getCorreo(), 'idProduccion' => $this->getCodProduccion()]);
                $personabd = DB::table('persona')->where('dni', $this->getDni())->get();
                foreach ($personabd as $pbd) {
                    $idp = $pbd->codPersona;
                    DB::table('alumno')->where('idPersona', $codPersona)->update(['codAlumno' => $this->codAlumno, 'fecha' => $this->fecha, 'idPersona' => $idp]);
                }
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function consultarAlumnoDNIP($dni)
    {
        $alumnobd = DB::select('select * from persona left join alumno on persona.codPersona = alumno.idPersona 
        left join produccion on produccion.codProduccion = persona.idProduccion where 
        persona.codPersona = alumno.idPersona and persona.dni like "%' . $dni . '%" and persona.estado = 1 and alumno.estado=1 and produccion.estado=1');
        return $alumnobd;
    }

    public function consultarAlumnoDNI($dni)
    {
        $alumnobd = DB::select('select * from persona left join alumno on persona.codPersona = alumno.idPersona where 
        persona.codPersona = alumno.idPersona and persona.dni like "%' . $dni . '%" and persona.estado = 1 and alumno.estado=1');
        return $alumnobd;
    }

    public function consultarPersonaApellidosP($apellidos)
    {
        $alumnobd = DB::select('select * from persona left join alumno on persona.codPersona = alumno.idPersona 
        left join produccion on produccion.codProduccion = persona.idProduccion where 
        persona.codPersona = alumno.idPersona and persona.apellidos like "%' . $apellidos . '%" and persona.estado = 1 and alumno.estado=1 and produccion.estado=1');
        return $alumnobd;
    }

    public function consultarAlumnoCodigoP($codigo)
    {
        $alumnobd = DB::select('select * from persona left join alumno on persona.codPersona = alumno.idPersona 
        left join produccion on produccion.codProduccion = persona.idProduccion where 
        persona.codPersona = alumno.idPersona and alumno.codAlumno like "%' . $codigo . '%" and persona.estado = 1 and alumno.estado=1 and produccion.estado=1');
        return $alumnobd;
    }

    public function consultarAlumnoProduccionP($nombre)
    {
        $alumnobd = DB::select('select * from persona left join alumno on persona.codPersona = alumno.idPersona 
        left join produccion on produccion.codProduccion = persona.idProduccion where 
        persona.codPersona = alumno.idPersona and produccion.nombre like "%' . $nombre . '%" and persona.estado = 1 and alumno.estado=1 and produccion.estado=1');
        return $alumnobd;
    }

    public function consultarAlumnosP()
    {
        $alumnobd = DB::select('select * from persona left join alumno on persona.codPersona = alumno.idPersona 
        left join produccion on produccion.codProduccion = persona.idProduccion where 
        persona.codPersona = alumno.idPersona and persona.estado = 1 and alumno.estado=1 and produccion.estado=1');
        return $alumnobd;
    }

    public function consultarAlumnoFechaMatriculaP($fecha)
    {
        $alumnobd = DB::select('select * from persona left join alumno on persona.codPersona = alumno.idPersona 
        left join produccion on produccion.codProduccion = persona.idProduccion where 
        persona.codPersona = alumno.idPersona and alumno.fecha like "%' . $fecha . '%" and persona.estado = 1 and alumno.estado=1 and produccion.estado=1');
        return $alumnobd;
    }

    public function consultarPersonaApellidos($apellidos)
    {
        $alumnobd = DB::select('select * from persona left join alumno on persona.codPersona = alumno.idPersona where 
        persona.codPersona = alumno.idPersona and persona.apellidos like "%' . $apellidos . '%" and persona.estado = 1 and alumno.estado=1');
        return $alumnobd;
    }

    public function consultarAlumnoCodigo($codAlumno)
    {
        $alumnobd = DB::table('persona')->leftJoin('alumno', 'persona.codPersona', '=', 'alumno.idPersona')->where('alumno.codAlumno', 'like', '%' . $codAlumno . '%')
            ->where('persona.estado', '=', 1)->orderBy('persona.codPersona', 'desc')->get();
        return $alumnobd;
    }

    public function consultarAlumnoFechaMatricula($fecha)
    {
        $alumnobd = DB::table('persona')->leftJoin('alumno', 'persona.codPersona', '=', 'alumno.idPersona')
            ->where('alumno.fecha', 'like', '%' . $fecha . '%')
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
        and escuela.nombre like "%' . $nombreEscuela . '%"
        and persona.estado = 1');
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
        and facultad.nombre like "%' . $nombreFacultad . '%"
        and persona.estado=1');
        return $alumnobd;
    }

    public function consultarAlumnoid($codPersona)
    {
        $alumnobd = DB::select('select codPersona, dni,nombres, apellidos,correo, codAlumno, fecha,escuela.nombre as enombre, facultad.nombre as fnombre, nombresede from persona
        left join alumno on persona.codPersona=alumno.idPersona
        left join escuela on alumno.coEscuela = escuela.codEscuela
        left join facultad on escuela.codigoFacultad= facultad.idFacultad
        left join sede on facultad.coSede = sede.codSede
        where persona.codPersona=alumno.idPersona
        and alumno.coEscuela = escuela.codEscuela
        and escuela.codigoFacultad= facultad.idFacultad
        and facultad.coSede = sede.codSede and persona.estado=1
        and alumno.estado=1 and escuela.estado=1 and facultad.estado=1
        and sede.estado=1 and persona.codPersona = ' . $codPersona . ' ');
        return $alumnobd;
    }

    public function consultarAlumnoidP($codPersona)
    {
        $alumnobd = DB::select('select * from persona left join alumno on persona.codPersona = alumno.idPersona
        left join produccion on persona.idProduccion = produccion.codProduccion where persona.codPersona = ' . $codPersona . ' and persona.estado=1
        and alumno.estado=1 and produccion.estado=1');
        return $alumnobd;
    }

    public function eliminarAlumno($codPersona)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('eliminarAlumno');
        $logunt->setCodigoPersonal($codPers);
        try {
            DB::transaction(function () use ($codPersona, $logunt) {
                DB::table('persona')->where('codPersona', $codPersona)->update(['estado' => 0]);
                DB::table('alumno')->where('idPersona', $codPersona)->update(['estado' => 0]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function eliminarAlumnoP($codPersona)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('eliminarAlumnoProduccion');
        $logunt->setCodigoPersonal($codPers);
        try {
            DB::transaction(function () use ($codPersona, $logunt) {
                DB::table('persona')->where('codPersona', $codPersona)->update(['estado' => 0]);
                DB::table('alumno')->where('idPersona', $codPersona)->update(['estado' => 0]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function consultaridPersonaAlumno($codAlumno)
    {
        $idPer = null;
        $alumnobd = DB::select('select * from persona left join alumno on persona.codPersona = alumno.idPersona where 
        persona.codPersona = alumno.idPersona and alumno.codAlumno=:codAlumno', ['codAlumno' => $codAlumno]);
        foreach ($alumnobd as $al) {
            $idPer = $al->idPersona;
        }
        return $idPer;
    }
}
