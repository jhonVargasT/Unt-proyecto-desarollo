<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDOException;

class subtramitemodel
{
    private $codigotasa;
    private $nombre;
    private $precio;
    private $estado;
    private $idTramite;

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

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function bdTramite($nombre)
    {
        $idTra = DB::select('select codTramite from tramite where nombre=:nombre', ['nombre' => $nombre]);
        foreach ($idTra as $idT) {
            return $id = $idT->codTramite;
        }
    }

    public function bdTramitexClasificador($clasificador)
    {
        $id = null;
        $idTra = DB::select('select codTramite from tramite where clasificador =  ' . $clasificador . '  ');
        foreach ($idTra as $idT) {
            $id = $idT->codTramite;
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
                DB::table('subtramite')->insert(['codigoSubtramite' => $this->codigotasa, 'nombre' => $this->nombre, 'precio' => $this->precio, 'idTramite' => $this->idTramite]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
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
                DB::table('subtramite')->where('codSubtramite', 1)->update(['codigoSubtramite' => $this->codigotasa, 'nombre' => $this->nombre, 'precio' => $this->precio, 'idTramite' => $this->idTramite]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function consultarId($nombre)
    {
        $val = null;
        $subtramitebd = DB::select('select codSubtramite from  subtramite where estado = 1 and nombre=:nombre', ['nombre' => $nombre]);
        foreach ($subtramitebd as $tr) {
            $val = $tr->codSubtramite;
        }
        return $val;
    }

    public function consultarSubtramiteid($codSubtramite)
    {
        $subtramitebd = DB::select('select  codSubtramite, codigoSubtramite, subtramite.nombre as snombre, precio, tramite.nombre as tnombre from tramite left join subtramite on tramite.codTramite = subtramite.idTramite where 
        tramite.codTramite = subtramite.idTramite and subtramite.codSubtramite = ' . $codSubtramite . ' and tramite.estado=1 and subtramite.estado=1');
        return $subtramitebd;
    }

    public function consultarSubtramiteTramite($nombreTramite)
    {
        $subtramitebd = DB::select('select * from tramite left join subtramite on tramite.codTramite = subtramite.idTramite where 
        tramite.codTramite = subtramite.idTramite and tramite.nombre like "%' . $nombreTramite . '%" and tramite.estado=1 and subtramite.estado=1');
        return $subtramitebd;
    }

    public function consultarSubtramiteNombre($nombreSubtramite)
    {
        $subtramitebd = DB::table('subtramite')
            ->where('nombre', 'like', '%' . $nombreSubtramite . '%')
            ->where('estado', 1)
            ->orderBy('codSubtramite', 'desc')->get();
        return $subtramitebd;
    }

    public function consultarSubtramiteidNombre($nombreSubtramite)
    {
        $subtramitebd = DB::table('subtramite')
            ->where('nombre', $nombreSubtramite)
            ->where('estado', 1)
            ->get();
        $id = null;
        foreach ($subtramitebd as $su) {
            $id = $su->codSubtramite;
        }
        return $id;
    }

    public function consultarSiafNombreSubtramite($nombreSubtramite)
    {
        $clas = null;
        $subtramitebd = DB::select('select clasificador from tramite left join subtramite on tramite.codTramite = subtramite.idTramite where 
        tramite.codTramite = subtramite.idTramite and tramite.estado=1 and subtramite.estado=1 and subtramite.nombre =:nombre', ['nombre' => $nombreSubtramite]);

        foreach ($subtramitebd as $sub) {
            $clas = $sub->clasificador;
        }
        return $clas;
    }

    public function consultarSubtramiteCodigoTasa($codigo)
    {
        $subtramitebd = DB::table('subtramite')
            ->where('codigoSubtramite', 'like', '%' . $codigo . '%')
            ->where('estado', 1)
            ->orderBy('codSubtramite', 'desc')->get();
        return $subtramitebd;
    }

    public function consultarCodigoSubtramiteCodSubtramite($codSubtramite)
    {
        $sub = null;
        $subtramitebd = DB::select('select codigoSubtramite from subtramite where codSubtramite = "' . $codSubtramite . '"');
        foreach ($subtramitebd as $s) {
            $sub = $s->codigoSubtramite;
        }
        return $sub;
    }

    public function consultarSubtramites()
    {
        $subtramitebd = DB::table('subtramite')
            ->orderBy('codSubtramite', 'desc')->get();
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
            return false;
        }
        return true;
    }


}
