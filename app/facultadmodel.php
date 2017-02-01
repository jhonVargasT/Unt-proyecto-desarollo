<?php

namespace App;


use Illuminate\Support\Facades\DB;
use PDOException;

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
        $facultadbd = DB::table('facultad')->where('idFacultad', $idFacultad)->get();
        return $facultadbd;
    }

    public function consultarFacultadesCodigo($codigo)
    {
        $facultadbd = DB::table('facultad')
            ->where('codFacultad', $codigo)
            ->where('estado', 1)->orderBy('idFacultad', 'desc')->get();
        return $facultadbd;
    }

    public function consultarFacultadesNombre($nombre)
    {
        $facultadbd = DB::table('facultad')
            ->where('nombre', 'like', '%' . $nombre . '%')
            ->where('estado', 1)->orderBy('idFacultad', 'desc')->get();
        return $facultadbd;
    }

    public function consultarFacultadesCuentaInterna($nroCuenta)
    {
        $facultadbd = DB::table('facultad')
            ->where('nroCuenta', 'like', '%' . $nroCuenta . '%')
            ->where('estado', 1)->orderBy('idFacultad', 'desc')->get();
        return $facultadbd;
    }

    public function save()
    {
        try {
            DB::transaction(function () {
                DB::table('facultad')->insert(['codFacultad' => $this->codFacultad, 'nombre' => $this->nombre, 'nroCuenta' => $this->nroCuenta]);
                return true;
            });
        } catch (PDOException $e) {
            return false;
        }
    }

    public function editarFacultad($idFacultad)
    {
        DB::table('facultad')->where('idFacultad', $idFacultad)->update(['codFacultad' => $this->codFacultad, 'nombre' => $this->nombre, 'nroCuenta' => $this->nroCuenta]);
    }

    public function eliminarFacultad($idFacultad)
    {
        DB::table('facultad')->where('idFacultad', $idFacultad)->update(['estado' => 0]);
        DB::table('escuela')->where('estado', 1)->update(['estado' => 0]);
    }

}
