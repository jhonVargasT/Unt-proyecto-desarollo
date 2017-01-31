<?php

namespace App;


use Illuminate\Support\Facades\DB;

class pagomodel
{
    private $lugar;
    private $detalle;
    private $fechaDevolucion;
    private $estado;
    private $idPersona;
    private $idSubtramite;
    private $idPersonaxNombre;

    /**
     * pagomodel constructor.
     */
    public function __construct($lugar1, $detalle)
    {
        $this->lugar = $lugar1;
        $this->detalle = $detalle;


    }

    /**
     * @return mixed
     */
    public function getLugar()
    {
        return $this->lugar;
    }

    /**
     * @param mixed $lugar
     * @return pagomodel
     */
    public function setLugar($lugar)
    {
        $this->lugar = $lugar;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDetalle()
    {
        return $this->detalle;
    }

    /**
     * @param mixed $detalle
     * @return pagomodel
     */
    public function setDetalle($detalle)
    {
        $this->detalle = $detalle;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFechaDevolucion()
    {
        return $this->fechaDevolucion;
    }

    /**
     * @param mixed $fechaDevolucion
     * @return pagomodel
     */
    public function setFechaDevolucion($fechaDevolucion)
    {
        $this->fechaDevolucion = $fechaDevolucion;
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
     * @return pagomodel
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
        return $this;
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
     * @return pagomodel
     */
    public function setIdPersona($idPersona)
    {
        $this->idPersona = $idPersona;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdSubtramite()
    {
        return $this->idSubtramite;
    }

    /**
     * @param mixed $idSubtramite
     * @return pagomodel
     */
    public function setIdSubtramite($idSubtramite)
    {
        $this->idSubtramite = $idSubtramite;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdPersonaxNombre()
    {
        return $this->idPersonaxNombre;
    }

    /**
     * @param mixed $idPersonaxNombre
     * @return pagomodel
     */
    public function setIdPersonaxNombre($idPersonaxNombre)
    {
        $this->idPersonaxNombre = $idPersonaxNombre;
        return $this;
    }


    public function bdPersona($dni)
    {
        $idFacultad = DB::select('select idPersona from persona where dni=:dni', ['nombre' => $dni]);
        foreach ($idFacultad as $if) {
            $id = $if->idFacultad;
        }
        return $id;
    }

    public function bdPersonaxNombre($nombres, $apellidos)
    {
        $idFacultad = DB::select('select idPersona from persona where nombres=:nombres and apellidos=:apellidos', ['nombres' => $nombres, 'apellidos' => $apellidos]);
        foreach ($idFacultad as $if) {
            $id = $if->idFacultad;
        }
        return $id;
    }

    public function bdSubtramite($nombre)
    {
        $cFacu = DB::select('select codSubtramite from subtramite where nombre=:nombre', ['nombre' => $nombre]);
        foreach ($cFacu as $cFa) {
            $cF = $cFa->idFacultad;
        }
        return $cF;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function save()
    {
        $save = DB::table('pago')->insert(['lugar' => $this->lugar, 'detalle' => $this->detalle, 'fechaDevolucion' => $this->fechaDevolucion, 'IdPersona' => $this->idPersona, 'idSubtramite' => $this->idSubtramite]);
        return $save;
    }

    public function consultarPagosEliminadosFacultad()
    {
        $sentence = BD::table('');
    }


}
