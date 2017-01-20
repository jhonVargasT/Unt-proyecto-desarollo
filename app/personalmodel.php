<?php

namespace App;

use Illuminate\Support\Facades\DB;

class personalmodel extends personamodel
{
    private $cuenta;
    private $password;
    private $tipoCuenta;

    function __construct() {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getCuenta()
    {
        return $this->cuenta;
    }

    /**
     * @param mixed $cuenta
     * @return personalemodel
     */
    public function setCuenta($cuenta)
    {
        $this->cuenta = $cuenta;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return personalemodel
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTipoCuenta()
    {
        return $this->tipoCuenta;
    }

    /**
     * @param mixed $tipoCuenta
     * @return personalemodel
     */
    public function setTipoCuenta($tipoCuenta)
    {
        $this->tipoCuenta = $tipoCuenta;
        return $this;
    }

    public function logear()
    {
        $personal = DB::select('select nombres, apellidos from persona right join personal on persona.codPersona=personal.idPersona where personal.cuenta=:cuenta and personal.password=:pass',
            ['cuenta' => $this->cuenta , 'pass'=>$this->password]);

        return $personal;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function consultarPersonales()
    {
        $personal = DB::select('select * from persona right join personal on persona.codPersona=personal.idPersona');

        foreach ($personal as $perso)
        {
            $per = $perso->todoslosatributos;
        }

        return $per;
    }

    public function extraerCodigoPersonal($dni)
    {
        $personal = DB::select('select codPersonal from personal right join persona on personal.idPersona=persona.codPersona where persona.dni=:dni',['dni'=>$dni]);

        foreach ($personal as $perso)
        {
            $per = $perso->codPersonal;
        }

        return $per;
    }

    public function save(){
        $save= DB::table('personal')->insert(['cuenta' => $this->cuenta, 'password' => $this->password, 'tipoCuenta' => $this->tipoCuenta, 'idPersona' => $this->getDni()]);
        return $save;
        }

    public function consultarPersonal($idPersonal)
    {
        $personal = DB::select('select * from personal right join persona on personal.idPersona=persona.codPersona where personal.codPersonal=:codPersonal',['codPersonal'=>$idPersonal]);

        foreach ($personal as $persona)
        {
            $per = $persona->todoslosatributos;
        }

        return $per;
    }

    public function editarPersonal($dni,$nombres,$apellidos,$cuenta,$password,$tipoCuenta)
    {
        $personacp= DB::select('select codPersona from persona left join alumno on persona.codPersona = alumno.idPersona where persona.dni=:dni',['dni'=>$dni]);

        foreach ($personacp as $persona)
        {
            $per = $persona-> codPersona;
        }

        DB::table('persona')->where('codPersona', $per)->update(['nombres' => $nombres, 'apellidos'=>$apellidos]);
        DB::table('personal')->where('idPersona', $per)->update(['cuenta' => $cuenta, 'password'=>$password, 'tipoCuenta'=>$tipoCuenta]);
    }

    public function eliminarPersona($dni)
    {
        $personace= DB::select('select codPersona from persona left join alumno on persona.codPersona = alumno.idPersona where persona.dni=:dni',['dni'=>$dni]);

        foreach ($personace as $persona)
        {
            $cp = $persona-> codPersona;
        }

        DB::table('persona')->where('codPersona', $cp)->update(['estado' => 0]);
        DB::table('personal')->where('idPersona', $cp)->update(['estado' => 0]);
    }
}
