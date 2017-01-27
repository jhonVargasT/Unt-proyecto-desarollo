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
        $facultadbd = DB::select('select * from facultad ');

        foreach ($facultadbd as $facultad) {
            $facu = $facultad->todossusatributos;
        }

        return $facu;
    }

    public function consultarFacultades()
    {
        $facultadbd = DB::select('select * from facultad');

        return $facultadbd;
    }

    public function consultarFacultadid($idFacultad)
    {
        $facultadbd = DB::table('facultad')->where('idFacultad',$idFacultad)->get();
        return $facultadbd;
    }

    public function consultarFacultadesCodigo($codigo)
    {
        $facultadbd = DB::table('facultad')->where('codFacultad',$codigo)->orderBy('idFacultad', 'desc')->get();
        return $facultadbd;
    }

    public function consultarFacultadesNombre($nombre)
    {
        $facultadbd = DB::table('facultad')->where('nombre', 'like', '%' . $nombre . '%')->orderBy('idFacultad', 'desc')->get();
        return $facultadbd;
    }

    public function consultarFacultadesCuentaInterna($nroCuenta)
    {
        $facultadbd = DB::table('facultad')->where('nroCuenta', 'like', '%' . $nroCuenta . '%')->orderBy('idFacultad', 'desc')->get();
        return $facultadbd;
    }

    public function save()
    {
        $facultadbd = DB::select('select * from facultad where codFacultad=:codFacultad and nombre=:nombre and nroCuenta=:nroCuenta', ['codFacultad' => $this->codFacultad, 'nombre' => $this->nombre, 'nroCuenta' => $this->nroCuenta]);

        if ($facultadbd != null) {
            return false;
        } else {
            DB::table('facultad')->insert(['codFacultad' => $this->codFacultad, 'nombre' => $this->nombre, 'nroCuenta' => $this->nroCuenta]);
            return true;
        }
    }

    public function editarFacultad($idpersona)
    {
        DB::table('facultad')->where('idFacultad', $idpersona)->update(['codFacultad' => $this->codFacultad, 'nombre' => $this->nombre, 'nroCuenta' => $this->nroCuenta]);
    }

    public function eliminarFacultad($idpersona)
    {
        DB::table('persona')->where('idFacultad', $idpersona)->update(['estado' => 0]);
    }

}
