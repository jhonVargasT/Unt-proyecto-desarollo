<?php

namespace App;

use Illuminate\Support\Facades\DB;

class personamodel
{
    private $codPersona;
    private $dni;
    private $nombres;
    private $apellidos;
    private $pago;

    public function __construct()
    {
        $this-> pago = array();
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

    /**
     * @return mixed
     */

    public function obtenerCod($vardni)
    {
        $idPersona = DB::select('select codPersona from persona where dni=:dni',['dni'=>$vardni]);

        foreach ($idPersona as $ip)
        {
            $cp= $ip->codPersona;
        }
        return $cp;
    }

    public function save(){
        $save =DB::table('persona')->insert(['dni' => $this->dni, 'nombres' => $this->nombres, 'apellidos'=>$this->apellidos]);

        return $save;
    }
}
