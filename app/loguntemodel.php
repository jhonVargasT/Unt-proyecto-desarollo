<?php

namespace App;


use Illuminate\Support\Facades\DB;
use PDOException;
use App\Http\Controllers\util;

class loguntemodel
{
    private $descripcion;
    private $fecha;
    private $estado;
    private $codigoPersonal;

    /**
     * loguntemodel constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     * @return loguntemodel
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
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
     * @return loguntemodel
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
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
     * @return loguntemodel
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodigoPersonal()
    {
        return $this->codigoPersonal;
    }

    /**
     * @param mixed $codigoPersonal
     * @return loguntemodel
     */
    public function setCodigoPersonal($codigoPersonal)
    {
        $this->codigoPersonal = $codigoPersonal;
        return $this;
    }


    public function saveLogUnt()
    {
        try {
            DB::transaction(function () {
                DB::table('logunt')->insert(['fecha' => $this->fecha, 'descripcion' => $this->descripcion, 'codigoPersonal' => $this->codigoPersonal]);
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'bdPersonaRuc/pagomodel');
            return false;
        }
        return true;
    }

    public function obtenerCodigoPersonal($cuenta)
    {
        $cp=null;
        try {
            $personalbd = DB::select('select * from personal where cuenta=:cuenta', ['cuenta' => $cuenta]);

            foreach ($personalbd as $pbd) {
                 $cp = $pbd->idPersonal;
            }
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'bdPersonaRuc/pagomodel');
            return false;
        }
        return $cp;
    }
}
