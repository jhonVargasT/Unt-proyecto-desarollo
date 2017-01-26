<?php

namespace App;

use Illuminate\Support\Facades\DB;

class tramitemodel
{
    private $clasificador;
    private $nombre;
    private $fuentefinanc;
    private $tipoRecurso;
    private $estado;
    private $subtramites;
    private $donacion;

    /**
     * tramitemodel constructor.
     */
    public function __construct()
    {
        $this->subtramites = array();
        $this->donacion = array();
    }

    /**
     * @return mixed
     */
    public function getClasificador()
    {
        return $this->clasificador;
    }

    /**
     * @param mixed $clasificador
     * @return tramitemodel
     */
    public function setClasificador($clasificador)
    {
        $this->clasificador = $clasificador;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     * @return tramitemodel
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFuentefinanc()
    {
        return $this->fuentefinanc;
    }

    /**
     * @param mixed $funtefinanc
     * @return tramitemodel
     */
    public function setFuentefinanc($fuentefinanc)
    {
        $this->fuentefinanc = $fuentefinanc;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTipoRecurso()
    {
        return $this->tipoRecurso;
    }

    /**
     * @param mixed $tipoRecurso
     * @return tramitemodel
     */
    public function setTipoRecurso($tipoRecurso)
    {
        $this->tipoRecurso = $tipoRecurso;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     * @return tramitemodel
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
        return $this;
    }

    public function consultarNombreTramites()
    {
        $tramitea = array();

        $nombres = DB::table('tramite')->pluck('nombre');

        foreach ($nombres as $nom) {
            array_push($tramitea, $nom);
        }
        return $tramitea;

    }

    public function consultarTRTramites($nombre)
    {
        $tra = array();

        $tiporecurso = DB::table('tramite')->where('nombre', '=', $nombre)->pluck('tipoRecurso');

        foreach ($tiporecurso as $tr) {
            array_push($tra, $tr);
        }
        return $tra;

    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function consultarTramites()
    {
        $tramite = DB::select('select * from tramite ');
        foreach ($tramite as $trami)
        {
            $tr= $trami->todoslosatributos;
        }
        return $tr;
    }

    public function consultarTramite($nombre)
    {
        $tramite = DB::select('select * from tramite where nombre=:nombre', ['nombre'=>$nombre]);
        foreach ($tramite as $trami)
        {
            $tr= $trami->todoslosatributos;
        }
        return $tr;
    }

    public function save(){

        $facultadbd = DB::select('select * from tramite where clasificador=:clasificador and nombre=:nombre', ['clasificador' => $this->clasificador, 'nombre' => $this->nombre]);

        if ($facultadbd != null) {
            return false;
        } else {
            DB::table('tramite')->insert(['clasificador' => $this->clasificador, 'nombre' => $this->nombre, 'fuentefinanc'=>$this->fuentefinanc, 'tipoRecurso'=>$this->tipoRecurso]);
            return true;
        }
    }

    public function consultarTramitePorId($idTramite)
    {
        $tramite = DB::select('select * from tramite where codTramite=:codTramite',['codTramite'=>$idTramite]);
        foreach ($tramite as $trami)
        {
            $tr= $trami->todoslosatributos;
        }
        return $tr;
    }

    public function consultarTramitePorClasificador($clasificador)
    {
        $tramite = DB::select('select * from tramite where clasificador=:clasificador',['clasificador'=>$clasificador]);
        foreach ($tramite as $trami)
        {
            $tr= $trami->todoslosatributos;
        }
        return $tr;
    }

    //public function consultarTramite($nombreTramite){}

    public function consultarTramiteFF($ff)
    {
        $tramite = DB::select('select * from tramite where fuentefinanc=:fuentefinanc',['fuentefinanc'=>$ff]);
        foreach ($tramite as $trami)
        {
            $tr= $trami->todoslosatributos;
        }
        return $tr;
    }

    public function editarTramite($nombre,$clasificador,$fuentefinanc,$tipoRecurso)
    {
        $tramitecod= DB::select('select codTramite from tramite where nombre=:nombre',['nombre'=>$nombre]);

        foreach ($tramitecod as $tramite)
        {
            $cod = $tramite-> codTramite;
        }

        DB::table('tramite')->where('codTramite', $cod)->update(['clasificador' => $clasificador, 'nombre'=>$nombre, 'fuentefinanc'=>$fuentefinanc, 'tipoRecurso'=>$tipoRecurso]);
    }

    public function eliminarTramite($nombre)
    {
        DB::table('tramite')->where('nombre', $nombre)->update(['estado' => 1]);
    }
}
