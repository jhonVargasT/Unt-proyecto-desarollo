<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDOException;
use App\Http\Controllers\util;

class personalmodel extends personamodel
{
    private $codPersonal;
    private $cuenta;
    private $password;
    private $tipoCuenta;
    private $idPersona;
    private $idSede;

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

    /**
     * @return mixed
     */
    public function getIdSede()
    {
        return $this->idSede;
    }

    /**
     * @param mixed $idSede
     * @return personalmodel
     */
    public function setIdSede($idSede)
    {
        $this->idSede = $idSede;
        return $this;
    }


    public function logear()
    {
        try {

            $personal = DB::table('personal')->where(['cuenta' => $this->cuenta, 'password' => $this->password, 'estado' => 1])->get();

        } catch
        (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'logear/personalmodel');
            return null;

        }
        return $personal;
    }

    public function bdPersona($dni)
    {
        try {
            $per = null;
            $persona = DB::select('select codPersona from persona where dni=:dni', ['dni' => $dni]);
            foreach ($persona as $pers) {
                $per = $pers->codPersona;
            }
        } catch
        (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'logear/personalmodel');
            return null;

        }
        return $per;
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
                DB::table('persona')->insert(['dni' => $this->getDni(), 'nombres' => $this->getNombres(), 'apellidos' => $this->getApellidos(), 'correo' => $this->getCorreo()]);
                $personabd = DB::table('persona')->where('dni', $this->getDni())->get();
                foreach ($personabd as $pbd) {
                    $idp = $pbd->codPersona;
                    DB::table('personal')->insert(['cuenta' => $this->cuenta, 'password' => $this->password, 'tipoCuenta' => $this->tipoCuenta, 'idPersona' => $idp, 'codPersonal' => $this->codPersonal, 'idSede' => $this->idSede]);
                    $logunt->saveLogUnt();
                }
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'savepersonal/personalmodel');
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
                DB::table('persona')->where('codPersona', $codPersona)->update(['dni' => $this->getDni(), 'nombres' => $this->getNombres(), 'apellidos' => $this->getApellidos(), 'correo' => $this->getCorreo()]);
                $personabd = DB::table('persona')->where('dni', $this->getDni())->get();
                foreach ($personabd as $pbd) {
                    $idp = $pbd->codPersona;
                    DB::table('personal')->where('idPersona', $codPersona)->update(['cuenta' => $this->cuenta, 'password' => $this->password, 'tipoCuenta' => $this->tipoCuenta, 'idPersona' => $idp, 'codPersonal' => $this->codPersonal, 'idSede' => $this->idSede]);
                }
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'editarpersonal/personalmodel');
            return false;
        }
        return true;
    }

    public function consultarPersonalid($codPersona)
    {
        try {
            $alumnobd = DB::select('select * from persona left join personal on persona.codPersona = personal.idPersona  
        left join sede on personal.idSede = sede.codSede where personal.idSede = sede.codSede and 
        persona.codPersona = personal.idPersona and persona.codPersona=:codPersona and persona.estado = 1 and personal.estado=1', ['codPersona' => $codPersona]);
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarPersonalid/personalmodel');
            return null;
        }
        return $alumnobd;
    }

    public function consultarPersonalDNI($dni)
    {
        try {
            $personabd = DB::table('personal')
                ->join('persona', function ($join) use ($dni) {
                    $join->on('personal.idPersona', '=', 'persona.codPersona')
                        ->where('persona.dni', 'like', '' . $dni . '%')->where(['persona.estado' => 1, 'personal.estado' => 1]);
                })
                ->get();
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarPersonalDNI/personalmodel');
            return null;
        }
        return $personabd;
    }

    public function consultarPersonalApellidos($apellidos)
    {
        try {
            $personabd = DB::table('personal')
                ->join('persona', function ($join) use ($apellidos) {
                    $join->on('personal.idPersona', '=', 'persona.codPersona')
                        ->where('persona.apellidos', 'like', '' . $apellidos . '%')->where(['persona.estado' => 1, 'personal.estado' => 1]);
                })
                ->get();
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarPersonalApellidos/personalmodel');
            return null;

        }
        return $personabd;
    }

    public function consultarPersonalCodigo($codPersonal)
    {
        try {
            $personabd = DB::table('personal')
                ->join('persona', function ($join) use ($codPersonal) {
                    $join->on('personal.idPersona', '=', 'persona.codPersona')
                        ->where('personal.codPersonal', 'like', '' . $codPersonal . '%')->where(['persona.estado' => 1, 'personal.estado' => 1]);
                })
                ->get();
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarPersonalCodigo/personalmodel');
            return null;

        }
        return $personabd;
    }

    public function consultarPersonalCuenta($cuenta)
    {
        try {
            $personabd = DB::table('personal')
                ->join('persona', function ($join) use ($cuenta) {
                    $join->on('personal.idPersona', '=', 'persona.codPersona')
                        ->where('personal.cuenta', 'like', '' . $cuenta . '%')->where(['persona.estado' => 1, 'personal.estado' => 1]);
                })
                ->get();
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarPersonalCuenta/personalmodel');
            return null;

        }
        return $personabd;
    }

    public function consultaPersonalTipoCuenta($tipoCuenta)
    {
        try {
            $personabd = DB::table('personal')
                ->join('persona', function ($join) use ($tipoCuenta) {
                    $join->on('personal.idPersona', '=', 'persona.codPersona')
                        ->where('personal.tipoCuenta', 'like', '' . $tipoCuenta . '%')->where(['persona.estado' => 1, 'personal.estado' => 1]);
                })
                ->get();
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultaPersonalTipoCuenta/personalmodel');
            return null;

        }
        return $personabd;
    }

    public function consultaPersonales()
    {
        try {
            $alumnobd = DB::select('select * from persona left join personal on persona.codPersona = personal.idPersona where 
        persona.codPersona = personal.idPersona and persona.estado = 1 and persona.estado=1');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), ' consultaPersonales/personalmodel');
            return null;
        }
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
            $util = new util();
            $util->insertarError($e->getMessage(), 'eliminarPersonal/personalmodel');

            return false;
        }
        return true;
    }

    public function obtenerIdSede($nombre)
    {
        try {
            $sbd = null;
            $sedebd = DB::table('sede')->where(['nombresede' => $nombre, 'estado' => 1])->get();

            foreach ($sedebd as $s) {
                $sbd = $s->codSede;
            }
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'eliminarPersonal/personalmodel');
            return null;
        }
        return $sbd;
    }
}
