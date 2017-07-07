<?php

namespace App;

use App\Http\Controllers\util;
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
    private $tipoAlummno;

    function __construct()
    {
        parent::__construct();

    }

    /**
     * @return mixed
     */
    public function getTipoAlummno()
    {
        return $this->tipoAlummno;
    }

    /**
     * @param mixed $tipoAlummno
     */
    public function setTipoAlummno($tipoAlummno)
    {
        $this->tipoAlummno = $tipoAlummno;
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

    public function bdEscuela($nombre)
    {
        try {
            $e = null;
            $escuela = DB::select('select idEscuela from escuela where nombre=:nombre', ['nombre' => $nombre]);

            foreach ($escuela as $es) {
                $es->idEscuela;
            }
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'bdEscuela/alumnomodel');
            return null;
        }
        return $e;
    }

    public function bdEscuelaSede($nombre, $sede)
    {
        try {
            $ide = null;
            $escuela = DB::select('SELECT 
        escuela.idEscuela
        FROM
        escuela
            LEFT JOIN
        facultad ON escuela.codigoFacultad = facultad.idFacultad
            LEFT JOIN
        sede ON facultad.coSede = sede.codSede
        WHERE
        sede.nombresede = "' . $sede . '" and escuela.nombre="' . $nombre . '"');

            foreach ($escuela as $es) {
                $ide = $es->idEscuela;
            }
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'bdEscuelaSede/alumnomodel');
            return null;
        }
        return $ide;
    }


    public function grabr($codigo, $ap, $no, $dni)
    {
        try {
            DB::table('prueba')->insert(['codigo' => $codigo, 'ap' => $ap, 'nom' => $no, 'dni' => $dni]);
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'grabr/alumnomodel');
        }
    }

    public function savealumno($dni)
    {
        echo 1;
        $idp = null;
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('registrarAlumno');
        $logunt->setCodigoPersonal($codPers);
        try {
            DB::transaction(function () use ($logunt, $idp, $dni) {
                $alumnobd = DB::select('select codPersona from persona left join alumno on persona.codPersona = alumno.idPersona where 
                persona.codPersona = alumno.idPersona and persona.dni = ' . $dni . ' and persona.estado = 1 and alumno.estado=1');
                foreach ($alumnobd as $pbd) {
                    $idp = $pbd->codPersona;
                }
                if ($idp != null) {
                    DB::table('alumno')->where('idPersona', $idp)->update(['coEscuela' => $this->idEscuela]);
                } else {
                    DB::table('persona')->insert(['dni' => $this->getDni(), 'nombres' => $this->getNombres(), 'apellidos' => $this->getApellidos(), 'correo' => $this->getCorreo()]);
                    $personabd = DB::table('persona')->where('dni', $this->getDni())->get();
                    foreach ($personabd as $pbd) {
                        $idp = $pbd->codPersona;
                    }
                    DB::table('alumno')->insert(['codAlumno' => $this->codAlumno, 'fecha' => $this->fecha, 'idPersona' => $idp, 'coEscuela' => $this->idEscuela, 'tipoAlumno' => $this->tipoAlummno]);
                }
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'savealumno/alumnomodel');
            return false;
        }
        return true;
    }

    public function savealumnoProduccion($dni)
    {
        $idp = null;
        $ida = null;
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('registrarAlumnoProduccion');
        $logunt->setCodigoPersonal($codPers);
        try {
            DB::transaction(function () use ($logunt, $idp, $dni, $ida) {
                $alumnobd = DB::select('select codPersona, idAlumno from persona left join alumno on persona.codPersona = alumno.idPersona where 
                persona.codPersona = alumno.idPersona and persona.dni = ' . $dni . ' and persona.estado = 1 and alumno.estado=1');
                foreach ($alumnobd as $pbd) {
                    $idp = $pbd->codPersona;
                    $ida = $pbd->idAlumno;
                }
                $produccionbd = DB::select('SELECT codProduccionAlumno FROM produccionalumno LEFT JOIN alumno ON produccionalumno.codAlumno = produccionalumno.codAlumno
                LEFT JOIN persona ON persona.codPersona = alumno.idPersona LEFT JOIN produccion ON produccionalumno.idProduccion = produccion.codProduccion
                WHERE persona.dni = ' . $dni . ' AND produccion.codProduccion = ' . $this->codProduccion . ' ');
                if ($idp != null && $produccionbd == null) {
                    DB::table('produccionalumno')->insert(['codAlumno' => $ida, 'idProduccion' => $this->codProduccion]);
                } else {
                    $id = DB::table('persona')->insertGetId(['dni' => $this->getDni(), 'nombres' => $this->getNombres(), 'apellidos' => $this->getApellidos(), 'correo' => $this->getCorreo()]);
                    DB::table('alumno')->insert(['codAlumno' => $this->codAlumno, 'fecha' => $this->fecha, 'idPersona' => $id]);
                    $alumnobd = DB::select('select idAlumno from persona left join alumno on persona.codPersona = alumno.idPersona where 
                    persona.codPersona = alumno.idPersona and persona.dni = ' . $dni . ' and persona.estado = 1 and alumno.estado=1');
                    foreach ($alumnobd as $pbd) {
                        $ida = $pbd->idAlumno;
                    }
                    DB::table('produccionalumno')->insert(['codAlumno' => $ida, 'idProduccion' => $this->codProduccion]);
                }
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'savealumnoProduccion/alumnomodel');
            return false;
        }
        return true;
    }

    public function bdProduccion($nombre)
    {
        try {
            $prod = null;
            $produccionbd = DB::select('select codProduccion from produccion where nombre = "' . $nombre . '"');

            foreach ($produccionbd as $p) {
                $prod = $p->codProduccion;
            }
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'bdProduccion/alumnomodel');
            return null;
        }
        return $prod;
    }

    public function editarAlumno($codPersona)
    {
        $idp = null;
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('editarAlumno');
        $logunt->setCodigoPersonal($codPers);
        try {
            DB::transaction(function () use ($codPersona, $logunt, $idp) {
                DB::table('persona')->where('codPersona', $codPersona)->update(['dni' => $this->getDni(), 'nombres' => $this->getNombres(), 'apellidos' => $this->getApellidos(), 'correo' => $this->getCorreo()]);
                $personabd = DB::table('persona')->where('dni', $this->getDni())->get();
                foreach ($personabd as $pbd) {
                    $idp = $pbd->codPersona;
                }
                DB::table('alumno')->where('idPersona', $codPersona)->update(['codAlumno' => $this->codAlumno, 'fecha' => $this->fecha, 'idPersona' => $idp, 'coEscuela' => $this->idEscuela]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'editarAlumno/alumnomodel');
            return false;
        }
        return true;
    }

    public function editarAlumnoP($codPersona)
    {
        $idp = null;
        $ida = null;
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('editarAlumnoProduccion');
        $logunt->setCodigoPersonal($codPers);
        try {
            DB::transaction(function () use ($codPersona, $logunt, $idp, $ida) {
                DB::table('persona')->where('codPersona', $codPersona)->update(['dni' => $this->getDni(), 'nombres' => $this->getNombres(), 'apellidos' => $this->getApellidos(), 'correo' => $this->getCorreo()]);
                $alumnobd = DB::select('select codPersona, idAlumno from persona left join alumno on persona.codPersona = alumno.idPersona where 
                persona.codPersona = alumno.idPersona and persona.codPersona = ' . $codPersona . ' and persona.estado = 1 and alumno.estado=1');
                foreach ($alumnobd as $pbd) {
                    $idp = $pbd->codPersona;
                    $ida = $pbd->idAlumno;
                }
                DB::table('alumno')->where('idPersona', $codPersona)->update(['codAlumno' => $this->codAlumno, 'fecha' => $this->fecha, 'idPersona' => $idp]);
                $produccionbd = DB::select('SELECT codProduccionAlumno FROM produccionalumno LEFT JOIN persona ON persona.codPersona = produccionalumno.idPersona
                LEFT JOIN produccion ON produccionalumno.idProduccion = produccion.codProduccion WHERE alumno.idAlumno = ' . $ida . ' AND produccion.codProduccion = ' . $this->codProduccion . ' ');
                if ($produccionbd != null) {
                    DB::table('produccionalumno')->insert(['codAlumno' => $ida, 'idProduccion' => $this->codProduccion]);
                }
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'editarAlumnoP/alumnomodel');
            return false;
        }
        return true;
    }

    public function consultarAlumnoDNIP($dni)
    {
        try {
            $alumnobd = DB::select('SELECT 
                *
            FROM
                persona
                    LEFT JOIN
                alumno ON persona.codPersona = alumno.idPersona
                    LEFT JOIN
                produccionalumno ON produccionalumno.codAlumno = alumno.idAlumno
                    LEFT JOIN
                produccion ON produccion.codProduccion = produccionalumno.idProduccion
            WHERE
                persona.codPersona = alumno.idPersona
                    AND produccionalumno.codAlumno = alumno.idAlumno
                    AND produccion.codProduccion = produccionalumno.idProduccion
                    AND persona.estado = 1
                    AND alumno.estado = 1
                    AND persona.dni like "%' . $dni . '%"');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarAlumnoDNIP/alumnomodel');
            return null;
        }
        return $alumnobd;
    }

    public function consultarAlumnoDNI($dni)
    {
        try {
            $alumnobd = DB::select('SELECT 
                *
            FROM
                persona
                    LEFT JOIN
                alumno ON persona.codPersona = alumno.idPersona
                    LEFT JOIN
                escuela ON escuela.idEscuela = alumno.coEscuela
            WHERE
                persona.codPersona = alumno.idPersona
                    AND escuela.idEscuela = alumno.coEscuela
                    AND persona.dni like "%' . $dni . '%"
                    AND persona.estado = 1
                    AND alumno.estado = 1');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarAlumnoDNI/alumnomodel');
            return null;
        }
        return $alumnobd;
    }

    public function consultarPersonaApellidosP($apellidos)
    {
        try {
            $alumnobd = DB::select('SELECT 
                *
            FROM
                persona
                    LEFT JOIN
                alumno ON persona.codPersona = alumno.idPersona
                    LEFT JOIN
                produccionalumno ON produccionalumno.codAlumno = alumno.idAlumno
                    LEFT JOIN
                produccion ON produccion.codProduccion = produccionalumno.idProduccion
            WHERE
                persona.codPersona = alumno.idPersona
                    AND produccionalumno.codAlumno = alumno.idAlumno
                    AND produccion.codProduccion = produccionalumno.idProduccion
                    AND persona.estado = 1
                    AND alumno.estado = 1
                    AND persona.apellidos like "%' . $apellidos . '%"');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarPersonaApellidosP/alumnomodel');
            return null;
        }
        return $alumnobd;
    }

    public function consultarAlumnoCodigoP($codigo)
    {
        try {
            $alumnobd = DB::select('SELECT 
                *
            FROM
                persona
                    LEFT JOIN
                alumno ON persona.codPersona = alumno.idPersona
                    LEFT JOIN
                 produccionalumno ON produccionalumno.codAlumno = alumno.idAlumno
                    LEFT JOIN
                produccion ON produccion.codProduccion = produccionalumno.idProduccion
            WHERE
                persona.codPersona = alumno.idPersona
                    AND produccionalumno.codAlumno = alumno.idAlumno
                    AND produccion.codProduccion = produccionalumno.idProduccion
                    AND persona.estado = 1
                    AND alumno.estado = 1
                    AND alumno.codAlumno like "%' . $codigo . '%"');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarAlumnoCodigoP/alumnomodel');
            return null;
        }
        return $alumnobd;
    }

    public function consultarAlumnoProduccionP($nombre)
    {
        try {
            $alumnobd = DB::select('SELECT 
                *
            FROM
                persona
                    LEFT JOIN
                alumno ON persona.codPersona = alumno.idPersona
                    LEFT JOIN
                produccionalumno ON produccionalumno.codAlumno = alumno.idAlumno
                    LEFT JOIN
                produccion ON produccion.codProduccion = produccionalumno.idProduccion
            WHERE
                persona.codPersona = alumno.idPersona
                    AND produccionalumno.codAlumno = alumno.idAlumno
                    AND produccion.codProduccion = produccionalumno.idProduccion
                    AND persona.estado = 1
                    AND alumno.estado = 1
                    and produccion.nombre like "%' . $nombre . '%"');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarAlumnoProduccionP/alumnomodel');
            return null;
        }
        return $alumnobd;
    }

    public function consultarAlumnosP()
    {
        try {
            $alumnobd = DB::select('SELECT 
                *
            FROM
                persona
                    LEFT JOIN
                alumno ON persona.codPersona = alumno.idPersona
                    LEFT JOIN
                produccionalumno ON produccionalumno.codAlumno = alumno.idAlumno
                    LEFT JOIN
                produccion ON produccion.codProduccion = produccionalumno.idProduccion
            WHERE
                persona.codPersona = alumno.idPersona
                    AND produccionalumno.codAlumno = alumno.idAlumno
                    AND produccion.codProduccion = produccionalumno.idProduccion
                    AND persona.estado = 1
                    AND alumno.estado = 1');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarAlumnosP/alumnomodel');
            return null;
        }
        return $alumnobd;
    }


    public
    function consultarPersonaApellidos($apellidos)
    {
        try {
            $alumnobd = DB::select('SELECT 
                *
            FROM
                persona
                    LEFT JOIN
                alumno ON persona.codPersona = alumno.idPersona
                    LEFT JOIN
                escuela ON escuela.idEscuela = alumno.coEscuela
            WHERE
                persona.codPersona = alumno.idPersona
                    AND escuela.idEscuela = alumno.coEscuela
                    AND persona.apellidos like "%' . $apellidos . '%"
                    AND persona.estado = 1
                    AND alumno.estado = 1');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarPersonaApellidos/alumnomodel');
            return null;
        }
        return $alumnobd;
    }

    public
    function consultarAlumnoCodigo($codAlumno)
    {
        try {
            $alumnobd = DB::select('SELECT 
                *
            FROM
                persona
                    LEFT JOIN
                alumno ON persona.codPersona = alumno.idPersona
                    LEFT JOIN
                escuela ON escuela.idEscuela = alumno.coEscuela
            WHERE
                persona.codPersona = alumno.idPersona
                    AND escuela.idEscuela = alumno.coEscuela
                    AND alumno.codAlumno like "%' . $codAlumno . '%"
                    AND persona.estado = 1
                    AND alumno.estado = 1');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarAlumnoCodigo/alumnomodel');
            return null;
        }
        return $alumnobd;
    }

    public
    function consultarAlumnoEscuela($nombreEscuela)
    {
        try {
            $alumnobd = DB::select('select * from persona 
        left join alumno on persona.codPersona = alumno.idPersona 
        left join escuela on escuela.idEscuela = alumno.coEscuela 
        where persona.codPersona = alumno.idPersona 
        and escuela.idEscuela = alumno.coEscuela 
        and escuela.nombre like "%' . $nombreEscuela . '%"
        and persona.estado = 1');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarAlumnoEscuela/alumnomodel');
            return null;
        }
        return $alumnobd;
    }

    public
    function consultarAlumnoFacultad($nombreFacultad)
    {
        try {
            $alumnobd = DB::select('select * from persona 
        left join alumno on persona.codPersona = alumno.idPersona 
        left join escuela on escuela.idEscuela = alumno.coEscuela 
        left join facultad on facultad.idFacultad = escuela.codigoFacultad 
        where persona.codPersona = alumno.idPersona 
        and escuela.idEscuela = alumno.coEscuela 
        and facultad.idFacultad = escuela.codigoFacultad
        and facultad.nombre like "%' . $nombreFacultad . '%"
        and persona.estado=1');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarAlumnoFacultad/alumnomodel');
            return null;
        }
        return $alumnobd;
    }

    public function consultarAlumnoid($codPersona)
    {
        try {
            $alumnobd = DB::select('select codPersona, dni,nombres, apellidos,correo, codAlumno, fecha,escuela.nombre as enombre, facultad.nombre as fnombre, nombresede from persona
        left join alumno on persona.codPersona=alumno.idPersona
        left join escuela on alumno.coEscuela = escuela.idEscuela
        left join facultad on escuela.codigoFacultad= facultad.idFacultad
        left join sede on facultad.coSede = sede.codSede
        where persona.codPersona=alumno.idPersona
        and alumno.coEscuela = escuela.idEscuela
        and escuela.codigoFacultad= facultad.idFacultad
        and facultad.coSede = sede.codSede and persona.estado=1
        and alumno.estado=1 and escuela.estado=1 and facultad.estado=1
        and sede.estado=1 and persona.codPersona = ' . $codPersona . ' ');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarAlumnoid/alumnomodel');
            return null;
        }
        return $alumnobd;
    }

    public
    function consultarAlumnoidP($codPersona, $codProduccion)
    {
        try {
            $alumnobd = DB::select('SELECT 
                *
            FROM
                persona
                    LEFT JOIN
                alumno ON persona.codPersona = alumno.idPersona
                    LEFT JOIN
                produccionalumno ON produccionalumno.codAlumno = alumno.idAlumno
                    LEFT JOIN
                produccion ON produccion.codProduccion = produccionalumno.idProduccion
            WHERE
                persona.codPersona = alumno.idPersona
                    AND produccionalumno.codAlumno = alumno.idAlumno
                    AND produccion.codProduccion = produccionalumno.idProduccion
                    AND persona.estado = 1
                    AND alumno.estado = 1
                    AND persona.codPersona = ' . $codPersona . ' 
                    AND produccionalumno.idProduccion = ' . $codProduccion . ' ');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarAlumnoidP/alumnomodel');
            return null;
        }
        return $alumnobd;
    }

    public
    function eliminarAlumno($codPersona)
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
            $util = new util();
            $util->insertarError($e->getMessage(), 'eliminarAlumno/alumnomodel');
            return false;
        }
        return true;
    }

    public
    function eliminarAlumnoP($codPersona)
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
            $util = new util();
            $util->insertarError($e->getMessage(), 'eliminarAlumnoP/alumnomodel');
            return false;
        }
        return true;
    }

    public function consultaridPersonaAlumno($codAlumno)
    {
        try {
            $idPer = null;
            $alumnobd = DB::select('select * from persona left join alumno on persona.codPersona = alumno.idPersona where 
        persona.codPersona = alumno.idPersona and alumno.codAlumno=:codAlumno', ['codAlumno' => $codAlumno]);
            foreach ($alumnobd as $al) {
                $idPer = $al->idPersona;
            }
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultaridPersonaAlumno/alumnomodel');
            return null;
        }
        return $idPer;
    }

    public function obtenerCodAlumnoxCodPersona($codPersona)
    {
        try {
            $idA = null;
            $alumnobd = DB::select('select idAlumno from persona left join alumno on persona.codPersona = alumno.idPersona where 
        persona.codPersona = alumno.idPersona and persona.codPersona=:codPersona', ['codPersona' => $codPersona]);
            foreach ($alumnobd as $al) {
                $idA = $al->idAlumno;
            }
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'obtenerCodAlumnoxCodPersona/alumnomodel');
            return null;
        }
        return $idA;
    }


    public function obtenerCodProduccion($nombre)
    {
        try {
            $prod = null;
            $prouccionbd = DB::select('select codProduccion from produccion where nombre = "' . $nombre . '" ');

            foreach ($prouccionbd as $p) {
                $prod = $p->codProduccion;
            }
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'obtenerCodProduccion/alumnomodel');
            return null;
        }
        return $prod;
    }
}
