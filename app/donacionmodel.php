<?php

namespace App;

use App\Http\Controllers\util;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDOException;

class donacionmodel
{
    private $numResolucion;
    private $fechaIngreso;
    private $descripcion;
    private $monto;
    private $estado;
    private $idTramite;
    private $idBanco;

    /**
     * donacionmodel constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getNumResolucion()
    {
        return $this->numResolucion;
    }

    /**
     * @param mixed $numResolucion
     * @return donacionmodel
     */
    public function setNumResolucion($numResolucion)
    {
        $this->numResolucion = $numResolucion;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFechaIngreso()
    {
        return $this->fechaIngreso;
    }

    /**
     * @param mixed $fechaIngreso
     * @return donacionmodel
     */
    public function setFechaIngreso($fechaIngreso)
    {
        $this->fechaIngreso = $fechaIngreso;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     * @return donacionmodel
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * @param mixed $monto
     * @return donacionmodel
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;
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
     * @return donacionmodel
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
     * @return donacionmodel
     */
    public function setIdTramite($idTramite)
    {
        $this->idTramite = $idTramite;
        return $this;
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
     * @return donacionmodel
     */
    public function setIdBanco($idBanco)
    {
        $this->idBanco = $idBanco;
        return $this;
    }

    public function bdTramite($nombre)
    {
        $idTramite = null;
        try {
            $idTra = DB::select('select codTramite from tramite where nombre=:nombre', ['nombre' => $nombre]);
            foreach ($idTra as $idT) {
                $idTramite = $idT->codTramite;
            }
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'bdTramite/donacionmodel');
            return null;
        }
        return $idTramite;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function saveDonacion()
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d ');
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('registrarDonaciones');
        $logunt->setCodigoPersonal($codPers);

        try {
            DB::transaction(function () use ($logunt) {

                DB::table('donacion')->insert(['numResolucion' => $this->numResolucion, 'fechaIngreso' => $this->fechaIngreso, 'descripcion' => $this->descripcion, 'monto' => $this->monto, 'idTramite' => $this->idTramite, 'idBanco' => $this->idBanco]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'saveDonacion/donacionmodel');
            return false;
        }
        return true;
    }

    public function editarDonacion($codDonacion)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('editarDonacion');
        $logunt->setCodigoPersonal($codPers);
        try {
            DB::transaction(function () use ($codDonacion, $logunt) {
                DB::table('donacion')->where('codDonacion', $codDonacion)->update(['numResolucion' => $this->numResolucion, 'fechaIngreso' => $this->fechaIngreso, 'descripcion' => $this->descripcion, 'monto' => $this->monto, 'idTramite' => $this->idTramite, 'idBanco' => $this->idBanco]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'editarDonacion/donacionmodel');
            return false;
        }
        return true;
    }

    public function eliminarDonacion($codDonacion)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('eliminarDonacion');
        $logunt->setCodigoPersonal($codPers);
        try {
            DB::transaction(function () use ($codDonacion, $logunt) {
                DB::table('donacion')->where('codDonacion', $codDonacion)->update(['estado' => 0]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'eliminarDonacion/donacionmodel');
            return false;
        }
        return true;
    }

    public function consultarDonacionid($codDonacion)
    {
        try {
            $donacionbd = DB::select('SELECT codDonacion, numResolucion, fechaIngreso,descripcion,monto,tramite.nombre as tnombre, tipoRecurso, banco.cuenta as bcuenta FROM donacion LEFT JOIN tramite ON tramite.codTramite = donacion.idTramite LEFT JOIN
        banco ON banco.codBanco = donacion.idBanco WHERE donacion.codDonacion = ' . $codDonacion . ' AND donacion.estado = 1 AND tramite.estado = 1
        AND banco.estado=1');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarDonacionid/donacionmodel');
            return null;
        }
        return $donacionbd;
    }

    public function consultarDonacionFecha($fechaIngreso)
    {
        try {
            $donacionbd = DB::select('select * from tramite left join donacion on tramite.codTramite = donacion.idTramite where 
        tramite.codTramite = donacion.idTramite and donacion.fechaIngreso like "%' . $fechaIngreso . '%" and tramite.estado=1 and donacion.estado =1');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarDonacionFecha/donacionmodel');
            return null;
        }
        return $donacionbd;
    }

    public function consultarDonacionTramite($nombre)
    {
        try {
            $donacionbd = DB::select('select * from tramite left join donacion on tramite.codTramite = donacion.idTramite where 
        tramite.codTramite = donacion.idTramite and tramite.nombre like "%' . $nombre . '%" and tramite.estado=1 and donacion.estado =1');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarDonacionTramite/donacionmodel');
            return null;
        }
        return $donacionbd;
    }

    public function consultarDonacionTipoRecurso($tipoRecurso)
    {
        try {
            $donacionbd = DB::select('select * from tramite left join donacion on tramite.codTramite = donacion.idTramite where 
        tramite.codTramite = donacion.idTramite and tramite.tipoRecurso like "%' . $tipoRecurso . '%" and tramite.estado=1 and donacion.estado =1');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarDonacionTipoRecurso/donacionmodel');
            return null;
        }
        return $donacionbd;
    }

    public function consultarDonacionFuenteFinanciamiento($fuentefinanc)
    {
        try {
            $donacionbd = DB::select('select * from tramite left join donacion on tramite.codTramite = donacion.idTramite where 
        tramite.codTramite = donacion.idTramite and tramite.fuentefinanc like "%' . $fuentefinanc . '%" and tramite.estado=1 and donacion.estado =1');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarDonacionFuenteFinanciamiento/donacionmodel');
            return null;
        }
        return $donacionbd;
    }

    public function consultarDonacionNumeroResolucion($numResolucion)
    {
        try {
            $donacionbd = DB::select('select * from tramite left join donacion on tramite.codTramite = donacion.idTramite where 
        tramite.codTramite = donacion.idTramite and donacion.numResolucion like "%' . $numResolucion . '%" and tramite.estado=1 and donacion.estado =1');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarDonacionNumeroResolucion/donacionmodel');
            return null;
        }
        return $donacionbd;
    }

    public function consultarDonaciones($fecha)

    {
        try {
            $donacionbd = DB::select('SELECT d.codDonacion as codigo ,d.numResolucion,b.banco,b.cuenta,t.nombre,d.fechaIngreso,d.descripcion,d.monto as importe FROM donacion d  
          left join tramite t on t.codTramite=d.idtramite 
          left join banco b on b.codBanco=d.idBanco ' . $fecha . ' and d.estado=1');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarDonaciones/donacionmodel');
            return null;
        }
        return $donacionbd;
    }


    public function obteneridBanco($cuenta)
    {
        $idb = null;
        try {
            $bancobd = DB::select('select codBanco from banco where cuenta= "' . $cuenta . '" and estado =1');

            foreach ($bancobd as $b) {
                $idb = $b->codBanco;
            }
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'obteneridBanco/donacionmodel');
            return null;
        }
        return $idb;
    }
}
