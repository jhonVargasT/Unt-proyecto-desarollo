<?php

namespace App;

use Illuminate\Support\Facades\DB;

class clientemodel extends personamodel
{
    private $ruc;
    private $razonSocial;
    private $idPersona;

    function __construct() {
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

    public function persona() {
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
        $persona= DB::select('select codPersona from persona where dni=:dni',['dni' => $dni]);

        foreach ($persona as $pers)
        {
           return $per = $pers->codPersona;
        }
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function consultarClientes()
    {
        $clientebd= DB::select('select * from persona left join cliente on persona.codPersona = cliente.idPersona');

        foreach ($clientebd as $clientes)
        {
            $cl = $clientes-> todoslosatributos;
        }

        return $cl;
    }

    public function extraerCodigosPersona($dni)
    {
        $clientecd= DB::select('select codPersona from persona left join cliente on persona.codPersona = cliente.idPersona where persona.dni=:dni',['dni'=>$dni]);

        foreach ($clientecd as $clientes)
        {
            $cl = $clientes-> codPersona;
        }

        return $cl;
    }

    public function savecliente()
    {
        $clienter = DB::select('select * from cliente where ruc=:ruc', ['ruc' => $this->ruc]);

        if ($clienter != null) {
            return false;
        } else {
            DB::table('cliente')->insert(['ruc' => $this->ruc, 'razonSocial' => $this->razonSocial, 'idPersona' => $this->idPersona]);
            return true;
        }
    }


    public function consultarCliente($dni)
    {
        $clientes = DB::select('select * from persona left join cliente on persona.codPersona = cliente.idPersona where persona.dni=:dni', ['dni' => $dni]);

        foreach ($clientes as $cli) {
            $cl = $cli->todoslosatributos;
        }

        return $cl;
    }

    public function consultarClienteRuc($ruc)
    {
        $clienteruc= DB::select('select * from persona left join cliente on persona.codPersona = cliente.idPersona where ruc=:ruc',['ruc'=>$ruc]);

        foreach ($clienteruc as $cli)
        {
            $cl = $cli-> todoslosatributos;
        }

        return $cl;
    }

    public function editarCliente($dni, $nombres,$apellidos,$ruc,$razonSocial)
    {
        $clientecd= DB::select('select codPersona from persona left join cliente on persona.codPersona = cliente.idPersona where persona.dni=:dni',['dni'=>$dni]);

        foreach ($clientecd as $clientes)
        {
            $cl = $clientes-> codPersona;
        }

        DB::table('persona')->where('dni', $cl)->update(['nombres' => $nombres, 'apellidos'=>$apellidos]);
        DB::table('cliente')->where('idPersona', $cl)->update(['ruc' => $ruc, 'razonSocial'=>$razonSocial]);
    }

    public function eliminarAlumno($dni)
    {
        $clientecd= DB::select('select codPersona from persona left join cliente on persona.codPersona = cliente.idPersona where persona.dni=:dni',['dni'=>$dni]);

        foreach ($clientecd as $clientes)
        {
            $cl = $clientes-> codPersona;
        }

        DB::table('persona')->where('codPersona', $cl)->update(['estado' => 0]);
        DB::table('cliente')->where('idPersona', $cl)->update(['estado' => 0]);
    }
}
