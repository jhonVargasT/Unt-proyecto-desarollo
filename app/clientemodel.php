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

    public function editarCliente($codPersona)
    {
        DB::table('persona')->where('codPersona', $codPersona)->update(['nombres' => $this->getDni(), 'nombres'=>$this->getNombres(), 'apellidos'=>$this->getApellidos()]);
        DB::table('cliente')->where('idPersona', $codPersona)->update(['ruc' => $this->ruc, 'razonSocial'=>$this->razonSocial]);
    }

    public function consultarAlumnoDNI($dni)
    {
        $clientebd = DB::select('select * from persona left join cliente on persona.codPersona = cliente.idPersona where 
        persona.codPersona = cliente.idPersona and persona.dni=:dni and persona.estado = 1',['dni'=>$dni]);
        //$clientebd = DB::table('persona')->leftJoin('alumno', 'persona.codPersona', '=', 'alumno.idPersona')->where('persona.dni', '=',$dni)->orderBy('persona.codPersona', 'desc')->get();
        return $clientebd;
    }

    public function consultarAlumnoApellidos($apellidos)
    {
        $clientebd = DB::select('select * from persona left join cliente on persona.codPersona = cliente.idPersona where 
        persona.codPersona = cliente.idPersona and persona.apellidos=:apellidos and persona.estado=1',['apellidos'=>$apellidos]);
        //$alumnobd = DB::table('persona')->leftJoin('alumno', 'persona.codPersona', '=', 'alumno.idPersona')->where('persona.apellidos', '=', $apellidos)->orderBy('persona.codPersona', 'desc')->get();
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
        persona.codPersona = cliente.idPersona and persona.codPersona=:codPersona',['codPersona'=>$codPersona]);
        return $alumnobd;
    }

    public function eliminarCliente($codPersona)
    {
        DB::table('persona')->where('codPersona', $codPersona)->update(['estado' => 0]);
        DB::table('cliente')->where('idPersona', $codPersona)->update(['estado' => 0]);
    }
}
