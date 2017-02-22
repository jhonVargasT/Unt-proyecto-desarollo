<?php

namespace App;

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

    public function bdTramite($nombre)
    {
        $idTra = DB::select('select codTramite from tramite where nombre=:nombre', ['nombre' => $nombre]);
        foreach ($idTra as $idT) {
            return $idTramite = $idT->codTramite;
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function saveDonacion()
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('registrarDonaciones');
        $logunt->setCodigoPersonal($codPers);

        try {
            DB::transaction(function () use($logunt){
                DB::table('donacion')->insert(['numResolucion' => $this->numResolucion, 'fechaIngreso' => $this->fechaIngreso, 'descripcion' => $this->descripcion, 'monto' => $this->monto, 'idTramite' => $this->idTramite]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
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
            DB::transaction(function () use ($codDonacion,$logunt) {
                DB::table('donacion')->where('codDonacion', $codDonacion)->update(['numResolucion' => $this->numResolucion, 'descripcion' => $this->descripcion, 'fechaIngreso' => $this->fechaIngreso, 'monto'=>$this->monto]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
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
            DB::transaction(function () use ($codDonacion,$logunt) {
                DB::table('donacion')->where('codDonacion', $codDonacion)->update(['estado' => 0]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function consultarDonacionid($codTramite)
    {
        $donacionbd = DB::table('donacion')->where('codDonacion', $codTramite)->get();
        return $donacionbd;
    }

    public function consultarDonacionFecha($fechaIngreso)
    {
        $donacionbd = DB::select('select * from tramite left join donacion on tramite.codTramite = donacion.idTramite where 
        tramite.codTramite = donacion.idTramite and donacion.fechaIngreso like "%'.$fechaIngreso.'%" and tramite.estado=1 and donacion.estado =1');
        return $donacionbd;
    }

    public function consultarDonacionTramite($nombre)
    {
        $donacionbd = DB::select('select * from tramite left join donacion on tramite.codTramite = donacion.idTramite where 
        tramite.codTramite = donacion.idTramite and tramite.nombre like "%'.$nombre.'%" and tramite.estado=1 and donacion.estado =1');
        return $donacionbd;
    }

    public function consultarDonacionTipoRecurso($tipoRecurso)
    {
        $donacionbd = DB::select('select * from tramite left join donacion on tramite.codTramite = donacion.idTramite where 
        tramite.codTramite = donacion.idTramite and tramite.tipoRecurso like "%'.$tipoRecurso.'%" and tramite.estado=1 and donacion.estado =1');
        return $donacionbd;
    }

    public function consultarDonacionFuenteFinanciamiento($fuentefinanc)
    {
        $donacionbd = DB::select('select * from tramite left join donacion on tramite.codTramite = donacion.idTramite where 
        tramite.codTramite = donacion.idTramite and tramite.fuentefinanc like "%'.$fuentefinanc.'%" and tramite.estado=1 and donacion.estado =1');
        return $donacionbd;
    }

    public function consultarDonacionNumeroResolucion($numResolucion)
    {
        $donacionbd = DB::select('select * from tramite left join donacion on tramite.codTramite = donacion.idTramite where 
        tramite.codTramite = donacion.idTramite and donacion.numResolucion like "%'.$numResolucion.'%" and tramite.estado=1 and donacion.estado =1');
        return $donacionbd;
    }
}
