<?php

namespace App;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\util;

class personamodel
{
    private $dni;
    private $nombres;
    private $apellidos;
    private $correo;
    private $produccion;

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

    /**
     * @return mixed
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * @param mixed $correo
     * @return personamodel
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProduccion()
    {
        return $this->produccion;
    }

    /**
     * @param mixed $produccion
     * @return personamodel
     */
    public function setProduccion($produccion)
    {
        $this->produccion = $produccion;
        return $this;
    }


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function obtnerId($idPersona)
    {
        /* Jhon Vargas*/
        try {
            $persona = DB::table('persona')->where(['codPersona' => $idPersona, 'estado' => 1])->get();
        } catch (Exception $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'obtnerId/personalmodel');
            return null;

        }
        return $persona;
    }

    public function obtnerIdDni($dni)
    {
        /* Jhon Vargas*/
        try {
            $cp = null;
            $persona = DB::table('persona')->where(['dni' => $dni, 'estado' => 1])->get();
            foreach ($persona as $p) {
                $cp = $p->codPersona;
            }
        }catch (Exception $e)
        {
            $util = new util();
            $util->insertarError($e->getMessage(), 'obtnerIdDni/personalmodel');
            return null;
        }
        return $cp;
    }

    public function obtnerIdNombre($nombres)
    {
        try {
            $cp = null;
            $persona = DB::table('persona')->where(['nombres' => $nombres, 'estado' => 1])->get();
            foreach ($persona as $p) {
                $cp = $p->codPersona;
            }
        }catch (Exception $e)
        {
            $util = new util();
            $util->insertarError($e->getMessage(), 'obtnerIdNombre/personalmodel');
            return null;
        }
        return $cp;
    }
}
