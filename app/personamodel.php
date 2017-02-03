<?php

namespace App;
use Illuminate\Support\Facades\DB;
class personamodel
{
    private $dni;
    private $nombres;
    private $apellidos;

    public function __construct()
    {
        $this->pago = array();
    }

    /**
     * @return array
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * @param array $dni
     * @return personamodel
     */
    public function setDni($dni)
    {
        $this->dni = $dni;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * @param mixed $nombres
     * @return personamodel
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * @param mixed $apellidos
     * @return personamodel
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
        return $this;
    }
    public function obtnerId($idPersona)
    {
        /* Jhon Vargas*/
        $persona=DB::table('persona')->where(['codPersona'=>$idPersona,'estado'=>1])->get();
        return $persona;
    }
}
