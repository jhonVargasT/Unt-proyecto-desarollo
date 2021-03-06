<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDOException;
use App\Http\Controllers\util;

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

    public function consultarId($nombre)
    {
        $val = null;
        $tramiteDB = DB::table('tramite')
            ->select('codTramite as codigo')
            ->where('nombre', '=', $nombre)
            ->first();
        foreach ($tramiteDB as $tr) {
            $val = $tr;
        }
        return $val;
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

    public function consultarTramites()
    {
        try {
            $tramitebd = DB::table('tramite')
                ->where('estado', 1)
                ->orderBy('codTramite', 'desc')->get();

        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarTramite/tramitemodel');
            return null;
        }
        return $tramitebd;

    }

    public function consultarNombre($nombre)
    {
        try {
            $tramitebd = DB::table('tramite')->select('codPago')
                ->where('nombre', $nombre)
                ->where('estado', 1)->first();
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarNombre/tramitemodel');
            return null;
        }
        return $tramitebd;
    }

    public function consultarTramiteFF($ff)
    {
        try {
            $tramitebd = DB::table('tramite')
                ->where('fuentefinanc', 'like', '' . $ff . '%')
                ->where('estado', 1)
                ->orderBy('codTramite', 'desc')->get();
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarTramiteFF/tramitemodel');
            return null;
        }
        return $tramitebd;
    }

    public function consultarTramiteCS($cs)
    {
        try {
            $tramitebd = DB::table('tramite')
                ->where('clasificador', 'like', '' . $cs . '%')
                ->where('estado', 1)
                ->orderBy('codTramite', 'desc')->get();
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), ' consultarTramiteCS/tramitemodel');
            return null;
        }
        return $tramitebd;
    }

    public function consultarTramiteTR($tr)
    {
        try {
            $tramitebd = DB::table('tramite')
                ->where('tipoRecurso', 'like', '' . $tr . '%')
                ->where('estado', 1)
                ->orderBy('codTramite', 'desc')->get();
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarTramiteTR/tramitemodel');
            return null;
        }
        return $tramitebd;
    }

    public function consultarTramiteN($nombre)
    {
        try {
        $tramitebd = DB::table('tramite')
            ->where('nombre', 'like', '' . $nombre . '%')
            ->where('estado', 1)
            ->orderBy('codTramite', 'desc')->get();
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarTramiteN/tramitemodel');
            return null;
        }
        return $tramitebd;
    }

    public function consultarTramiteid($codTramite)
    {
        try {
        $tramitebd = DB::table('tramite')->where('codTramite', $codTramite)->get();
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarTramiteid/tramitemodel');
            return null;
        }
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
            $util = new util();
            $util->insertarError($e->getMessage(), 'save/tramitemodel');
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
            DB::transaction(function () use ($codTramite, $logunt) {
                DB::table('tramite')
                    ->where('codTramite', $codTramite)
                    ->update(['clasificador' => $this->clasificador, 'nombre' => $this->nombre, 'fuentefinanc' => $this->fuentefinanc, 'tipoRecurso' => $this->tipoRecurso]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'editarTramite/tramitemodel');
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
            DB::transaction(function () use ($codTramite, $logunt) {
                DB::table('tramite')->where('codTramite', $codTramite)->update(['estado' => 0]);
                DB::table('subtramite')->where('estado', 1)->update(['estado' => 0]);
                DB::table('donacion')->where('estado', 1)->update(['estado' => 0]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'eliminarTramite/tramitemodel');
            return false;
        }
        return true;
    }

    /*public function consultarTramiteNombre($nombre)
    {
        $tramitebd = DB::table('tramite')->select('nombre')
            ->where('tipoRecurso','like','%'. $nombre.'%')
            ->where('estado', 1)
           ->get();
        return $tramitebd;
    }*/
}
