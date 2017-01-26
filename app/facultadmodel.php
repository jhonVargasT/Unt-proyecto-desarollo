<?php

namespace App;


use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

class facultadmodel
{
    public $codFacultad;
    public $nombre;
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


    public function consultarFacultadesid($idFacultad)
    {
        $facultadbd= DB::table('facultad')->where('idFacultad',$idFacultad)->get();
        return $facultadbd;
    }
    public function consultarFacultades()
    {
        $facultadbd= DB::table('facultad')->get();
        return $facultadbd;
    }
    public function consultarFacultadesCodigo($codigo)
    {
        $facultadbd= DB::table('facultad')->where('codFacultad','like','%'.$codigo.'%')->get();
        return $facultadbd;
    }
    public function consultarFacultadesNombre($nombre)
    {
        $facultadbd= DB::table('facultad')->where('nombre','like','%'.$nombre.'%')->get();
        return $facultadbd;
    }
    public function consultarFacultadesCuentaInterna($nroCuenta)
    {
        $facultadbd= DB::table('facultad')->where('nroCuenta','like','%'.$nroCuenta.'%')->get();
        return $facultadbd;
    }


    public function save(){
        $save= DB::table('facultad')->insert(['codFacultad' => $this->codFacultad, 'nombre' => $this->nombre, 'nroCuenta'=>$this->nroCuenta]);
        return $save;
    }

    public function editarFacultad($idFacultad)
    {

        DB::table('facultad')->where('idFacultad',$idFacultad)->update(['codFacultad' => $this->codFacultad, 'nombre'=> $this->nombre, 'nroCuenta'=>$this->nroCuenta]);

    }

    public function eliminarFacultad($nombre)
    {
        DB::table('facultad')->where('nombre', $nombre)->update(['estado'=>0]);
    }

}
