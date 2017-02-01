<?php

namespace App;

use Illuminate\Support\Facades\DB;
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
        $persona = DB::select('select codPersona from persona where dni=:dni', ['dni' => $dni]);

        foreach ($persona as $pers) {
            return $per = $pers->codPersona;
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function savecliente()
    {
        try {
            DB::transaction(function () {

                DB::table('persona')->insert(['dni' => $this->getDni(), 'nombres' => $this->getNombres(), 'apellidos' => $this->getApellidos()]);
                DB::table('cliente')->insert(['ruc' => $this->ruc, 'razonSocial' => $this->razonSocial, 'idPersona' => $this->idPersona]);
                return true;
            });
        } catch (PDOException $e) {
            return false;
        }
    }

    public function editarCliente($codPersona)
    {
        DB::table('persona')->where('codPersona', $codPersona)->update(['nombres' => $this->getDni(), 'nombres' => $this->getNombres(), 'apellidos' => $this->getApellidos()]);
        DB::table('cliente')->where('idPersona', $codPersona)->update(['ruc' => $this->ruc, 'razonSocial' => $this->razonSocial]);
    }

    public function consultarAlumnoDNI($dni)
    {
        $clientebd = DB::select('select * from persona left join cliente on persona.codPersona = cliente.idPersona where 
        persona.codPersona = cliente.idPersona and persona.dni=:dni and persona.estado = 1', ['dni' => $dni]);
        return $clientebd;
    }

    public function consultarAlumnoApellidos($apellidos)
    {
        $clientebd = DB::select('select * from persona left join cliente on persona.codPersona = cliente.idPersona where 
        persona.codPersona = cliente.idPersona and persona.apellidos=:apellidos and persona.estado=1', ['apellidos' => $apellidos]);
        return $clientebd;
    }

    public function consultarAlumnoRUC($ruc)
    {
        $clientebd = DB::table('persona')->leftJoin('cliente', 'persona.codPersona', '=', 'cliente.idPersona')
            ->where('cliente.ruc', '=', $ruc)
            ->where('persona.estado', '=', 1)->orderBy('persona.codPersona', 'desc')->get();
        return $clientebd;
    }

    public function consultarAlumnoRazonSocial($razonSocial)
    {
        $clientebd = DB::table('persona')->leftJoin('cliente', 'persona.codPersona', '=', 'cliente.idPersona')
            ->where('cliente.razonSocial', '=', $razonSocial)
            ->where('persona.estado', '=', 1)->orderBy('persona.codPersona', 'desc')->get();
        return $clientebd;
    }

    public function consultarClienteid($codPersona)
    {
        $alumnobd = DB::select('select * from persona left join cliente on persona.codPersona = cliente.idPersona where 
        persona.codPersona = cliente.idPersona and persona.codPersona=:codPersona', ['codPersona' => $codPersona]);
        return $alumnobd;
    }

    public function eliminarCliente($codPersona)
    {
        DB::table('persona')->where('codPersona', $codPersona)->update(['estado' => 0]);
        DB::table('cliente')->where('idPersona', $codPersona)->update(['estado' => 0]);
    }
}
