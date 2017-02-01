<?php

namespace App;

use Illuminate\Support\Facades\DB;

class subtramitemodel
{
    private $cuenta;
    private $nombre;
    private $precio;
    private $estado;
    private $idTramite;

    /**
     * subtramitemodel constructor.
     */
    public function __construct()
    {
        $this-> pago = array();
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
     * @return subtramitemodel
     */
    public function setCuenta($cuenta)
    {
        $this->cuenta = $cuenta;
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
     * @return subtramitemodel
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * @param mixed $precio
     * @return subtramitemodel
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;
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
     * @return subtramitemodel
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdTramite()
    {
        return $this->idTramite;
    }

    /**
     * @param mixed $idTramite
     * @return subtramitemodel
     */
    public function setIdTramite($idTramite)
    {
        $this->idTramite = $idTramite;
        return $this;
    }

    public function bdTramite($nombre)
    {
        $idTra = DB::select('select codTramite from tramite where nombre=:nombre',['nombre'=>$nombre]);
        foreach ($idTra as $idT)
        {
            return $id= $idT->codTramite;
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function consultarSubtramites()
    {
        $subtramite = DB::select('select * from subtramite ');
        foreach ($subtramite as $subt)
        {
            $sub= $subt->todoslosatributos;
        }
        return $sub;
    }

    public function consultarSubtramite($nombre,$cuenta)
    {
        $subtramite = DB::select('select * from subtramite where nombre=:nombre and cuenta=:cuenta',['nombre'=>$nombre, 'cuenta'=>$cuenta]);
        foreach ($subtramite as $subt)
        {
            $sub= $subt->todoslosatributos;
        }
        return $sub;
    }

    public function consultarSubtramiteIdSubTramite()
    {
        $subtramite = DB::select('select * from subtramite where codSubtramite=:codSubtramite',['codSubtramite'=>$this->codSubtramite]);
        foreach ($subtramite as $subt)
        {
            $sub= $subt->todoslosatributos;
        }
        return $sub;
    }

    public function eliminarSubtramitesPorTramite($nombre)
    {
        $tramitee = DB::select('select codTramite from tramite left join subtramite on tramite.codTramite = subtramite.idTramite where subtramite.nombre=:nombre',['nombre'=>$nombre]);
        foreach ($tramitee as $tramite)
        {
            $ct= $tramite->codTramite;
            $es= $tramite->estado;
        }

        if($es==0)
        {
            DB::table('subtramite')->where('coEscuela', $ct)->update(['estado' => 0]);
        }

    }

    public function save(){

        $subbd = DB::select('select * from subtramite where cuenta=:cuenta and nombre=:nombre', ['cuenta' => $this->cuenta, 'nombre' => $this->nombre]);

        if ($subbd != null) {
            return false;
        } else {
            DB::table('subtramite')->insert(['cuenta' => $this->cuenta, 'nombre' => $this->nombre, 'precio'=>$this->precio, 'idTramite'=>$this->idTramite]);
            return true;
        }
    }

    public function editarSubtramite($codSubtramite)
    {
        DB::table('subtramite')->where('codSubtramite', $codSubtramite)->update(['cuenta' => $this->cuenta, 'nombre' => $this->nombre, 'precio' => $this->precio]);
    }

    public function consultarSubtramiteid($codSubtramite)
    {
        $subtramitebd = DB::table('subtramite')->where('codSubtramite',$codSubtramite)->get();
        return $subtramitebd;
    }

    public function consultarSubtramiteTramite($nombreTramite)
    {
        //$subtramitebd = DB::table('tramite')->leftJoin('subtramite', 'tramite.codTramite', '=', 'subtramite.idTramite')->where('tramite.nombre', '=',$nombreTramite)->orderBy('tramite.codTramite', 'desc')->get();
        $subtramitebd = DB::select('select * from tramite left join subtramite on tramite.codTramite = subtramite.idTramite where 
        tramite.codTramite = subtramite.idTramite and tramite.nombre=:nombre and tramite.estado=1 and subtramite.estado=1',['nombre'=>$nombreTramite]);
        return $subtramitebd;
    }

    public function consultarSubtramiteNombre($nombreSubtramite)
    {
        $subtramitebd = DB::table('subtramite')
            ->where('nombre',$nombreSubtramite)
            ->where('estado',1)
            ->orderBy('codSubtramite', 'desc')->get();
        return $subtramitebd;
    }

    public function consultarSubtramiteCuenta($cuenta)
    {
        $subtramitebd = DB::table('subtramite')
            ->where('cuenta',$cuenta)
            ->where('estado',1)
            ->orderBy('codSubtramite', 'desc')->get();
        return $subtramitebd;
    }

    public function eliminarSubtramite($codSubtramite)
    {
        DB::table('subtramite')->where('codSubtramite', $codSubtramite)->update(['estado' => 0]);
    }


}
