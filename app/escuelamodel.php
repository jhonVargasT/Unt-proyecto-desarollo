<?php

namespace App;

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

    public function buscarFacultad($nombre)
    {
        $facultad = DB::select('select * from facultad left join escuela on facultad.codFacultad=escuela.coFacultad where facultad.codFacultad=escuela.coFacultad and facultad.nombre=:nombre', ['nombre' => $nombre]);
        return $facultad;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function llenarEscuelaReporte()
    {
        $escuelabd =DB::table('escuela')->select('nombre')->where('estado','=',1)->get();
        return $escuelabd;
    }

    public function consultarEscuelaid($idEscuela)
    {
        $escuelabd = DB::table('escuela')->where('idEscuela', $idEscuela)->get();
        return $escuelabd;
    }

    public function consultarEscuelaCodigo($codigo)
    {
        $escuelabd = DB::table('escuela')
            ->where('codEscuela', $codigo)
            ->where('estado', 1)->orderBy('codEscuela', 'desc')->get();
        return $escuelabd;
    }

    public function consultarEscuelasNombre($nombre)
    {
        $escuelabd = DB::table('escuela')
            ->where('nombre', 'like', '%' . $nombre . '%')
            ->where('estado', 1)->orderBy('idEscuela', 'desc')->get();
        return $escuelabd;
    }

    public function consultarEscuelasCuentaInterna($nroCuenta)
    {
        $escuelabd = DB::table('escuela')
            ->where('nroCuenta', 'like', '%' . $nroCuenta . '%')
            ->where('estado', 1)->orderBy('idEscuela', 'desc')->get();
        return $escuelabd;
    }

    public function consultarEscuelasFacultad($nombreF)
    {
        $escuelabd = DB::select('select * from facultad left join escuela on facultad.idFacultad = escuela.codigoFacultad where 
        facultad.idFacultad = escuela.codigoFacultad and facultad.nombre=:nombre and facultad.estado=1 and escuela.estado=1', ['nombre' => $nombreF]);
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
            DB::transaction(function () use ($idEscuela,$logunt) {
                DB::table('escuela')->where('idEscuela', $idEscuela)->update(['estado' => 0]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
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
            DB::transaction(function () use ($idEscuela,$logunt) {
                DB::table('escuela')->where('idEscuela', $idEscuela)->update(['nombre' => $this->nombre, 'nroCuenta' => $this->nroCuenta]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }
}
