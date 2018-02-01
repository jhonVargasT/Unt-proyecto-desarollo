<?php

namespace App;

use http\Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDOException;
use App\Http\Controllers\util;

class subtramitemodel
{
    private $codigotasa;
    private $nombre;
    private $precio;
    private $estado;
    private $idTramite;
    private $unidad;

    /**
     * subtramitemodel constructor.
     */
    public function __construct()
    {
        $this->pago = array();
    }

    /**
     * @return mixed
     */
    public function getCodigotasa()
    {
        return $this->codigotasa;
    }

    /**
     * @param mixed $codigotasa
     * @return subtramitemodel
     */
    public function setCodigotasa($codigotasa)
    {
        $this->codigotasa = $codigotasa;
        return $this;
    }

    /**
     * @return mixed
     */


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

    /**
     * @return mixed
     */
    public function getUnidad()
    {
        return $this->unidad;
    }

    /**
     * @param mixed $unidad
     * @return subtramitemodel
     */
    public function setUnidad($unidad)
    {
        $this->unidad = $unidad;
        return $this;
    }


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function bdTramite($nombre)
    {
        $id = null;
        try {
            $idTra = DB::select('select codTramite from tramite where nombre=:nombre', ['nombre' => $nombre]);
            foreach ($idTra as $idT) {
                $id = $idT->codTramite;
            }

        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'bdTramite/subtramitemodel');
            return null;
        }
        return $id;
    }

    public function bdTramitexClasificador($clasificador)
    {
        try {
            $id = null;
            $idTra = DB::select('select codTramite from tramite where clasificador =:clasificador', ['clasificador' => $clasificador]);
            foreach ($idTra as $idT) {
                $id = $idT->codTramite;
            }
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'bdTramitexClasificador/subtramitemodel');
            return null;
        }
        return $id;
    }

    public function save()
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('registrarSubtramite');
        $logunt->setCodigoPersonal($codPers);
        try {
            DB::transaction(function () use ($logunt) {
                DB::table('subtramite')->insert(['codigoSubtramite' => $this->codigotasa, 'nombre' => $this->nombre, 'precio' => $this->precio, 'idTramite' => $this->idTramite, 'unidadOperativa' => $this->unidad]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'save/subtramitemodel');
            return false;
        }
        return true;
    }

    public function editarSubtramite($codSubtramite)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('editarSubtramite');
        $logunt->setCodigoPersonal($codPers);
        try {
            DB::transaction(function () use ($codSubtramite, $logunt) {
                DB::table('subtramite')->where('codSubtramite', $codSubtramite)->update(['codigoSubtramite' => $this->codigotasa, 'nombre' => $this->nombre, 'precio' => $this->precio, 'idTramite' => $this->idTramite, 'unidadOperativa' => $this->unidad]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), ' editarSubtramite/subtramitemodel');
            return false;
        }
        return true;
    }

    public function consultarId($nombre)
    {
        try {
            $val = null;
            $subtramitebd = DB::select('select codSubtramite from  subtramite where estado = 1 and nombre=:nombre', ['nombre' => $nombre]);
            foreach ($subtramitebd as $tr) {
                $val = $tr->codSubtramite;
            }
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarId/subtramitemodel');
            return false;
        }
        return $val;
    }

    public function consultarSubtramiteid($codSubtramite)
    {
        try {
            $subtramitebd = DB::select('select  codSubtramite, codigoSubtramite, subtramite.nombre as snombre, precio, tramite.nombre as tnombre, unidadOperativa from tramite left join subtramite on tramite.codTramite = subtramite.idTramite where 
        tramite.codTramite = subtramite.idTramite and subtramite.codSubtramite = ' . $codSubtramite . ' and tramite.estado=1 and subtramite.estado=1');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarSubtramiteid/subtramitemodel');
            return false;
        }
        return $subtramitebd;
    }

    public function consultarSubtramiteTramite($nombreTramite)
    {
        try {
            $subtramitebd = DB::select('select subtramite.codSubtramite,tramite.nombre as fnombre, subtramite.nombre as tnombre, subtramite.unidadOperativa, subtramite.codigoSubtramite, subtramite.precio  
            from subtramite left join tramite on subtramite.idTramite = tramite.codTramite where tramite.estado =1 and subtramite.estado=1 and tramite.nombre=:nombre', ["nombre" => $nombreTramite]);
        } catch (Exception $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), ' consultarSubtramiteTramite/subtramitemodel');
            return null;
        }
        return $subtramitebd;
    }

    public function consultarSubtramiteNombre($nombreSubtramite)
    {
        try {
            $subtramitebd = DB::select('select subtramite.codSubtramite,tramite.nombre as fnombre, subtramite.nombre as tnombre, subtramite.unidadOperativa, subtramite.codigoSubtramite, subtramite.precio  
            from subtramite left join tramite on subtramite.idTramite = tramite.codTramite where tramite.estado =1 and subtramite.estado=1 and subtramite.nombre=:nombre', ["nombre" => $nombreSubtramite]);
        } catch (Exception $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarSubtramiteNombre/subtramitemodel');
            return null;
        }
        return $subtramitebd;
    }

    public function consultarSubtramiteidNombre($nombreSubtramite)
    {
        try {
            $subtramitebd = DB::table('subtramite')
                ->where('nombre', $nombreSubtramite)
                ->where('estado', 1)
                ->get();
            $id = null;
            foreach ($subtramitebd as $su) {
                $id = $su->codSubtramite;
            }
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarSubtramiteNombre/subtramitemodel');
            return null;
        }
        return $id;
    }

    public function consultarSiafNombreSubtramite($nombreSubtramite)
    {
        try {
            $clas = null;
            $subtramitebd = DB::select('select clasificador from tramite left join subtramite on tramite.codTramite = subtramite.idTramite where 
        tramite.codTramite = subtramite.idTramite and tramite.estado=1 and subtramite.estado=1 and subtramite.nombre =:nombre', ['nombre' => $nombreSubtramite]);

            foreach ($subtramitebd as $sub) {
                $clas = $sub->clasificador;
            }
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarSiafNombreSubtramite/subtramitemodel');
            return null;
        }
        return $clas;
    }

    public function consultarSubtramiteCodigoTasa($codigo)
    {
        try {
            $subtramitebd = DB::select('select subtramite.codSubtramite,tramite.nombre as fnombre, subtramite.nombre as tnombre, subtramite.unidadOperativa, subtramite.codigoSubtramite, subtramite.precio  
            from subtramite left join tramite on subtramite.idTramite = tramite.codTramite where tramite.estado =1 and subtramite.estado=1 and subtramite.codigoSubtramite=:codigoSubtramite', ["codigoSubtramite" => $codigo]);
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), ' consultarSubtramiteCodigoTasa/subtramitemodel');
            return null;
        }
        return $subtramitebd;
    }

    public function consultarCodigoSubtramiteCodSubtramite($codSubtramite)
    {
        try {
            $sub = null;
            $subtramitebd = DB::select('select codigoSubtramite from subtramite where codSubtramite = "' . $codSubtramite . '" and estado = 1');
            foreach ($subtramitebd as $s) {
                $sub = $s->codigoSubtramite;
            }
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarCodigoSubtramiteCodSubtramite/subtramitemodel');
            return null;
        }
        return $sub;
    }

    public function consultarSubtramites()
    {
        try {
            $subtramitebd = DB::select('select subtramite.codSubtramite,tramite.nombre as fnombre, subtramite.nombre as tnombre, subtramite.unidadOperativa, subtramite.codigoSubtramite, subtramite.precio  
            from subtramite left join tramite on subtramite.idTramite = tramite.codTramite where tramite.estado =1 and subtramite.estado=1');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarSubtramites/subtramitemodel');
            return null;
        }
        return $subtramitebd;
    }

    public function eliminarSubtramite($codSubtramite)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('eliminarSubtramite');
        $logunt->setCodigoPersonal($codPers);

        try {
            DB::transaction(function () use ($codSubtramite, $logunt) {
                DB::table('subtramite')->where('codSubtramite', $codSubtramite)->update(['estado' => 0]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'eliminarSubtramite/subtramitemodel');
            return false;
        }
        return true;
    }


}
