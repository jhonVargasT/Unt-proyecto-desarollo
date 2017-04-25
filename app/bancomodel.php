<?php

namespace App;

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
}