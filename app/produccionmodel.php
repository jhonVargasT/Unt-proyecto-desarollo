<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\util;
use PDOException;

/**
 * Created by PhpStorm.
 * User: ADMIN-PC
 * Date: 11/05/2017
 * Time: 01:29 AM
 */
class produccionmodel
{
    private $nombre;
    private $direcion;

    /**
     * bancomodel constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     * @return produccionmodel
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDirecion()
    {
        return $this->direcion;
    }

    /**
     * @param mixed $direcion
     * @return produccionmodel
     */
    public function setDirecion($direcion)
    {
        $this->direcion = $direcion;
        return $this;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /*public function saveProduccion()
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('registrarProduccion');
        $logunt->setCodigoPersonal($codPers);
        try {
            DB::transaction(function () use ($logunt) {
                DB::table('produccion')->insert(['nombre' => $this->getNombre(), 'direccion' => $this->getDirecion()]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'saveProduccion/produccionmodel');
            return false;
        }
        return true;
    }*/

    public function saveProduccion()
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('registrarProduccion');
        $logunt->setCodigoPersonal($codPers);
        try {
            DB::transaction(function () use ($logunt) {
                $idprod = DB::table('produccion')->insertGetId(['nombre' => $this->getNombre(), 'direccion' => $this->getDirecion()]);
                $idp = DB::table('persona')->insertGetId(['dni' => $idprod, 'nombres' => $this->getNombre(), 'apellidos' => $this->getNombre(), 'correo' => $this->getNombre() . '@gmail.com']);
                $ida = DB::table('alumno')->insertGetId(['codAlumno' => $idprod . $idp, 'idPersona' => $idp]);
                DB::table('produccionalumno')->insert(['codAlumno' => $ida, 'idProduccion' => $idprod]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'saveProduccion/produccionmodel');
            return false;
        }
        return true;
    }

    /*public function consultarProduccionid($codProduccion)
    {
        try {
            $produccionbd = DB::select('select * from produccion where codProduccion = ' . $codProduccion . ' ');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarProduccionid/produccionmodel');
            return null;

        }
        return $produccionbd;
    }*/

    public function consultarProduccionid($codProduccion)
    {
        try {
            $produccionbd = DB::select('select * from produccion 
                left join produccionalumno on produccionalumno.idProduccion = produccion.codProduccion
                left join alumno on produccionalumno.codAlumno = alumno.idAlumno
                left join persona on alumno.idPersona = persona.codPersona
                where codProduccion =:codProduccion and produccion.estado = 1 and alumno.estado=1 and persona.estado =1', ['codProduccion' => $codProduccion]);
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarProduccionid/produccionmodel');
            return null;
        }
        return $produccionbd;
    }

    /*public function editarProduccion($codProduccion)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('editarProduccion');
        $logunt->setCodigoPersonal($codPers);
        try {
            DB::transaction(function () use ($codProduccion, $logunt) {
                DB::table('produccion')->where('codProduccion', $codProduccion)->update(['nombre' => $this->getNombre(), 'direccion' => $this->getDirecion()]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'editarProduccion/produccionmodel');
            return false;
        }
        return true;
    }*/
    public function editarProduccion($codProduccion, $codPersona, $idAlumno, $codProduccionAlumno)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('editarProduccion');
        $logunt->setCodigoPersonal($codPers);
        try {
            DB::transaction(function () use ($codProduccion, $codPersona, $idAlumno, $codProduccionAlumno, $logunt) {
                DB::table('produccion')->where('codProduccion', $codProduccion)->update(['nombre' => $this->getNombre(), 'direccion' => $this->getDirecion()]);
                DB::table('persona')->where('codPersona', $codPersona)->update(['dni' => $codProduccion, 'nombres' => $this->getNombre(), 'apellidos' => $this->getNombre(), 'correo' => $this->getNombre() . '@gmail.com']);
                DB::table('alumno')->where('idAlumno', $idAlumno)->update(['codAlumno' => $codProduccion . $codPersona, 'idPersona' => $codPersona]);
                DB::table('produccionalumno')->where('codProduccionAlumno', $codProduccionAlumno)->update(['codAlumno' => $idAlumno, 'idProduccion' => $codProduccion]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'editarProduccion/produccionmodel');
            return false;
        }
        return true;
    }

    /*public function eliminarProduccion($codProduccion)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('eliminarProduccion');
        $logunt->setCodigoPersonal($codPers);

        try {
            DB::transaction(function () use ($codProduccion, $logunt) {
                DB::table('produccion')->where('codProduccion', $codProduccion)->update(['estado' => 0]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'eliminarProduccion/produccionmodel');
            return false;
        }
        return true;
    }*/

    public function eliminarProduccion($codProduccion)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('eliminarProduccion');
        $logunt->setCodigoPersonal($codPers);

        try {
            DB::transaction(function () use ($codProduccion, $logunt) {
                DB::table('produccion')->where('codProduccion', $codProduccion)->update(['estado' => 0]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'eliminarProduccion/produccionmodel');
            return false;
        }
        return true;
    }

    /*public function consultarProduccion()
    {
        try {
            $produccionbd = DB::select('select * from produccion');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarProduccion/produccionmodel');
            return null;
        }
        return $produccionbd;
    }*/

    public function consultarProduccion()
    {
        try {
            $produccionbd = DB::select('select * from produccion');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarProduccion/produccionmodel');
            return null;
        }
        return $produccionbd;
    }

    /*public function consultarProduccionxNombre($nombre)
    {
        try {
            $produccionbd = DB::select('select * from produccion where nombre like "%' . $nombre . '%"');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarProduccionxNombre/produccionmodel');
            return null;
        }
        return $produccionbd;
    }*/

    public function consultarProduccionxNombre($nombre)
    {
        try {
            $produccionbd = DB::select('select * from produccion where nombre like "%' . $nombre . '%"');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarProduccionxNombre/produccionmodel');
            return null;
        }
        return $produccionbd;
    }

    /*public function consultarProduccionxDireccion($direccion)
    {
        try {

            $produccionbd = DB::select('select * from produccion where direccion like "%' . $direccion . '%"');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarProduccionxDireccion/produccionmodel');
            return null;
        }
        return $produccionbd;
    }*/

    public function consultarProduccionxDireccion($direccion)
    {
        try {
            $produccionbd = DB::select('select * from produccion where direccion like "%' . $direccion . '%"');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarProduccionxDireccion/produccionmodel');
            return null;
        }
        return $produccionbd;
    }
}