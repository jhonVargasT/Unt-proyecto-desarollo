<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDOException;
use App\Http\Controllers\util;

class sedemodel
{
    private $codSede;
    private $codigoSede;
    private $nombreSede;
    private $direccion;

    /**
     * sedemodel constructor.
     */
    public function __construct()
    {

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
     * @return sedemodel
     */
    public function setCodSede($codSede)
    {
        $this->codSede = $codSede;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodigoSede()
    {
        return $this->codigoSede;
    }

    /**
     * @param mixed $codigoSede
     * @return sedemodel
     */
    public function setCodigoSede($codigoSede)
    {
        $this->codigoSede = $codigoSede;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNombreSede()
    {
        return $this->nombreSede;
    }

    /**
     * @param mixed $nombreSede
     * @return sedemodel
     */
    public function setNombreSede($nombreSede)
    {
        $this->nombreSede = $nombreSede;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $direccion
     * @return sedemodel
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
        return $this;
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
        $logunt->setDescripcion('registrarSede');
        $logunt->setCodigoPersonal($codPers);

        try {

            DB::transaction(function () use ($logunt) {
                DB::table('sede')->insert(['codigosede' => $this->codigoSede, 'nombresede' => $this->nombreSede, 'direccion' => $this->direccion]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'save/sedemodel');
            return false;
        }
        return true;
    }

    public function consultarSedeid($codSede)
    {
        try {
            $sedebd = DB::table('sede')->where('codSede', $codSede)->get();
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'save/sedemodel');
            return null;
        }
        return $sedebd;
    }

    public function editarSede($codSede)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('editarSede');
        $logunt->setCodigoPersonal($codPers);

        try {
            DB::transaction(function () use ($codSede, $logunt) {
                DB::table('sede')->where('codSede', $codSede)->update(['codigosede' => $this->codigoSede, 'nombresede' => $this->nombreSede, 'direccion' => $this->direccion]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'editarSede/sedemodel');
            return false;
        }
        return true;
    }

    public function eliminarSede($codSede)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('eliminarSede');
        $logunt->setCodigoPersonal($codPers);

        try {
            DB::transaction(function () use ($codSede, $logunt) {
                DB::table('sede')->where('codSede', $codSede)->update(['estado' => 0]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'eliminarSede/sedemodel');
            return false;
        }
        return true;
    }

    public function consultarSedeNombre($nombre)
    {
        try {
            $sedebd = DB::table('sede')
                ->where('nombresede', 'like', '' . $nombre . '%')
                ->where('estado', 1)->orderBy('codSede', 'desc')->get();
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarSedeNombre(/sedemodel');
            return null;
        }
        return $sedebd;
    }

    public function consultarSedeCodigo($codigo)
    {
        try {
            $sedebd = DB::table('sede')
                ->where('codigosede', 'like', '' . $codigo . '%')
                ->where('estado', 1)->orderBy('codSede', 'desc')->get();
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarSedeNombre(/sedemodel');
            return null;
        }
        return $sedebd;
    }

    public function consultarSedeDireccion($direccion)
    {
        try {
            $sedebd = DB::table('sede')
                ->where('direccion', 'like', '' . $direccion . '%')
                ->where('estado', 1)->orderBy('codSede', 'desc')->get();
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarSedeNombre(/sedemodel');
            return null;
        }
        return $sedebd;
    }

    public function consultarSedes()
    {
        try {
            $sedebd = DB::table('sede')
                ->where('estado', 1)->orderBy('codSede', 'desc')->get();
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarSedeNombre(/sedemodel');
            return null;
        }
        return $sedebd;
    }

    public function obtenerId($nombre)
    {
        try {

            $data = DB::table('sede')->select('codSede')->where('nombresede', '=', $nombre)->get();
            $var = null;
            foreach ($data as $c) {
                $var = $c->codSede;
            }
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarSedeNombre(/sedemodel');
            return null;
        }
        return $var;
    }
}
