<?php

namespace App;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class utilmodel extends Model
{
    private $mensaje;
    private $idPersonal;
    private $funcion;

    /**
     * util constructor.
     * @param $mensaje
     * @param $idPersonal
     * @param $funcion
     */
    public function __construct()
    {
    }

    /**
     * @return array
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * @param array $mensaje
     */
    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
    }

    /**
     * @return mixed
     */
    public function getIdPersonal()
    {
        return $this->idPersonal;
    }

    /**
     * @param mixed $idPersonal
     */
    public function setIdPersonal($idPersonal)
    {
        $this->idPersonal = $idPersonal;
    }

    /**
     * @return mixed
     */
    public function getFuncion()
    {
        return $this->funcion;
    }

    /**
     * @param mixed $funcion
     */
    public function setFuncion($funcion)
    {
        $this->funcion = $funcion;
    }

    public function insertarError()
    {
        $value = Session::get('personalC');
        $logunt = new loguntemodel();
        $this->setIdPersonal($logunt->obtenerCodigoPersonal($value));
        try{
           DB::table('log_errores_sistema')->insert(['mensaje'=>$this->mensaje,'funcion'=>$this->funcion,'coPersonal'=>$this->idPersonal]);
        }catch (Exception $e)
        {
         $this->setFuncion('insertar error');
         $this->setMensaje($e->getMessage());
         $this->insertarError();
        }
    }

}
