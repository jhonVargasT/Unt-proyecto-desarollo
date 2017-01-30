<?php

namespace App;

use Illuminate\Support\Facades\DB;

class escuelamodel
{
    private $codEscuela;
    private $nombre;
    private $nroCuenta;
    private $estado;
    private $facultad;

    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getCodEscuela()
    {
        return $this->codEscuela;
    }

    /**
     * @param mixed $codEscuela
     */
    public function setCodEscuela($codEscuela)
    {
        $this->codEscuela = $codEscuela;
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
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getNroCuenta()
    {
        return $this->nroCuenta;
    }

    /**
     * @param mixed $nroCuenta
     */
    public function setNroCuenta($nroCuenta)
    {
        $this->nroCuenta = $nroCuenta;
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
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }


    /**
     * @return mixed
     */
    public function getFacultad()
    {
        return $this->facultad;
    }

    /**
     * @param mixed $facultad
     * @return escuelamodel
     */
    public function setFacultad($facultad)
    {
        $this->facultad = $facultad;
        return $this;
    }

    public function buscarFacultad($nombre)
    {
        $FE = DB::select('select * from facultad left join escuela on facultad.codFacultad=escuela.coFacultad where facultad.codFacultad=escuela.coFacultad and facultad.nombre=:nombre',['nombre'=>$nombre]);
        
      
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function consultarEscuela($nombre)
    {
        $escuela = DB::select('select * from escuela where nombre=:nombre',['nombre'=>$nombre]);
        foreach ($escuela as $escu)
        {
            $es= $escu->todoslosatributos;
        }
        return $es;
    }

    public function consultarEscuelas()
    {
        $escuelas = DB::select('select * from escuela ');
        foreach ($escuelas as $escuela)
        {
            $es= $escuela->todoslosatributos;
        }
        return $es;
    }

    public function eliminarEscuelaPorFacultad($nombre)
    {
        $facultadie = DB::select('select idFacultad, estado from facultad left join escuela on facultad.idFacultad = escuela.codFacultad where escuela.nombre=:nombre',['nombre'=>$nombre]);
        foreach ($facultadie as $facultad)
        {
            $cf= $facultad->idFacultad;
            $ef= $facultad->estado;
        }

        if($ef==0)
        {
            DB::table('escuela')->where('coFacultad', $cf)->update(['estado' => 0]);
        }
    }

    public function eliminarEscuela($nombre)
    {
        DB::table('escuela')->where('nombre', $nombre)->update(['estado' => 0]);
    }

    public function save(){
        $escuelabd = DB::select('select * from escuela where codEscuela=:codEscuela and nombre=:nombre and nroCuenta=:nroCuenta', ['codEscuela' => $this->codEscuela, 'nombre' => $this->nombre, 'nroCuenta' => $this->nroCuenta]);

        if ($escuelabd != null) {
            return false;
        } else {
            DB::table('escuela')->insert(['codEscuela' => $this->codEscuela, 'nombre' => $this->nombre, 'nroCuenta'=>$this->nroCuenta, 'codigoFacultad'=> $this->facultad]);
            return true;
        }
    }

    public function editarEscuela($nombre, $nroCuenta,$codigoEscuela)
    {
        DB::table('escuela')->where('nombre', $codigoEscuela)->update(['nombre' => $nombre, 'nroCuenta'=>$nroCuenta,'codigoFacultad'=>$codigoEscuela]);
    }
}
