<?php

namespace App;

use Illuminate\Support\Facades\DB;
use PDOException;

class personalmodel extends personamodel
{
    private $codPersonal;
    private $cuenta;
    private $password;
    private $tipoCuenta;
    private $idPersona;

    function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getCodPersonal()
    {
        return $this->codPersonal;
    }

    /**
     * @param mixed $codPersonal
     * @return personalmodel
     */
    public function setCodPersonal($codPersonal)
    {
        $this->codPersonal = $codPersonal;
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
     * @return personalmodel
     */
    public function setIdPersona($idPersona)
    {
        $this->idPersona = $idPersona;
        return $this;
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
            ['cuenta' => $this->cuenta, 'pass' => $this->password]);

        return $personal;
    }

    public function bdPersona($dni)
    {
        $persona = DB::select('select codPersona from persona where dni=:dni', ['dni' => $dni]);
        foreach ($persona as $pers) {
            return $per = $pers->codPersona;
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function savepersonal()
    {
        try {
            DB::transaction(function () {
                DB::table('persona')->insert(['dni' => $this->getDni(), 'nombres' => $this->getNombres(), 'apellidos' => $this->getApellidos()]);
                DB::table('personal')->insert(['cuenta' => $this->cuenta, 'password' => $this->password, 'tipoCuenta' => $this->tipoCuenta, 'idPersona' => $this->idPersona]);
            });
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function editarPersonal($codPersona)
    {
        DB::table('persona')->where('codPersona', $codPersona)->update(['dni' => $this->getDni(), 'nombres' => $this->getNombres(), 'apellidos' => $this->getApellidos()]);
        DB::table('personal')->where('idPersona', $codPersona)->update(['codPersonal' => $this->codPersonal, 'cuenta' => $this->cuenta, 'password' => $this->password, 'tipoCuenta' => $this->tipoCuenta]);
    }

    public function consultarPersonalid($codPersona)
    {
        $alumnobd = DB::select('select * from persona left join personal on persona.codPersona = personal.idPersona where 
        persona.codPersona = personal.idPersona and persona.codPersona=:codPersona', ['codPersona' => $codPersona]);
        return $alumnobd;
    }

    public function consultarPersonalDNI($dni)
    {
        $alumnobd = DB::select('select * from persona left join personal on persona.codPersona = personal.idPersona where 
        persona.codPersona = personal.idPersona and persona.dni=:dni and persona.estado=1 and personal.estado=1', ['dni' => $dni]);
        //$alumnobd = DB::table('persona')->leftJoin('alumno', 'persona.codPersona', '=', 'alumno.idPersona')->where('persona.dni', '=',$dni)->orderBy('persona.codPersona', 'desc')->get();
        return $alumnobd;
    }

    public function consultarPersonalApellidos($apellidos)
    {
        $alumnobd = DB::select('select * from persona left join personal on persona.codPersona = personal.idPersona where 
        persona.codPersona = personal.idPersona and persona.apellidos=:apellidos and persona.estado=1 and personal.estado =1', ['apellidos' => $apellidos]);
        //$alumnobd = DB::table('persona')->leftJoin('alumno', 'persona.codPersona', '=', 'alumno.idPersona')->where('persona.apellidos', '=', $apellidos)->orderBy('persona.codPersona', 'desc')->get();
        return $alumnobd;
    }

    public function consultarPersonalCodigo($codPersonal)
    {
        $alumnobd = DB::table('persona')
            ->leftJoin('personal', 'persona.codPersona', '=', 'personal.idPersona')
            ->where('personal.codPersonal', '=', $codPersonal)
            ->where('persona.estado', '=', 1)
            ->orderBy('persona.codPersona', 'desc')->get();
        return $alumnobd;
    }

    public function consultarPersonalCuenta($cuenta)
    {
        $alumnobd = DB::table('persona')
            ->leftJoin('personal', 'persona.codPersona', '=', 'personal.idPersona')
            ->where('personal.cuenta', '=', $cuenta)
            ->where('persona.estado', '=', 1)
            ->orderBy('persona.codPersona', 'desc')->get();
        return $alumnobd;
    }

    public function consultaPersonalTipoCuenta($tipoCuenta)
    {
        $alumnobd = DB::table('persona')
            ->leftJoin('personal', 'persona.codPersona', '=', 'personal.idPersona')
            ->where('personal.tipoCuenta', '=', $tipoCuenta)
            ->where('persona.estado', '=', 1)
            ->orderBy('persona.codPersona', 'desc')->get();
        return $alumnobd;
    }

    public function eliminarPersonal($codPersona)
    {
        DB::table('persona')->where('codPersona', $codPersona)->update(['estado' => 0]);
        DB::table('personal')->where('idPersona', $codPersona)->update(['estado' => 0]);
    }
}
