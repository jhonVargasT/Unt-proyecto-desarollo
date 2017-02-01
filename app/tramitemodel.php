<?php

namespace App;

use Illuminate\Support\Facades\DB;
use PDOException;

class tramitemodel
{
    private $clasificador;
    private $nombre;
    private $fuentefinanc;
    private $tipoRecurso;
    private $estado;

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
        foreach ($tramite as $trami) {
            $tr = $trami->todoslosatributos;
        }
        return $tr;
    }

    public function consultarTramite($nombre)
    {
        $tramite = DB::select('select * from tramite where nombre=:nombre', ['nombre' => $nombre]);
        foreach ($tramite as $trami) {
            $tr = $trami->todoslosatributos;
        }
        return $tr;
    }


    public function consultarTramitePorId($idTramite)
    {
        $tramite = DB::select('select * from tramite where codTramite=:codTramite', ['codTramite' => $idTramite]);
        foreach ($tramite as $trami) {
            $tr = $trami->todoslosatributos;
        }
        return $tr;
    }

    public function consultarTramitePorClasificador($clasificador)
    {
        $tramite = DB::select('select * from tramite where clasificador=:clasificador', ['clasificador' => $clasificador]);
        foreach ($tramite as $trami) {
            $tr = $trami->todoslosatributos;
        }
        return $tr;
    }


    public function consultarTramiteFF($ff)
    {
        $tramitebd = DB::table('tramite')
            ->where('fuentefinanc', $ff)
            ->where('estado', 1)
            ->orderBy('codTramite', 'desc')->get();
        return $tramitebd;
    }

    public function consultarTramiteCS($cs)
    {
        $tramitebd = DB::table('tramite')
            ->where('clasificador', $cs)
            ->where('estado', 1)
            ->orderBy('codTramite', 'desc')->get();
        return $tramitebd;
    }

    public function consultarTramiteTR($tr)
    {
        $tramitebd = DB::table('tramite')
            ->where('tipoRecurso', $tr)
            ->where('estado', 1)
            ->orderBy('codTramite', 'desc')->get();
        return $tramitebd;
    }

    public function consultarTramiteN($nombre)
    {
        $tramitebd = DB::table('tramite')
            ->where('nombre', $nombre)
            ->where('estado', 1)
            ->orderBy('codTramite', 'desc')->get();
        return $tramitebd;
    }

    public function consultarTramiteid($codTramite)
    {
        $tramitebd = DB::table('tramite')->where('codTramite', $codTramite)->get();
        return $tramitebd;
    }

    public function save()
    {
        try {
            DB::transaction(function () {
                DB::table('tramite')->insert(['clasificador' => $this->clasificador, 'nombre' => $this->nombre, 'fuentefinanc' => $this->fuentefinanc, 'tipoRecurso' => $this->tipoRecurso]);
            });
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function editarTramite($codTramite)
    {
        DB::table('tramite')->where('codTramite', $codTramite)->update(['clasificador' => $this->clasificador, 'nombre' => $this->nombre, 'fuentefinanc' => $this->fuentefinanc, 'tipoRecurso' => $this->tipoRecurso]);
    }

    public function eliminarTramite($codTramite)
    {
        DB::table('tramite')->where('codTramite', $codTramite)->update(['estado' => 0]);
        DB::table('subtramite')->where('estado', 1)->update(['estado' => 0]);
        DB::table('donacion')->where('estado', 1)->update(['estado' => 0]);

    }
}
