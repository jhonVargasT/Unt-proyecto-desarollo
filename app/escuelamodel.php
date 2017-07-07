<?php

namespace App;

use App\Http\Controllers\util;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDOException;

class escuelamodel
{
    private $codEscuela;
    private $nombre;
    private $nroCuenta;
    private $estado;
    private $facultad;

    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getCodEscuela()
    {
        return $this->codEscuela;
    }

    /**
     * @param mixed $codEscuela
     */
    public function setCodEscuela($codEscuela)
    {
        $this->codEscuela = $codEscuela;
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
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getNroCuenta()
    {
        return $this->nroCuenta;
    }

    /**
     * @param mixed $nroCuenta
     */
    public function setNroCuenta($nroCuenta)
    {
        $this->nroCuenta = $nroCuenta;
    }

    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }


    /**
     * @return mixed
     */
    public function getFacultad()
    {
        return $this->facultad;
    }

    /**
     * @param mixed $facultad
     * @return escuelamodel
     */
    public function setFacultad($facultad)
    {
        $this->facultad = $facultad;
        return $this;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function buscarFacultad($nombref, $nombres)
    {
        try {
            $fa = null;
            $facultad = DB::select('select idFacultad from facultad
        left join sede  on facultad.coSede=sede.codSede
        where facultad.coSede=sede.codSede and facultad.estado=1
        and sede.estado=1 and facultad.nombre =:nombref and sede.nombresede=:nombres', ['nombref' => $nombref, 'nombres' => $nombres]);
            foreach ($facultad as $f) {
                $fa = $f->idFacultad;
            }
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'buscarFacultad/escuelaModel');
            return null;
        }
        return $fa;
    }

    /*public function llenarEscuelaReporte()
    {
        $escuelabd = DB::table('escuela')->select('nombre')->where('estado', '=', 1)->get();
        return $escuelabd;
    }*/

    public function consultarEscuelaid($idEscuela)
    {
        try {
            $escuelabd = DB::select('select idEscuela, escuela.nombre as nombre, codEscuela, escuela.nroCuenta, sede.nombresede, facultad.nombre as fnombre from escuela
        left join facultad on escuela.codigoFacultad=facultad.idFacultad
        left join sede on facultad.coSede=sede.codSede 
        where escuela.codigoFacultad=facultad.idFacultad and facultad.coSede=sede.codSede and sede.estado=1
        and facultad.estado=1 and escuela.estado=1 and escuela.idEscuela = ' . $idEscuela . ' ');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarEscuelaid/escuelaModel');
            return null;
        }
        return $escuelabd;
    }

    public function consultarEscuelaCodigo($codigo)
    {
        try {
            $escuelabd = DB::select('select idEscuela, escuela.nombre as nombre, codEscuela, escuela.nroCuenta, sede.nombresede from escuela
        left join facultad on escuela.codigoFacultad=facultad.idFacultad
        left join sede on facultad.coSede=sede.codSede 
        where escuela.codigoFacultad=facultad.idFacultad and facultad.coSede=sede.codSede and sede.estado=1
        and facultad.estado=1 and escuela.estado=1 and escuela.codEscuela like "%' . $codigo . '%" ');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarEscuelaCodigo/escuelaModel');
            return null;
        }
        return $escuelabd;
    }

    public function consultarEscuelasNombre($nombre)
    {
        try {
            $escuelabd = DB::select('select idEscuela, escuela.nombre as nombre, codEscuela, escuela.nroCuenta, sede.nombresede from escuela
        left join facultad on escuela.codigoFacultad=facultad.idFacultad
        left join sede on facultad.coSede=sede.codSede 
        where escuela.codigoFacultad=facultad.idFacultad and facultad.coSede=sede.codSede and sede.estado=1
        and facultad.estado=1 and escuela.estado=1 and escuela.nombre like "%' . $nombre . '%" ');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarEscuelasNombre/escuelaModel');
            return null;
        }
        return $escuelabd;
    }

    public function consultarEscuelasCuentaInterna($nroCuenta)
    {
        try {
            $escuelabd = DB::select('select idEscuela, escuela.nombre as nombre, codEscuela, escuela.nroCuenta, sede.nombresede from escuela
        left join facultad on escuela.codigoFacultad=facultad.idFacultad
        left join sede on facultad.coSede=sede.codSede 
        where escuela.codigoFacultad=facultad.idFacultad and facultad.coSede=sede.codSede and sede.estado=1
        and facultad.estado=1 and escuela.estado=1 and escuela.nroCuenta like "%' . $nroCuenta . '%" ');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarEscuelasCuentaInterna/escuelaModel');
            return null;
        }
        return $escuelabd;
    }

    public function consultarEscuelas()
    {
        try {
            $escuelabd = DB::select('select idEscuela, escuela.nombre as nombre, codEscuela, escuela.nroCuenta, sede.nombresede from escuela
        left join facultad on escuela.codigoFacultad=facultad.idFacultad
        left join sede on facultad.coSede=sede.codSede 
        where escuela.codigoFacultad=facultad.idFacultad and facultad.coSede=sede.codSede and sede.estado=1
        and facultad.estado=1 and escuela.estado=1');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarEscuelas/escuelaModel');
            return null;
        }
        return $escuelabd;
    }

    public function consultarEscuelasFacultad($nombreF)
    {
        try {
            $escuelabd = DB::select('SELECT idEscuela, escuela.nombre as nombre, codEscuela, escuela.nroCuenta as nroCuenta, nombresede FROM escuela 
        LEFT JOIN facultad ON escuela.codigoFacultad = facultad.idFacultad
        LEFT JOIN sede ON facultad.coSede= sede.codSede
        WHERE escuela.codigoFacultad = facultad.idFacultad and facultad.coSede= sede.codSede
        and escuela.estado=1 and sede.estado=1 and facultad.estado=1 and facultad.nombre like "%' . $nombreF . '%"');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarEscuelasFacultad/escuelaModel');
            return null;
        }

        return $escuelabd;
    }

    public function eliminarEscuela($idEscuela)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('eliminarEscuela');
        $logunt->setCodigoPersonal($codPers);

        try {
            DB::transaction(function () use ($idEscuela, $logunt) {
                DB::table('escuela')->where('idEscuela', $idEscuela)->update(['estado' => 0]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'eliminarEscuela/escuelaModel');
            return false;
        }
        return true;
    }

    public function saveescuela()
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('registrarEscuela');
        $logunt->setCodigoPersonal($codPers);
        try {
            DB::transaction(function () use ($logunt) {
                DB::table('escuela')->insert(['codEscuela' => $this->codEscuela, 'nombre' => $this->nombre, 'nroCuenta' => $this->nroCuenta, 'codigoFacultad' => $this->facultad]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'saveescuela/escuelaModel');
            return false;
        }
        return true;
    }

    public function editarEscuela($idEscuela)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('editarEscuela');
        $logunt->setCodigoPersonal($codPers);

        try {
            DB::transaction(function () use ($idEscuela, $logunt) {
                DB::table('escuela')->where('idEscuela', $idEscuela)->update(['codEscuela' => $this->codEscuela, 'nombre' => $this->nombre, 'nroCuenta' => $this->nroCuenta, 'codigoFacultad' => $this->facultad]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'editarEscuela/escuelaModel');
            return false;
        }
        return true;
    }

    public function obtenerId($nombre)
    {
        try {
            $esc = null;
            $data = DB::table('escuela')->select('idEscuela')->where('nombre', '=', $nombre)->get();
            foreach ($data as $dat) {
                $esc = $dat->idEscuela;
            }
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'obtenerId/escuelaModel');
            return null;
        }
        return $esc;
    }

    /*public function obtenerIdEscuela($idfacultad, $nombre)
    {
        $esc = null;
        $data = DB::table('escuela')->select('idEscuela')->where('nombre', '=', $nombre)->where('codigoFacultad', '=', $idfacultad)->get();
        foreach ($data as $dat) {
            $esc = $dat->idEscuela;
        }
        return $esc;
    }*/
}
