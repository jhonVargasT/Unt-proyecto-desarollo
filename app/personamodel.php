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
    private $val;
    private $campo;
    private $var;

    public function __construct()
    {
        $this-> pago = array();
    }

    /**
     * @return mixed
     */
    public function getVal()
    {
        return $this->val;
    }

    /**
     * @param mixed $val
     * @return personamodel
     */
    public function setVal($val)
    {
        $this->val = $val;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCampo()
    {
        return $this->campo;
    }

    /**
     * @param mixed $campo
     * @return personamodel
     */
    public function setCampo($campo)
    {
        $this->campo = $campo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVar()
    {
        return $this->var;
    }

    /**
     * @param mixed $var
     * @return personamodel
     */
    public function setVar($var)
    {
        $this->var = $var;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getCodPersona()
    {
        return $this->codPersona;
    }

    /**
     * @param mixed $codPersona
     * @return personamodel
     */
    public function setCodPersona($codPersona)
    {
        $this->codPersona = $codPersona;
        return $this;
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
        $idPersona = DB::select('select codPersona from persona where dni=:dni', ['dni' => $vardni]);

        foreach ($idPersona as $ip) {
            $cp = $ip->codPersona;
        }
        return $cp;
    }

    public function save($val,$var)
    {
        if($val=='alumno')
        {
            $oba = DB::select('select * from alumno where codAlumno=:var', ['var' => $var]);
            if($oba!=null)
            {
                return false;
            }
            else{
                DB::table('persona')->insert(['dni' => $this->dni, 'nombres' => $this->nombres, 'apellidos' => $this->apellidos]);

                return true;
            }
        }
        elseif ($val=='cliente')
        {
            $oba = DB::select('select * from cliente where ruc=:var', ['var' => $var]);
            if($oba!=null)
            {
                return false;
            }
            else{
                DB::table('persona')->insert(['dni' => $this->dni, 'nombres' => $this->nombres, 'apellidos' => $this->apellidos]);
            }
        }
        elseif ($val=='personal')
        {
            $oba = DB::select('select * from personal where cuenta=:var', ['var' => $var]);
            if($oba!=null)
            {
                return false;
            }
            else{
                DB::table('persona')->insert(['dni' => $this->dni, 'nombres' => $this->nombres, 'apellidos' => $this->apellidos]);
            }
        }

    }

    public function editarPersona()
    {
        DB::table('persona')->where('dni', $this->dni)->update(['nombres' => $this->nombres, 'apellidos' => $this->apellidos]);
    }

    public function eliminarPersona()
    {
        DB::table('persona')->where('codPersona', $this->codPersona)->update(['estado' => 0]);
        DB::table('alumno')->where('idPersona', $this->codPersona)->update(['estado' => 0]);
    }
}
