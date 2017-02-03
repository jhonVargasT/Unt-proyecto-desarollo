<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDOException;

class tramitemodel
{
    private $clasificador;
    private $nombre;
    private $fuentefinanc;
    private $tipoRecurso;
    private $estado;

    /**
     * tramitemodel constructor.
     */
    public function __construct()
    {
        $this->subtramites = array();
        $this->donacion = array();
    }

    /**
     * @return mixed
     */
    public function getClasificador()
    {
        return $this->clasificador;
    }

    /**
     * @param mixed $clasificador
     * @return tramitemodel
     */
    public function setClasificador($clasificador)
    {
        $this->clasificador = $clasificador;
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
     * @return tramitemodel
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFuentefinanc()
    {
        return $this->fuentefinanc;
    }

    /**
     * @param mixed $funtefinanc
     * @return tramitemodel
     */
    public function setFuentefinanc($fuentefinanc)
    {
        $this->fuentefinanc = $fuentefinanc;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTipoRecurso()
    {
        return $this->tipoRecurso;
    }

    /**
     * @param mixed $tipoRecurso
     * @return tramitemodel
     */
    public function setTipoRecurso($tipoRecurso)
    {
        $this->tipoRecurso = $tipoRecurso;
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
     * @return tramitemodel
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
        return $this;
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function consultarTramiteFF($ff)
    {
        $tramitebd = DB::table('tramite')
            ->where('fuentefinanc', $ff)
            ->where('estado', 1)
            ->orderBy('codTramite', 'desc')->get();
        return $tramitebd;
    }

    public function consultarTramiteCS($cs)
    {
        $tramitebd = DB::table('tramite')
            ->where('clasificador', $cs)
            ->where('estado', 1)
            ->orderBy('codTramite', 'desc')->get();
        return $tramitebd;
    }

    public function consultarTramiteTR($tr)
    {
        $tramitebd = DB::table('tramite')
            ->where('tipoRecurso', $tr)
            ->where('estado', 1)
            ->orderBy('codTramite', 'desc')->get();
        return $tramitebd;
    }

    public function consultarTramiteN($nombre)
    {
        $tramitebd = DB::table('tramite')
            ->where('nombre', $nombre)
            ->where('estado', 1)
            ->orderBy('codTramite', 'desc')->get();
        return $tramitebd;
    }

    public function consultarTramiteid($codTramite)
    {
        $tramitebd = DB::table('tramite')->where('codTramite', $codTramite)->get();
        return $tramitebd;
    }

    public function save()
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('registrarTramite');
        $logunt->setCodigoPersonal($codPers);

        try {
            DB::transaction(function () use ($logunt) {
                DB::table('tramite')->insert(['clasificador' => $this->clasificador, 'nombre' => $this->nombre, 'fuentefinanc' => $this->fuentefinanc, 'tipoRecurso' => $this->tipoRecurso]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function editarTramite($codTramite)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('editarTramite');
        $logunt->setCodigoPersonal($codPers);

        try {
            DB::transaction(function () use ($codTramite,$logunt) {
                DB::table('tramite')->where('codTramite', $codTramite)->update(['clasificador' => $this->clasificador, 'nombre' => $this->nombre, 'fuentefinanc' => $this->fuentefinanc, 'tipoRecurso' => $this->tipoRecurso]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function eliminarTramite($codTramite)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('eliminarTramite');
        $logunt->setCodigoPersonal($codPers);

        try {
            DB::transaction(function () use ($codTramite,$logunt) {
                DB::table('tramite')->where('codTramite', $codTramite)->update(['estado' => 0]);
                DB::table('subtramite')->where('estado', 1)->update(['estado' => 0]);
                DB::table('donacion')->where('estado', 1)->update(['estado' => 0]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }
}
