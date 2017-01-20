<?php

namespace App;

class donacionmodel
{
    private $numResolucion;
    private $fechaIngreso;
    private $descripcion;
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
        $idTra = DB::select('select idTramite from tramite where nombre=:nombre',['nombre'=>$nombre]);
        foreach ($idTra as $idT)
        {
            $id= $idT->idFacultad;
        }
        return $id;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function save(){
        $save =DB::table('donacion')->insert(['numResolucion' => $this->numResolucion, 'fechaIngreso' => $this->fechaIngreso, 'descripcion'=>$this->descripcion, 'idTramite'=>$this->idTramite]);
        return $save;
    }

    public function editarDonacion($numeroResoulucion,$descripcion,$fechaDeIngreso)
    {
        $donacioncod =  DB::select('select codTramite from donacion where numeroResolucion=:numeroResolucion',['numeroResolucion'=>$numeroResoulucion]);

        foreach ($donacioncod as $donacion)
        {
            $docd =$donacion-> codTramite;
        }

        $tramitecod= DB::select('select codTramite from tramite left join donacion on tramite.codTramite = donacion.idTramite where donacion.numeroResoulucion=:numeroResoulucion',['dni'=>$numeroResoulucion]);

        foreach ($tramitecod as $tramites)
        {
            $tr = $tramites -> codTramite;
        }

        DB::table('donacion')->where('codDonacion', $docd)->update(['numeroResolucion' => $numeroResoulucion, 'descripcion'=>$descripcion,'fechaDeIngreso'=>$fechaDeIngreso,'idTramite'=>$tr]);
    }

    public function eliminarDonacion($numeroResoulucion)
    {
        $donacioncod =  DB::select('select codTramite from donacion where numeroResolucion=:numeroResolucion',['numeroResolucion'=>$numeroResoulucion]);

        foreach ($donacioncod as $donacion)
        {
            $docd =$donacion-> codTramite;
        }

        DB::table('donacion')->where('codDonacion', $docd)->update(['estado' => 0]);
    }

    public function consultarDonacion()
    {

    }

    public function consultarDonacionFecha()
    {

    }

    public function consularDonacionTramite()
    {

    }

    public function consultarDonacionTipoRecurso()
    {

    }

    public function consultarDonacionNumeroResolucion($numeroResolucion)
    {

    }

    public function imprimirReportesDetallados()
    {

    }

    public function imprimirReportesResumido()
    {

    }






}
