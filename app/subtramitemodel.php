<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDOException;

class subtramitemodel
{
    private $cuenta;
    private $nombre;
    private $precio;
    private $estado;
    private $idTramite;

    /**
     * subtramitemodel constructor.
     */
    public function __construct()
    {
        $this->pago = array();
    }

    /**
     * @return mixed
     */
    public function getCuenta()
    {
        return $this->cuenta;
    }

    /**
     * @param mixed $cuenta
     * @return subtramitemodel
     */
    public function setCuenta($cuenta)
    {
        $this->cuenta = $cuenta;
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
     * @return subtramitemodel
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * @param mixed $precio
     * @return subtramitemodel
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;
        return $this;
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
     * @return subtramitemodel
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdTramite()
    {
        return $this->idTramite;
    }

    /**
     * @param mixed $idTramite
     * @return subtramitemodel
     */
    public function setIdTramite($idTramite)
    {
        $this->idTramite = $idTramite;
        return $this;
    }

    public function bdTramite($nombre)
    {
        $idTra = DB::select('select codTramite from tramite where nombre=:nombre', ['nombre' => $nombre]);
        foreach ($idTra as $idT) {
            return $id = $idT->codTramite;
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function save()
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('registrarSubtramite');
        $logunt->setCodigoPersonal($codPers);
        try {
            DB::transaction(function () use ($logunt) {
                DB::table('subtramite')->insert(['cuenta' => $this->cuenta, 'nombre' => $this->nombre, 'precio' => $this->precio, 'idTramite' => $this->idTramite]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            return false;

        }
        return true;

    }

    public function editarSubtramite($codSubtramite)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('editarSubtramite');
        $logunt->setCodigoPersonal($codPers);
        try {
            DB::transaction(function () use ($codSubtramite, $logunt) {
                DB::table('subtramite')->where('codSubtramite', $codSubtramite)->update(['cuenta' => $this->cuenta, 'nombre' => $this->nombre, 'precio' => $this->precio]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function consultarSubtramiteid($codSubtramite)
    {
        $subtramitebd = DB::table('subtramite')->where('codSubtramite', $codSubtramite)->get();
        return $subtramitebd;
    }

    public function consultarSubtramiteTramite($nombreTramite)
    {
        $subtramitebd = DB::select('select * from tramite left join subtramite on tramite.codTramite = subtramite.idTramite where 
        tramite.codTramite = subtramite.idTramite and tramite.nombre like "%'.$nombreTramite.'%" and tramite.estado=1 and subtramite.estado=1');
        return $subtramitebd;
    }

    public function consultarSubtramiteNombre($nombreSubtramite)
    {
        $subtramitebd = DB::table('subtramite')
            ->where('nombre','like', '%' . $nombreSubtramite. '%')
            ->where('estado', 1)
            ->orderBy('codSubtramite', 'desc')->get();
        return $subtramitebd;
    }
    public function consultarSubtramiteidNombre($nombreSubtramite)
    {
        $subtramitebd = DB::table('subtramite')
            ->where('nombre', $nombreSubtramite)
            ->where('estado', 1)
            ->get();
        $id=null;
        foreach ($subtramitebd as $su)
        {
            $id=$su->codSubtramite;
        }
        return $id;
    }

    public function consultarSubtramiteCuenta($cuenta)
    {
        $subtramitebd = DB::table('subtramite')
            ->where('cuenta','like', '%' . $cuenta. '%')
            ->where('estado', 1)
            ->orderBy('codSubtramite', 'desc')->get();
        return $subtramitebd;
    }

    public function eliminarSubtramite($codSubtramite)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('eliminarSubtramite');
        $logunt->setCodigoPersonal($codPers);

        try {
            DB::transaction(function () use ($codSubtramite, $logunt) {
                DB::table('subtramite')->where('codSubtramite', $codSubtramite)->update(['estado' => 0]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }


}
