<?php

namespace App;

class pagomodel
{
  private $lugar;
  private $detalle;
  private $fecha;
  private $idPersona;
  private $idTramite;


    /**
     * pagomodel constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getLugar()
    {
        return $this->lugar;
    }

    /**
     * @param mixed $lugar
     * @return pagomodel
     */
    public function setLugar($lugar)
    {
        $this->lugar = $lugar;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDetalle()
    {
        return $this->detalle;
    }

    /**
     * @param mixed $detalle
     * @return pagomodel
     */
    public function setDetalle($detalle)
    {
        $this->detalle = $detalle;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     * @return pagomodel
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdPersona()
    {
        return $this->idPersona;
    }

    /**
     * @param mixed $idPersona
     * @return pagomodel
     */
    public function setIdPersona($idPersona)
    {
        $this->idPersona = $idPersona;
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
     * @return pagomodel
     */
    public function setIdTramite($idTramite)
    {
        $this->idTramite = $idTramite;
        return $this;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


}
