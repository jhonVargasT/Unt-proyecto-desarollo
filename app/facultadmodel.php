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
    private $codSede;

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

    /**
     * @return mixed
     */
    public function getCodSede()
    {
        return $this->codSede;
    }

    /**
     * @param mixed $codSede
     * @return facultadmodel
     */
    public function setCodSede($codSede)
    {
        $this->codSede = $codSede;
        return $this;
    }


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function llenarFacultadReporte($nombre)
    {
        $facultadbd = DB::table('facultad')->select('nombre')->where([['estado', '=', 1], ['nombre', 'like', '%' . $nombre . '%']])->where('nombre')->get();
        return $facultadbd;
    }

    public function llenarFacultadRegistro()
    {
        $facultadbd = DB::table('facultad')->select('nombre')->where('estado', '=', 1)->get();
        return $facultadbd;
    }

    public function consultarFacultadid($idFacultad)
    {
        $facultadbd = DB::select('SELECT idFacultad, codFacultad,nombre, nroCuenta, nombresede FROM facultad 
        LEFT JOIN sede ON facultad.coSede= sede.codSede
        WHERE facultad.coSede= sede.codSede
        and sede.estado=1 and facultad.estado=1 and facultad.idFacultad = ' . $idFacultad . ' ');
        return $facultadbd;
    }

    public function consultarFacultadesCodigo($codigo)
    {
        $facultadbd = DB::select('SELECT idFacultad, codFacultad,nombre, nroCuenta, nombresede FROM facultad 
        LEFT JOIN sede ON facultad.coSede= sede.codSede
        WHERE facultad.coSede= sede.codSede
        and sede.estado=1 and facultad.estado=1 and facultad.codFacultad like "%' . $codigo . '%"');
        return $facultadbd;
    }

    public function consultarFacultadesNombre($nombre)
    {
        $facultadbd = DB::select('SELECT  idFacultad,codFacultad,nombre, nroCuenta, nombresede FROM facultad 
        LEFT JOIN sede ON facultad.coSede= sede.codSede
        WHERE facultad.coSede= sede.codSede
        and sede.estado=1 and facultad.estado=1 and facultad.nombre like "%' . $nombre . '%"');
        return $facultadbd;
    }

    public function consultarFacultades()
    {
        $facultadbd = DB::select('SELECT  idFacultad,codFacultad,nombre, nroCuenta, nombresede FROM facultad 
        LEFT JOIN sede ON facultad.coSede= sede.codSede
        WHERE facultad.coSede= sede.codSede
        and sede.estado=1 and facultad.estado=1');
        return $facultadbd;
    }

    public function consultarFacultadesSede($sede)
    {
        $facultadbd = DB::select('SELECT  idFacultad,codFacultad,nombre, nroCuenta, nombresede FROM facultad LEFT JOIN sede ON facultad.idFacultad = sede.codSede WHERE
        facultad.idFacultad = sede.codSede and sede.nombresede like "%' . $sede . '%" ');
        return $facultadbd;
    }

    public function consultarFacultadesCuentaInterna($nroCuenta)
    {
        $facultadbd = DB::select('SELECT  idFacultad,codFacultad,nombre, nroCuenta, nombresede FROM facultad 
        LEFT JOIN sede ON facultad.coSede= sede.codSede
        WHERE facultad.coSede= sede.codSede
        and sede.estado=1 and facultad.estado=1 and facultad.nroCuenta like "%' . $nroCuenta . '%"');
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
                DB::table('facultad')->insert(['codFacultad' => $this->codFacultad, 'nombre' => $this->nombre, 'nroCuenta' => $this->nroCuenta, 'coSede' => $this->codSede]);
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
            DB::transaction(function () use ($idFacultad, $logunt) {
                DB::table('facultad')->where('idFacultad', $idFacultad)->update(['codFacultad' => $this->codFacultad, 'nombre' => $this->nombre, 'nroCuenta' => $this->nroCuenta, 'coSede' => $this->codSede]);
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
            DB::transaction(function () use ($idFacultad, $logunt) {
                DB::table('facultad')->where('idFacultad', $idFacultad)->update(['estado' => 0]);
                DB::table('escuela')->where('estado', 1)->update(['estado' => 0]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function bscSedeId($nombreSede)
    {
        $scod = null;
        $sedebd = DB::table('sede')->where('nombresede', '=', $nombreSede)->get();

        foreach ($sedebd as $sbd) {
            $scod = $sbd->codSede;
        }
        return $scod;
    }

    public function obtenerId($nombre)
    {
        $scod = null;
        $fac = DB::table('facultad')->select('idFacultad')->where('nombre', '=', $nombre)->get();
        foreach ($fac as $sbd) {
            $scod = $sbd->idFacultad;
        }
        return $scod;
    }

    public function obteneridSede($idsede, $nombrefacu)
    {
        $scod = null;
        $fac = DB::table('facultad')->select('idFacultad')->where('nombre', '=', $nombrefacu)->where('coSede', '=', $idsede)->get();
        foreach ($fac as $sbd) {
            $scod = $sbd->idFacultad;
        }
        return $scod;
    }
}
