<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDOException;

class bancomodel
{
    private $idBanco;
    private $nombreBanco;
    private $nroCuenta;

    /**
     * bancomodel constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getIdBanco()
    {
        return $this->idBanco;
    }

    /**
     * @param mixed $idBanco
     * @return bancomodel
     */
    public function setIdBanco($idBanco)
    {
        $this->idBanco = $idBanco;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNombreBanco()
    {
        return $this->nombreBanco;
    }

    /**
     * @param mixed $nombreBanco
     * @return bancomodel
     */
    public function setNombreBanco($nombreBanco)
    {
        $this->nombreBanco = $nombreBanco;
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
     * @return bancomodel
     */
    public function setNroCuenta($nroCuenta)
    {
        $this->nroCuenta = $nroCuenta;
        return $this;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function guardarBanco()
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('registrarBanco');
        $logunt->setCodigoPersonal($codPers);

        try {
            DB::transaction(function () use ($logunt) {
                DB::table('banco')->insert(['banco' => $this->nombreBanco, 'cuenta' => $this->nroCuenta]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function consultarBancoid($codBanco)
    {
        $sedebd = DB::table('banco')->where('codBanco', $codBanco)->get();
        return $sedebd;
    }

    public function editarBanco($codBanco)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('editarBanco');
        $logunt->setCodigoPersonal($codPers);
        try {
            DB::transaction(function () use ($codBanco, $logunt) {
                DB::table('banco')->where('codBanco', $codBanco)->update(['banco' => $this->nombreBanco, 'cuenta' => $this->nroCuenta]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function eliminarBanco($codBanco)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('eliminarBanco');
        $logunt->setCodigoPersonal($codPers);

        try {
            DB::transaction(function () use ($codBanco, $logunt) {
                DB::table('banco')->where('codBanco', $codBanco)->update(['estado' => 0]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function consultarBancoxNombre($nombreBanco)
    {
        $bancobd = DB::select('select * from banco  where banco= "' . $nombreBanco . '" ');

        return $bancobd;
    }

    public function consultarBancoxCuenta($cuenta)
    {
        $bancobd = DB::select('select * from banco  where cuenta= ' . $cuenta . ' ');

        return $bancobd;
    }

    public function consultarBancos()
    {
        $bancobd = DB::select('select * from banco');

        return $bancobd;
    }
}