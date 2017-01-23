<?php

namespace App;

use Illuminate\Support\Facades\DB;

class subtramitemodel
{
    private $codSubtramite;
    private $cuenta;
    private $nombre;
    private $precio;
    private $estado;
    private $idTramite;
    private $pago;

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
    public function getCodSubtramite()
    {
        return $this->codSubtramite;
    }

    /**
     * @param mixed $codSubtramite
     * @return subtramitemodel
     */
    public function setCodSubtramite($codSubtramite)
    {
        $this->codSubtramite = $codSubtramite;
        return $this;
    }

    /**
     * @return array
     */
    public function getPago(): array
    {
        return $this->pago;
    }

    /**
     * @param array $pago
     * @return subtramitemodel
     */
    public function setPago(array $pago): subtramitemodel
    {
        $this->pago = $pago;
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
        $idTra = DB::select('select idTramite from tramite where nombre=:nombre',['nombre'=>$nombre]);
        foreach ($idTra as $idT)
        {
            $id= $idT->idFacultad;
        }
        return $id;
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
        $save =DB::table('subtramite')->insert(['cuenta' => $this->cuenta, 'nombre' => $this->nombre, 'precio'=>$this->precio, 'idTramite'=>$this->idTramite]);
        return $save;
    }

    public function editarSubtramite($cuenta, $nombre, $precio)
    {
        $tramitecod= DB::select('select codTramite from tramite left join subtramite on tramite.codTramite = subtramite.idTramite where subtramite.nombre=:nombre',['nombre'=>$nombre]);

        foreach ($tramitecod as $tramite)
        {
            $cod = $tramite-> todoslosatributos;
        }

        DB::table('subtramite')->where('idTramite', $cod)->update(['cuenta' => $cuenta, 'nombre'=>$nombre, 'precio'=>$precio, 'idTramite'=>$cod]);
    }

    public function eliminar($nombre)
    {
        DB::table('subtramite')->where('nombre', $nombre)->update(['estado' => 0]);
    }


}
