<?php

namespace App;

use App\Http\Controllers\util;
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
        try {
            $facultadbd = DB::table('facultad')->select('nombre')->where([['estado', '=', 1], ['nombre', 'like', '%' . $nombre . '%']])->where('nombre')->get();
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'llenarFacultadReporte/facultadmodel');
            return null;
        }
        return $facultadbd;
    }

    /*
    public function llenarFacultadRegistro()
    {
        $facultadbd = DB::table('facultad')->select('nombre')->where('estado', '=', 1)->get();
        return $facultadbd;
    }*/

    public function consultarFacultadid($idFacultad)
    {
        try {
            $facultadbd = DB::select('SELECT idFacultad, codFacultad,nombre, nroCuenta, nombresede FROM facultad 
        LEFT JOIN sede ON facultad.coSede= sede.codSede
        WHERE facultad.coSede= sede.codSede
        and sede.estado=1 and facultad.estado=1 and facultad.idFacultad = ' . $idFacultad . ' ');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarFacultadid/facultadmodel');
            return null;
        }
        return $facultadbd;
    }

    public function consultarFacultadesCodigo($codigo)
    {
        try {
            $facultadbd = DB::select('SELECT idFacultad, codFacultad,nombre, nroCuenta, nombresede FROM facultad 
        LEFT JOIN sede ON facultad.coSede= sede.codSede
        WHERE facultad.coSede= sede.codSede
        and sede.estado=1 and facultad.estado=1 and facultad.codFacultad like "' . $codigo . '%"');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarFacultadesCodigo/facultadmodel');
            return null;
        }
        return $facultadbd;
    }

    public function consultarFacultadesNombre($nombre)
    {
        try {
            $facultadbd = DB::select('SELECT  idFacultad,codFacultad,nombre, nroCuenta, nombresede FROM facultad 
        LEFT JOIN sede ON facultad.coSede= sede.codSede
        WHERE facultad.coSede= sede.codSede
        and sede.estado=1 and facultad.estado=1 and facultad.nombre like "' . $nombre . '%"');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarFacultadesNombre/facultadmodel');
            return null;
        }
        return $facultadbd;
    }

    public function consultarFacultades()
    {
        try {
            $facultadbd = DB::select('SELECT  idFacultad,codFacultad,nombre, nroCuenta, nombresede FROM facultad 
        LEFT JOIN sede ON facultad.coSede= sede.codSede
        WHERE facultad.coSede= sede.codSede
        and sede.estado=1 and facultad.estado=1');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarFacultadesNombre/facultadmodel');
            return null;
        }
        return $facultadbd;
    }

    public function consultarFacultadesSede($sede)
    {
        try {
            $facultadbd = DB::select('SELECT  idFacultad,codFacultad,nombre, nroCuenta, nombresede FROM facultad LEFT JOIN sede ON facultad.coSede = sede.codSede WHERE
        sede.nombresede like "' . $sede . '%" ');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarFacultadesSede/facultadmodel');
            return null;
        }
        return $facultadbd;
    }

    public function consultarFacultadesCuentaInterna($nroCuenta)
    {
        try {
            $facultadbd = DB::select('SELECT  idFacultad,codFacultad,nombre, nroCuenta, nombresede FROM facultad 
        LEFT JOIN sede ON facultad.coSede= sede.codSede
        WHERE facultad.coSede= sede.codSede
        and sede.estado=1 and facultad.estado=1 and facultad.nroCuenta like "' . $nroCuenta . '%"');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarFacultadesCuentaInterna/facultadmodel');
            return null;
        }
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
            $util = new util();
            $util->insertarError($e->getMessage(), 'save/facultadmodel');
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
            $util = new util();
            $util->insertarError($e->getMessage(), 'editarFacultad/facultadmodel');
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
            $util = new util();
            $util->insertarError($e->getMessage(), 'eliminarFacultad/facultadmodel');
            return false;
        }
        return true;
    }

    public function bscSedeId($nombresede)
    {
        try {
            $scod = null;
            $sedebd = DB::table('sede')->where('nombresede', '=', $nombresede)->get();

            foreach ($sedebd as $sbd) {
                $scod = $sbd->codSede;
            }
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'eliminarFacultad/facultadmodel');
            return null;
        }
        return $scod;
    }

    public function obtenerId($nombre)
    {
        try {
            $scod = null;
            $fac = DB::table('facultad')->select('idFacultad')->where('nombre', '=', $nombre)->get();
            foreach ($fac as $sbd) {
                $scod = $sbd->idFacultad;
            }
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'eliminarFacultad/facultadmodel');
            return null;
        }
        return $scod;
    }

    public function obteneridSede($idsede, $nombrefacu)
    {
        try {
            $scod = null;
            $fac = DB::table('facultad')->select('idFacultad')->where('nombre', '=', $nombrefacu)->where('coSede', '=', $idsede)->get();
            foreach ($fac as $sbd) {
                $scod = $sbd->idFacultad;
            }
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'eliminarFacultad/facultadmodel');
            return null;
        }
        return $scod;
    }
}
