<?php

namespace App;


use Illuminate\Support\Facades\DB;

class facultadmodel
{
    private $codFacultad;
    private $nombre;
    private $nroCuenta;
    private $escuelas;

    public function __construct()
    {
        $this->escuelas = array();
    }

    /**
     * @return mixed
     */
    public function getEscuelas()
    {
        return $this->escuelas;
    }

    /**
     * @param mixed $escuelas
     * @return facultadmodel
     */
    public function setEscuelas($escuelas)
    {
        $this->escuelas = $escuelas;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getCodFacultad()
    {
        return $this->codFacultad;
    }

    /**
     * @param mixed $codFacultad
     * @return facultadmodel
     */
    public function setCodFacultad($codFacultad)
    {
        $this->codFacultad = $codFacultad;
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
     * @return facultadmodel
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
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
     * @return facultadmodel
     */
    public function setNroCuenta($nroCuenta)
    {
        $this->nroCuenta = $nroCuenta;
        return $this;
    }

    public function consultarNombreFacultades()
    {
        $facunombre = array();

        $nombres = DB::table('facultad')->pluck('nombre');

        foreach ($nombres as $nom) {
             array_push($facunombre, $nom);
        }
        return $facunombre;

    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function consultarFacultad($idFacultad)
    {
        $facultadbd= DB::select('select * from facultad ');

        foreach ($facultadbd as $facultad)
        {
            $facu = $facultad->todossusatributos;
        }

        return $facu;
    }

    public function consultarFacultades()
    {
        $facultadbd= DB::select('select * from facultad');

        foreach ($facultadbd as $facultad)
        {
            $facu = $facultad->todossusatributos;
        }

        return $facu;
    }

    public function consultarFacultadeNombre($nombre)
    {
        $facultadbd= DB::select('select * from facultad where nombre=:nombre',['nombre'=>$nombre]);

        foreach ($facultadbd as $facultad)
        {
            $facu = $facultad->todossusatributos;
        }

        return $facu;
    }

    public function save(){
        $save= DB::table('facultad')->insert(['codFacultad' => $this->codFacultad, 'nombre' => $this->nombre, 'nroCuenta'=>$this->nroCuenta]);
        return $save;
    }

    public function editarFacultad($nombre,$codFacultad, $nroCuenta)
    {
        DB::table('persona')->where('nombre', $nombre)->update(['codFacultad' => $codFacultad, 'nombre'=> $nombre, 'nroCuenta'=>$nroCuenta]);
    }

    public function eliminarFacultad($nombre)
    {
        DB::table('persona')->where('nombre', $nombre)->update(['estado'=>0]);
    }

}
