<?php

namespace App;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDOException;

class facultadmodel
{
    private $codFacultad;
    private $nombre;
    private $nroCuenta;
    private $escuelas;

    public function __construct()
    {
        $this->escuelas = array();
    }

    /**
     * @return mixed
     */
    public function getEscuelas()
    {
        return $this->escuelas;
    }

    /**
     * @param mixed $escuelas
     * @return facultadmodel
     */
    public function setEscuelas($escuelas)
    {
        $this->escuelas = $escuelas;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getCodFacultad()
    {
        return $this->codFacultad;
    }

    /**
     * @param mixed $codFacultad
     * @return facultadmodel
     */
    public function setCodFacultad($codFacultad)
    {
        $this->codFacultad = $codFacultad;
        return $this;
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
     * @return facultadmodel
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
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
     * @return facultadmodel
     */
    public function setNroCuenta($nroCuenta)
    {
        $this->nroCuenta = $nroCuenta;
        return $this;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function llenarFacultadReporte()
    {
        $facultadbd =DB::table('facultad')->select('nombre')->where('estado','=',1)->get();
        return $facultadbd;
    }
    public function llenarFacultadRegistro()
    {
        $facultadbd =DB::table('facultad')->select('nombre')->where('estado','=',1)->get();
        return $facultadbd;
    }

    public function consultarFacultadid($idFacultad)
    {
        $facultadbd = DB::table('facultad')->where('idFacultad', $idFacultad)->get();
        return $facultadbd;
    }

    public function consultarFacultadesCodigo($codigo)
    {
        $facultadbd = DB::table('facultad')
            ->where('codFacultad', 'like','%' . $codigo. '%')
            ->where('estado', 1)->orderBy('idFacultad', 'desc')->get();
        return $facultadbd;
    }

    public function consultarFacultadesNombre($nombre)
    {
        $facultadbd = DB::table('facultad')
            ->where('nombre', 'like', '%' . $nombre . '%')
            ->where('estado', 1)->orderBy('idFacultad', 'desc')->get();
        return $facultadbd;
    }

    public function consultarFacultades()
    {
        $facultadbd = DB::table('facultad')
            ->where('estado', 1)->orderBy('idFacultad', 'desc')->get();
        return $facultadbd;
    }
    public function consultarFacultadesCuentaInterna($nroCuenta)
    {
        $facultadbd = DB::table('facultad')
            ->where('nroCuenta', 'like', '%' . $nroCuenta . '%')
            ->where('estado', 1)->orderBy('idFacultad', 'desc')->get();
        return $facultadbd;
    }

    public function save()
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('registrarFacultad');
        $logunt->setCodigoPersonal($codPers);

        try {
            DB::transaction(function () use ($logunt) {
                DB::table('facultad')->insert(['codFacultad' => $this->codFacultad, 'nombre' => $this->nombre, 'nroCuenta' => $this->nroCuenta]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function editarFacultad($idFacultad)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('editarFacultad');
        $logunt->setCodigoPersonal($codPers);

        try {
            DB::transaction(function () use ($idFacultad,$logunt) {
                DB::table('facultad')->where('idFacultad', $idFacultad)->update(['codFacultad' => $this->codFacultad, 'nombre' => $this->nombre, 'nroCuenta' => $this->nroCuenta]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function eliminarFacultad($idFacultad)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('eliminarFacultad');
        $logunt->setCodigoPersonal($codPers);

        try {
            DB::transaction(function () use ($idFacultad,$logunt) {
                DB::table('facultad')->where('idFacultad', $idFacultad)->update(['estado' => 0]);
                DB::table('escuela')->where('estado', 1)->update(['estado' => 0]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

}
