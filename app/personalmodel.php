<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
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
     * @return personalmodel
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
     * @return personalmodel
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
     * @return personalmodel
     */
    public function setTipoCuenta($tipoCuenta)
    {
        $this->tipoCuenta = $tipoCuenta;
        return $this;
    }


    public function logear()
    {
        $personal = DB::table('personal')->where(['cuenta' => $this->cuenta, 'password' => $this->password, 'estado' => 1])->get();

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
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('registrarPersonal');
        $logunt->setCodigoPersonal($codPers);

        try {
            DB::transaction(function () use ($logunt) {
                DB::table('persona')->insert(['dni' => $this->getDni(), 'nombres' => $this->getNombres(), 'apellidos' => $this->getApellidos()]);
                $personabd = DB::table('persona')->where('dni', $this->getDni())->get();
                foreach ($personabd as $pbd) {
                    $idp = $pbd->codPersona;
                    DB::table('personal')->insert(['cuenta' => $this->cuenta, 'password' => $this->password, 'tipoCuenta' => $this->tipoCuenta, 'idPersona' => $idp, 'codPersonal' => $this->codPersonal]);
                    $logunt->saveLogUnt();
                }
            });
        } catch (PDOException $e) {
            return false;
        }
        return true;

    }

    public function editarPersonal($codPersona)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('editarPersonal');
        $logunt->setCodigoPersonal($codPers);
        try {
            DB::transaction(function () use ($codPersona, $logunt) {
                DB::table('persona')->where('codPersona', $codPersona)->update(['dni' => $this->getDni(), 'nombres' => $this->getNombres(), 'apellidos' => $this->getApellidos()]);
                DB::table('personal')->where('idPersona', $codPersona)->update(['codPersonal' => $this->codPersonal, 'cuenta' => $this->cuenta, 'password' => $this->password, 'tipoCuenta' => $this->tipoCuenta]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function consultarPersonalid($codPersona)
    {
        $alumnobd = DB::select('select * from persona left join personal on persona.codPersona = personal.idPersona where 
        persona.codPersona = personal.idPersona and persona.codPersona=:codPersona', ['codPersona' => $codPersona]);
        return $alumnobd;
    }

    public function consultarPersonalDNI($dni)
    {
        $personabd = DB::table('personal')
            ->join('persona', function ($join) use ($dni) {
                $join->on('personal.idPersona', '=', 'persona.codPersona')
                    ->where('persona.dni', 'like', '%' . $dni . '%')->where(['persona.estado' => 1, 'personal.estado' => 1]);
            })
            ->get();

        return $personabd;
    }

    public function consultarPersonalApellidos($apellidos)
    {
        $personabd = DB::table('personal')
            ->join('persona', function ($join) use ($apellidos) {
                $join->on('personal.idPersona', '=', 'persona.codPersona')
                    ->where('persona.apellidos', 'like', '%' . $apellidos . '%');
            })
            ->get();

        return $personabd;
    }

    public function consultarPersonalCodigo($codPersonal)
    {
        $personabd = DB::table('personal')
            ->join('persona', function ($join) use ($codPersonal) {
                $join->on('personal.idPersona', '=', 'persona.codPersona')
                    ->where('personal.codPersonal', 'like', '%' . $codPersonal . '%');
            })
            ->get();

        return $personabd;
    }

    public function consultarPersonalCuenta($cuenta)
    {
        $personabd = DB::table('personal')
            ->join('persona', function ($join) use ($cuenta) {
                $join->on('personal.idPersona', '=', 'persona.codPersona')
                    ->where('personal.cuenta', 'like', '%' . $cuenta . '%');
            })
            ->get();

        return $personabd;
    }

    public function consultaPersonalTipoCuenta($tipoCuenta)
    {
        $personabd = DB::table('personal')
            ->join('persona', function ($join) use ($tipoCuenta) {
                $join->on('personal.idPersona', '=', 'persona.codPersona')
                    ->where('personal.tipoCuenta', 'like', '%' . $tipoCuenta . '%');
            })
            ->get();

        return $personabd;
    }

    public function consultaPersonales()
    {
        $alumnobd = DB::select('select * from persona left join personal on persona.codPersona = personal.idPersona where 
        persona.codPersona = personal.idPersona');
        return $alumnobd;
    }

    public function eliminarPersonal($codPersona)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('eliminarPersonal');
        $logunt->setCodigoPersonal($codPers);
        try {
            DB::transaction(function () use ($codPersona, $logunt) {
                DB::table('persona')->where('codPersona', $codPersona)->update(['estado' => 0]);
                DB::table('personal')->where('idPersona', $codPersona)->update(['estado' => 0]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }
}
