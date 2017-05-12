<?php
namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
                DB::table('produccion')->insert(['nombre' => $this->getNombre(), 'direccion' => $this->getDirecion()]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function consultarProduccionid($codProduccion)
    {
        $produccionbd = DB::select('select * from produccion where codProduccion = ' . $codProduccion . ' ');
        return $produccionbd;
    }

    public function editarProduccion($codProduccion)
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
            return false;
        }
        return true;
    }

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
            return false;
        }
        return true;
    }

    public function consultarProduccion()
    {
        $produccionbd = DB::select('select * from produccion');
        return $produccionbd;
    }

    public function consultarProduccionxNombre($nombre)
    {
        $produccionbd = DB::select('select * from produccion where nombre like "%' . $nombre . '%"');
        return $produccionbd;
    }

    public function consultarProduccionxDireccion($direccion)
    {
        $produccionbd = DB::select('select * from produccion where direccion like "%' . $direccion . '%"');
        return $produccionbd;
    }

}