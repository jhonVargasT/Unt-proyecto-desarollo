<?php

namespace App;

use App\Http\Controllers\util;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDOException;

class clientemodel extends personamodel
{
    private $ruc;
    private $razonSocial;
    private $idPersona;

    function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getRuc()
    {
        return $this->ruc;
    }

    /**
     * @param mixed $ruc
     */
    public function setRuc($ruc)
    {
        $this->ruc = $ruc;
    }

    /**
     * @return mixed
     */
    public function getRazonSocial()
    {
        return $this->razonSocial;
    }

    /**
     * @param mixed $razonSocial
     */
    public function setRazonSocial($razonSocial)
    {
        $this->razonSocial = $razonSocial;
    }

    public function persona()
    {
        return $this->belongsTo('personamodel');
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
     * @return clientemodel
     */
    public function setIdPersona($idPersona)
    {
        $this->idPersona = $idPersona;
        return $this;
    }

    public function bdPersona($dni)
    {
        $per = null;
        try {
            $persona = DB::select('select codPersona from persona where dni=:dni', ['dni' => $dni]);

            foreach ($persona as $pers) {
                $per = $pers->codPersona;
            }
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'bdPersona/clientemodel');
            return false;
        }
        return $per;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function savecliente()
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        echo($codPers);
        $logunt->setFecha($date);
        $logunt->setDescripcion('registrarCliente');
        $logunt->setCodigoPersonal($codPers);
        try {
            DB::transaction(function () use ($logunt) {
                DB::table('persona')->insert(['dni' => $this->getDni(), 'nombres' => $this->getNombres(), 'apellidos' => $this->getApellidos(), 'correo' => $this->getCorreo()]);
                $personabd = DB::table('persona')->where('dni', $this->getDni())->get();
                foreach ($personabd as $pbd) {
                    $idp = $pbd->codPersona;
                    DB::table('cliente')->insert(['ruc' => $this->ruc, 'razonSocial' => $this->razonSocial, 'idPersona' => $idp]);
                }
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'savecliente/clientemodel');
            return false;
        }
        return true;
    }


    public function editarCliente($codPersona)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('editarCliente');
        $logunt->setCodigoPersonal($codPers);
        try {
            DB::transaction(function () use ($codPersona, $logunt) {
                DB::table('persona')->where('codPersona', $codPersona)->update(['dni' => $this->getDni(), 'nombres' => $this->getNombres(), 'apellidos' => $this->getApellidos(), 'correo' => $this->getCorreo()]);
                $personabd = DB::table('persona')->where('dni', $this->getDni())->get();
                foreach ($personabd as $pbd) {
                    $idp = $pbd->codPersona;
                    DB::table('cliente')->where('idPersona', $codPersona)->update(['ruc' => $this->ruc, 'razonSocial' => $this->razonSocial, 'idPersona' => $idp]);
                }
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'editarCliente/clientemodel');
            return false;
        }
        return true;
    }

    public function consultarClienteDNI($dni)
    {
        try {
            $clientebd = DB::select('select * from persona left join cliente on persona.codPersona = cliente.idPersona where 
        persona.codPersona = cliente.idPersona and persona.dni like "%' . $dni . '%" and persona.estado = 1');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarClienteDNI/clientemodel');
            return null;
        }
        return $clientebd;
    }

    public function consultarClienteApellidos($apellidos)
    {
        try {
            $clientebd = DB::select('select * from persona left join cliente on persona.codPersona = cliente.idPersona where 
        persona.codPersona = cliente.idPersona and persona.apellidos like "%' . $apellidos . '%" and persona.estado=1');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarClienteApellidos/clientemodel');
            return null;
        }
        return $clientebd;
    }

    public function consultarClientesRUC($ruc)
    {
        try {
            $clientebd = DB::table('persona')->leftJoin('cliente', 'persona.codPersona', '=', 'cliente.idPersona')
                ->where('cliente.ruc', 'like', '%' . $ruc . '%')
                ->where('persona.estado', '=', 1)->orderBy('persona.codPersona', 'desc')->get();
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarClientesRUC/clientemodel');
            return null;
        }
        return $clientebd;
    }

    public function consultarClienteRUC($ruc)
    {
        $client = null;
        try {
            $clientebd = DB::select('select * from persona left join cliente on persona.codPersona = cliente.idPersona where 
        persona.codPersona = cliente.idPersona and cliente.ruc=:ruc and persona.estado=1 and cliente.estado =1', ['ruc' => $ruc]);
            foreach ($clientebd as $cl) {
                $client = $cl->idPersona;
            }
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarClienteRUC/clientemodel');
            return null;
        }
        return $client;

    }

    public function consultarClienteSocial($razonSocial)
    {
        $clientbd = null;
        try {
            $clientebd = DB::table('persona')->leftJoin('cliente', 'persona.codPersona', '=', 'cliente.idPersona')
                ->where('cliente.razonSocial', 'like', '%' . $razonSocial . '%')
                ->where('persona.estado', '=', 1)->orderBy('persona.codPersona', 'desc')->get();
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarClienteSocial/clientemodel');
            return null;
        }
        return $clientebd;
    }

    public function consultarClienteid($codPersona)
    {
        try {
            $clientebd = DB::select('select * from persona left join cliente on persona.codPersona = cliente.idPersona where 
        persona.codPersona = cliente.idPersona and persona.codPersona=:codPersona', ['codPersona' => $codPersona]);
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarClienteid/clientemodel');
            return null;
        }
        return $clientebd;
    }

    public function eliminarCliente($codPersona)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('EliminarCliente');
        $logunt->setCodigoPersonal($codPers);
        try {
            DB::transaction(function () use ($codPersona, $logunt) {
                DB::table('persona')->where('codPersona', $codPersona)->update(['estado' => 0]);
                DB::table('cliente')->where('idPersona', $codPersona)->update(['estado' => 0]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'eliminarCliente/clientemodel');
            return false;
        }
        return true;
    }
}
