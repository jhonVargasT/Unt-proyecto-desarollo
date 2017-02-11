<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDOException;

class pagomodel
{
  private $lugar;
  private $detalle;
  private $fecha;
  private $pago;
  private $idPersona;
  private $idSubtramite;


    /**
     * pagomodel constructor.
     */
    public function __construct()
    {

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
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     * @return pagomodel
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPago()
    {
        return $this->pago;
    }

    /**
     * @param mixed $pago
     * @return pagomodel
     */
    public function setPago($pago)
    {
        $this->pago = $pago;
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

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function bdPersonaDni($var)
    {
        $obj=null;
        $personabd = DB::table('persona')->select('codPersona')->where('dni','=',$var)->get();
        foreach ($personabd as $per)
        {
            $obj = $per->codPersona;
        }
        return $obj;
    }

    public function bdPersonaRuc($var)
    {
        $obj=null;
        $personabd = DB::table('persona')
            ->leftJoin('cliente', 'persona.codPersona', '=', 'cliente.idPersona')
            ->where('cliente.ruc','=', $var)
            ->get();

        foreach ($personabd as $per)
        {
            $obj = $per->codPersona;
        }

        return $obj;
    }

    public function bdPersonaCodigoAlumno($var)
    {
        $obj=null;
        $personabd = DB::table('persona')
            ->leftJoin('alumno', 'persona.codPersona', '=', 'alumno.idPersona')
            ->where('alumno.codigoAlumno','=', $var)
            ->get();

        foreach ($personabd as $per)
        {
            $obj = $per->codPersona;
        }

        return $obj;
    }

    public function bdSubtramite($var)
    {
        $obj=null;
        $subtramitebd = DB::table('subtramiet')->select('codSubtramite')->where('dni','=',$var)->get();
        foreach ($subtramitebd as $sub)
        {
            $obj = $sub->codPersona;
        }
        return $obj;
    }

    public function savePago()
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-d-m H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('registrarPago');
        $logunt->setCodigoPersonal($codPers);
        try {
            DB::transaction(function () use ($logunt) {
                DB::table('pago')->insert(['detalle' => $this->detalle, 'fecha' => $this->fecha,'idPersona'=>$this->idPersona,'idSubtramite'=>$this->idSubtramite]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

}
