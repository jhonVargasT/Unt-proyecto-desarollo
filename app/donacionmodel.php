<?php

namespace App;

use Illuminate\Support\Facades\DB;

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

    public function save()
    {
        $donacion = DB::select('select * from donacion where numResolucion=:numResolucion ', ['numResolucion' => $this->numResolucion]);

        if ($donacion != null) {
            return false;
        } else {
            DB::table('donacion')->insert(['numResolucion' => $this->numResolucion, 'fechaIngreso' => $this->fechaIngreso, 'descripcion' => $this->descripcion, 'monto' => $this->monto, 'idTramite' => $this->idTramite]);
            return true;
        }
    }

    public function editarDonacion($codDonacion)
    {
        DB::table('donacion')->where('codDonacion', $codDonacion)->update(['numeroResolucion' => $this->numResolucion, 'descripcion' => $this->descripcion, 'fechaDeIngreso' => $this->fechaIngreso]);
    }

    public function eliminarDonacion($codDonacion)
    {
        DB::table('donacion')->where('codDonacion', $codDonacion)->update(['estado' => 0]);
    }

    public function consultarDonacionid($codTramite)
    {
        $donacionbd = DB::table('donacion')->where('codDonacion', $codTramite)->get();
        return $donacionbd;
    }

    public function consultarDonacionFecha($fechaIngreso)
    {
        $donacionbd = DB::table('donacion')
            ->where('fechaIngreso', $fechaIngreso)
            ->where('estado', 1)
            ->orderBy('codDonacion', 'desc')->get();
        return $donacionbd;
    }

    public function consultarDonacionCodigoSiaf($clasificador)
    {
        $donacionbd = DB::select('select * from tramite left join donacion on tramite.codTramite = donacion.idTramite where 
        tramite.codTramite = donacion.idTramite and tramite.clasificador=:clasificador and tramite.estado=1 and donacion.estado =1', ['clasificador' => $clasificador]);
        return $donacionbd;
    }

    public function consultarDonacionTipoRecurso($tipoRecurso)
    {
        $donacionbd = DB::select('select * from tramite left join donacion on tramite.codTramite = donacion.idTramite where 
        tramite.codTramite = donacion.idTramite and tramite.tipoRecurso=:tipoRecurso and tramite.estado=1 and donacion.estado =1', ['tipoRecurso' => $tipoRecurso]);
        return $donacionbd;
    }

    public function consultarDonacionFuenteFinanciamiento($fuentefinanc)
    {
        $donacionbd = DB::select('select * from tramite left join donacion on tramite.codTramite = donacion.idTramite where 
        tramite.codTramite = donacion.idTramite and tramite.fuentefinanc=:fuentefinanc and tramite.estado=1 and donacion.estado =1', ['fuentefinanc' => $fuentefinanc]);
        return $donacionbd;
    }

    public function consultarDonacionNumeroResolucion($numResolucion)
    {
        $donacionbd = DB::table('donacion')
            ->where('numResolucion', $numResolucion)
            ->where('estado', 1)
            ->orderBy('codDonacion', 'desc')->get();
        return $donacionbd;
    }
}
