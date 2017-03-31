<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDOException;

class pagomodel
{
    private $detalle;
    private $fecha;
    private $pago;
    private $modalidad;
    private $idPersona;
    private $idSubtramite;
    private $coPersonal;
    private $deuda;

    /**
     * pagomodel constructor.
     */
    public function __construct()
    {

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
    public function getModalidad()
    {
        return $this->modalidad;
    }

    /**
     * @param mixed $modalidad
     * @return pagomodel
     */
    public function setModalidad($modalidad)
    {
        $this->modalidad = $modalidad;
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
    public function getCoPersonal()
    {
        return $this->coPersonal;
    }

    /**
     * @param mixed $coPersonal
     * @return pagomodel
     */
    public function setCoPersonal($coPersonal)
    {
        $this->coPersonal = $coPersonal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeuda()
    {
        return $this->deuda;
    }

    /**
     * @param mixed $deuda
     * @return pagomodel
     */
    public function setDeuda($deuda)
    {
        $this->deuda = $deuda;
        return $this;
    }


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function bdPersonaDni($var)
    {
        $cp = null;
        $personabd = DB::table('persona')->where('dni', '=', $var)->where('estado', 1)->get();

        foreach ($personabd as $pbd) {
            $cp = $pbd->codPersona;
        }
        return $cp;
    }

    public function bdPersonaRuc($var)
    {
        $obj = null;
        $personabd = DB::table('persona')
            ->leftJoin('cliente', 'persona.codPersona', '=', 'cliente.idPersona')
            ->where('cliente.ruc', '=', $var)
            ->get();

        foreach ($personabd as $per) {
            $obj = $per->codPersona;
        }

        return $obj;
    }

    public function bdPersonaCodigoAlumno($var)
    {
        $obj = null;
        $personabd = DB::table('persona')
            ->leftJoin('alumno', 'persona.codPersona', '=', 'alumno.idPersona')
            ->where('alumno.codigoAlumno', '=', $var)
            ->get();

        foreach ($personabd as $per) {
            $obj = $per->codPersona;
        }

        return $obj;
    }

    public function bdSubtramite($var)
    {
        $obj = null;
        $subtramitebd = DB::table('subtramite')->where('nombre', '=', $var)->where('estado', 1)->get();

        foreach ($subtramitebd as $subbd) {
            $obj = $subbd->codSubtramite;
        }
        return $obj;
    }

    public function savePago($contaux)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('GuardarPago');
        $logunt->setCodigoPersonal($codPers);
        if (Session::has('personalC')) {
            date_default_timezone_set('Etc/GMT+5');
            $date = date('Y-m-d H:i:s', time());
            $logunt = new loguntemodel();
            $value = Session::get('personalC');
            $codPers = $logunt->obtenerCodigoPersonal($value);
            $logunt->setFecha($date);
            $logunt->setDescripcion('registrarPago');
            $logunt->setCodigoPersonal($codPers);
            try {
                DB::transaction(function () use ($logunt, $contaux) {
                    if ($this->deuda == 0) {
                        DB::table('pago')->insert(['detalle' => $this->detalle, 'fecha' => $this->fecha, 'modalidad' => $this->modalidad, 'idPersona' => $this->idPersona, 'idSubtramite' => $this->idSubtramite, 'coPersonal' => $this->coPersonal]);
                        DB::table('subtramite')->where('codSubtramite', $this->idSubtramite)->update(['contador' => $contaux]);

                    } elseif ($this->deuda != 0) {
                        DB::table('pago')->insert(['detalle' => $this->detalle, 'fecha' => $this->fecha, 'modalidad' => $this->modalidad, 'idPersona' => $this->idPersona, 'idSubtramite' => $this->idSubtramite, 'coPersonal' => $this->coPersonal, 'estadodeuda' => $this->deuda]);
                        DB::table('subtramite')->where('codSubtramite', $this->idSubtramite)->update(['contador' => $contaux]);
                    }
                    $logunt->saveLogUnt();
                });
            } catch (PDOException $e) {
                return false;
            }
            return true;
        } else {
            try {
                DB::transaction(function () {
                    DB::table('pago')->insert(['detalle' => $this->detalle, 'fecha' => $this->fecha, 'modalidad' => $this->modalidad, 'idPersona' => $this->idPersona, 'idSubtramite' => $this->idSubtramite]);
                });
            } catch (PDOException $e) {
                return false;
            }
            return true;
        }
    }

    public function saveExcel($contaux)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        if (Session::has('personalC')) {
            $logunt = new loguntemodel();
            $value = Session::get('personalC');
            $codPers = $logunt->obtenerCodigoPersonal($value);
            $logunt->setFecha($date);
            $logunt->setDescripcion('ImportExcel');
            $logunt->setCodigoPersonal($codPers);
            date_default_timezone_set('Etc/GMT+5');
            $date = date('Y-m-d H:i:s', time());
            $logunt = new loguntemodel();
            $value = Session::get('personalC');
            $codPers = $logunt->obtenerCodigoPersonal($value);
            $logunt->setFecha($date);
            $logunt->setDescripcion('registrarPago');
            $logunt->setCodigoPersonal($codPers);
            try {
                DB::transaction(function () use ($logunt, $contaux) {
                    DB::table('pago')->insert(['detalle' => $this->detalle, 'fecha' => $this->fecha, 'modalidad' => $this->modalidad, 'idSubtramite' => $this->idSubtramite]);
                    DB::table('subtramite')->where('codSubtramite', $this->idSubtramite)->update(['contador' => $contaux]);
                    $logunt->saveLogUnt();
                });
            } catch (PDOException $e) {
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    public function consultarAlumnoDNI($dni, $val)
    {
        $alumnobd = DB::select('SELECT pago.codPago, p1.dni AS p1dni, p1.nombres AS p1nombres, p1.apellidos AS p1apellidos, subtramite.nombre, pago.fecha AS pfecha, subtramite.precio, pago.modalidad, detalle, estadodeuda,
        p2.nombres AS pnombres, p2.apellidos AS papellidos FROM pago
        LEFT JOIN subtramite ON pago.idSubtramite = subtramite.codSubtramite
        LEFT JOIN personal ON pago.coPersonal = personal.idPersonal
        LEFT JOIN persona AS p1 ON p1.codPersona = pago.idPersona
        LEFT JOIN persona AS p2 ON p2.codPersona = personal.idPersona
        WHERE pago.idSubtramite = subtramite.codSubtramite AND pago.coPersonal = personal.idPersonal 
        AND p1.codPersona = pago.idPersona AND p2.codPersona = personal.idPersona AND pago.estado = 1 
        and pago.estadodeuda = ' . $val . '
        AND p1.dni = ' . $dni . ' order by pago.codPago desc ');
        return $alumnobd;
    }

    public function consultarAlumnoCodigo($codAlumno, $val)
    {
        $alumnobd = DB::select('select pago.codPago, p1.dni as p1dni, p1.nombres as p1nombres, p1.apellidos as p1apellidos,subtramite.nombre, pago.fecha as pfecha ,subtramite.precio, pago.modalidad, p2.nombres as pnombres, p2.apellidos as papellidos, detalle, estadodeuda from pago
        left join subtramite on pago.idSubtramite = subtramite.codSubtramite
        left join personal on pago.coPersonal = personal.idPersonal
        left join persona as p1 on p1.codPersona = pago.idPersona
        left join persona as p2 on p2.codPersona = personal.idPersona
        left join alumno on p1.codPersona=alumno.idPersona
        where pago.idSubtramite = subtramite.codSubtramite
        and pago.coPersonal = personal.idPersonal
        and p1.codPersona = pago.idPersona
        and p2.codPersona = personal.idPersona
        and p1.codPersona=alumno.idPersona
        and pago.estadodeuda = ' . $val . '
        and pago.estado=1 and alumno.codAlumno = ' . $codAlumno . ' order by pago.codPago desc ');

        return $alumnobd;
    }

    public function consultarClienteRuc($ruc, $val)
    {
        $clientebd = DB::select('select pago.codPago, p1.dni as p1dni, p1.nombres as p1nombres, p1.apellidos as p1apellidos,subtramite.nombre, pago.fecha as pfecha ,subtramite.precio, pago.modalidad, p2.nombres as pnombres, p2.apellidos as papellidos, detalle, estadodeuda from pago
        left join subtramite on pago.idSubtramite = subtramite.codSubtramite
        left join personal on pago.coPersonal = personal.idPersonal
        left join persona as p1 on p1.codPersona = pago.idPersona
        left join persona as p2 on p2.codPersona = personal.idPersona
        left join cliente on p1.codPersona=cliente.idPersona
        where pago.idSubtramite = subtramite.codSubtramite
        and pago.coPersonal = personal.idPersonal
        and p1.codPersona = pago.idPersona
        and p2.codPersona = personal.idPersona
        and p1.codPersona=cliente.idPersona
        and pago.estadodeuda = ' . $val . '
        and pago.estado=1  and cliente.ruc = ' . $ruc . ' order by pago.codPago desc ');
        return $clientebd;
    }

    public function consultarCodigoPago($codPago, $val)
    {
        $pagobd = DB::select('select pago.codPago, p1.dni as p1dni, p1.nombres as p1nombres, p1.apellidos as p1apellidos,subtramite.nombre, pago.fecha as pfecha ,subtramite.precio, pago.modalidad, p2.nombres as pnombres, p2.apellidos as papellidos, detalle, estadodeuda from pago
        left join subtramite on pago.idSubtramite = subtramite.codSubtramite
        left join personal on pago.coPersonal = personal.idPersonal
        left join persona as p1 on p1.codPersona = pago.idPersona
        left join persona as p2 on p2.codPersona = personal.idPersona
        where pago.idSubtramite = subtramite.codSubtramite
        and pago.coPersonal = personal.idPersonal
        and p1.codPersona = pago.idPersona
        and p2.codPersona = personal.idPersona
        and pago.estado=1 and pago.estadodeuda = ' . $val . ' and pago.codPago = ' . $codPago . ' order by pago.codPago desc');

        return $pagobd;
    }

    public function consultarCodigoPagoReporte($codPago, $val)
    {
        $pagobd = DB::select('select pago.codPago, p1.dni as p1dni, p1.nombres as p1nombres, p1.apellidos as p1apellidos,subtramite.nombre, pago.fecha as pfecha ,subtramite.precio, pago.modalidad, p2.nombres as pnombres, p2.apellidos as papellidos, detalle, estadodeuda from pago
        left join subtramite on pago.idSubtramite = subtramite.codSubtramite
        left join personal on pago.coPersonal = personal.idPersonal
        left join persona as p1 on p1.codPersona = pago.idPersona
        left join persona as p2 on p2.codPersona = personal.idPersona
        where pago.idSubtramite = subtramite.codSubtramite
        and pago.coPersonal = personal.idPersonal
        and p1.codPersona = pago.idPersona
        and p2.codPersona = personal.idPersona
        and pago.estado=1 and subtramite.estado=1 and p1.estado =1 and pago.estadodeuda = ' . $val . ' and p2.estado=1 and pago.codPago = ' . $codPago . ' order by pago.codPago desc');

        return $pagobd;
    }

    public function consultarCodigoPersonal($codPersonal)
    {
        date_default_timezone_set('America/Lima');
        $dato = date('Y-m-d');

        $pagobd = DB::select('select pago.codPago, p1.dni as p1dni, p1.nombres as p1nombres, p1.apellidos as p1apellidos,subtramite.nombre, pago.fecha as pfecha ,subtramite.precio, pago.modalidad, p2.nombres as pnombres, p2.apellidos as papellidos, detalle, estadodeuda from pago
        left join subtramite on pago.idSubtramite = subtramite.codSubtramite
        left join personal on pago.coPersonal = personal.idPersonal
        left join persona as p1 on p1.codPersona = pago.idPersona
        left join persona as p2 on p2.codPersona = personal.idPersona
        where pago.idSubtramite = subtramite.codSubtramite
        and pago.coPersonal = personal.idPersonal
        and p1.codPersona = pago.idPersona
        and p2.codPersona = personal.idPersona
        and pago.estado=1 and subtramite.estado=1 and p1.estado =1 and p2.estado=1 and personal.codPersonal =:codPersonal and pago.fecha like "%' . $dato . '%" order by pago.fecha desc', ['codPersonal' => $codPersonal]);

        return $pagobd;
    }

    public function consultarPagos($val)
    {
        $alumnobd = DB::select(' SELECT pago.codPago, p1.dni AS p1dni,p1.nombres AS p1nombres, p1.apellidos AS p1apellidos,subtramite.nombre, pago.fecha AS pfecha, subtramite.precio, pago.modalidad, detalle, p2.nombres AS pnombres,p2.apellidos AS papellidos, estadodeuda FROM pago 
        LEFT JOIN subtramite ON pago.idSubtramite = subtramite.codSubtramite
        LEFT JOIN personal ON pago.coPersonal = personal.idPersonal
        LEFT JOIN persona AS p1 ON p1.codPersona = pago.idPersona
        LEFT JOIN persona AS p2 ON p2.codPersona = personal.idPersona
        WHERE pago.idSubtramite = subtramite.codSubtramite AND pago.coPersonal = personal.idPersonal 
        AND p1.codPersona = pago.idPersona and pago.estadodeuda = ' . $val . ' AND p2.codPersona = personal.idPersona AND pago.estado = 1 order by pago.codPago desc ');
        return $alumnobd;
    }

    public function eliminarPago($codPago)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('eliminarPago');
        $logunt->setCodigoPersonal($codPers);
        try {
            DB::transaction(function () use ($codPago, $logunt, $date) {
                DB::table('pago')->where('codPago', $codPago)->update(['fechaDevolucion' => $date]);
                DB::table('pago')->where('codPago', $codPago)->update(['estado' => 0]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function eliminarDeuda($codPago)
    {
        date_default_timezone_set('Etc/GMT+5');
        $date = date('Y-m-d H:i:s', time());
        $logunt = new loguntemodel();
        $value = Session::get('personalC');
        $codPers = $logunt->obtenerCodigoPersonal($value);
        $logunt->setFecha($date);
        $logunt->setDescripcion('eliminarDeuda');
        $logunt->setCodigoPersonal($codPers);
        try {
            DB::transaction(function () use ($codPago, $logunt) {
                DB::table('pago')->where('codPago', $codPago)->update(['estadodeuda' => 0]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    // pago,personal,subtramite,escuela,facultad
    public function listarPagosfacultad($estado, $modalidad, $fechaDesde, $fechaHasta, $facultad, $subtramite)
    {

        $pago = DB::table('pago')
            ->join('subtramite', 'subtramite.codSubtramite', '=', 'pago.idSubtramite')
            ->join('personal', 'users.idPersonal', '=', 'pago.coPersonal')
            ->select('users.*', 'contacts.phone', 'pago.price')
            ->where(['estado' => $estado, 'modalidad' => $modalidad])
            ->get();
    }

    // pago,personal,subtramite,escuela,facultad
    public function listarGeneral($estado, $modalidad, $fechaDesde, $fechaHasta, $tram, $valtram, $tipoRe, $fuefin, $local, $vallocal)
    {

        $pago = null;
        if ($modalidad == 'Todo' && $tram == 'Todo' && is_null($tipoRe) && is_null($fuefin) && is_null($local)) {
            $pago = $this->listarPagoNada($estado, $fechaDesde, $fechaHasta);
        } elseif ($modalidad != 'Todo' && $tram == 'Todo' && is_null($tipoRe) && is_null($fuefin) && is_null($local)) {
            $pago = $this->listarPagoModalidad($estado, $modalidad, $fechaDesde, $fechaHasta);
        } elseif ($modalidad != 'Todo' && $tram != 'Todo' && is_null($tipoRe) && is_null($fuefin) && is_null($local)) {
            $pago = $this->listarModTram($estado, $modalidad, $tram, $valtram, $fechaDesde, $fechaHasta);
        } elseif ($modalidad != 'Todo' && $tram != 'Todo' && is_null($tipoRe) && is_null($fuefin) && !is_null($local)) {
            $pago = $this->listarTramModLoc($estado, $modalidad, $tram, $valtram, $fechaDesde, $fechaHasta, $local, $vallocal);
        } elseif ($modalidad != 'Todo' && $tram == 'Todo' && is_null($fuefin) && is_null($local) && !is_null($tipoRe)) {
            $pago = $this->listarModTip($estado, $modalidad, $fechaDesde, $fechaHasta, $tipoRe);
        } elseif ($modalidad != 'Todo' && !is_null($tipoRe) && !is_null($fuefin) && !is_null($local) && $tram == 'Todo') {
            $pago = $this->listarMoTiFuLo($estado, $modalidad, $fechaDesde, $fechaHasta, $tipoRe, $fuefin, $local, $vallocal);
        } elseif ($modalidad != 'Todo' && $tram == 'Todo' && is_null($tipoRe) && is_null($fuefin) && !is_null($local)) {
            $pago = $this->listarMoLo($estado, $modalidad, $fechaDesde, $fechaHasta, $local, $vallocal);
        } elseif ($modalidad != 'Todo' && $tram == 'Todo' && is_null($tipoRe) && !is_null($fuefin) && !is_null($local)) {
            $pago = $this->listarMoFuLo($estado, $modalidad, $fechaDesde, $fechaHasta, $fuefin, $local, $vallocal);
        } elseif ($modalidad == 'Todo' && $tram != 'Todo' && is_null($tipoRe) && is_null($fuefin) && is_null($local)) {
            $pago = $this->listarTr($estado, $fechaDesde, $fechaHasta, $tram, $valtram);
        } elseif ($modalidad != 'Todo' && $tram != 'Todo' && is_null($tipoRe) && !is_null($fuefin) && !is_null($local)) {
            $pago = $this->listarMoTrFuLo($estado, $fechaDesde, $fechaHasta, $tram, $valtram, $fuefin, $local, $vallocal);
        } elseif ($modalidad == 'Todo' && $tram == 'Todo' && is_null($fuefin) && !is_null($tipoRe) && is_null($local)) {
            $pago = $this->listarTipoRe($estado, $fechaDesde, $fechaHasta, $tipoRe);
        } elseif ($modalidad == 'Todo' && $tram != 'Todo' && is_null($fuefin) && !is_null($tipoRe) && is_null($local)) {
            $pago = $this->listarTraTip($estado, $fechaDesde, $fechaHasta, $tram, $valtram, $tipoRe);
        } elseif ($modalidad == 'Todo' && $tram == 'Todo' && !is_null($fuefin) && !is_null($tipoRe) && is_null($local)) {
            $pago = $this->listarFueTip($estado, $fechaDesde, $fechaHasta, $tipoRe, $fuefin);
        } elseif ($modalidad == 'Todo' && $tram == 'Todo' && is_null($fuefin) && !is_null($tipoRe) && !is_null($local)) {
            $pago = $this->listarFueTipLo($estado, $fechaDesde, $fechaHasta, $tipoRe, $local, $vallocal);
        } elseif ($modalidad != 'Todo' && $tram != 'Todo' && is_null($fuefin) && is_null($local) && !is_null($tipoRe)) {
            $pago = $this->listarTip($estado, $fechaDesde, $fechaHasta, $tipoRe, $modalidad, $tram, $valtram);
        } elseif ($modalidad != 'Todo' && $tram == 'Todo' && is_null($local) && !is_null($fuefin) && !is_null($tipoRe)) {
            $pago = $this->listarMoFueTipFu($estado, $fechaDesde, $fechaHasta, $tipoRe, $modalidad, $fuefin);
        } elseif ($modalidad != 'Todo' && $tram != 'Todo' && !is_null($fuefin) && !is_null($tipoRe) && is_null($local)) {
            $pago = $this->listarMoTraFuTi($estado, $fechaDesde, $fechaHasta, $tipoRe, $modalidad, $fuefin, $tram, $valtram);
        } elseif ($modalidad != 'Todo' && $tram != 'Todo' && is_null($fuefin) && !is_null($tipoRe) && !is_null($local)) {
            $pago = $this->listarMoTraTiLo($estado, $fechaDesde, $fechaHasta, $tipoRe, $modalidad, $tram, $valtram, $local, $vallocal);
        } elseif ($modalidad == 'Todo' && $tram == 'Todo' && !is_null($fuefin) && is_null($tipoRe) && is_null($local)) {
            $pago = $this->listarFu($estado, $fechaDesde, $fechaHasta, $fuefin);
        } elseif ($modalidad != 'Todo' && $tram == 'Todo' && is_null($tipoRe) && is_null($local) && !is_null($fuefin)) {
            $pago = $this->listarMoFu($estado, $fechaDesde, $fechaHasta, $modalidad, $fuefin);
        } elseif ($modalidad == 'Todo' && $tram != 'Todo' && is_null($tipoRe) && is_null($local) && !is_null($fuefin)) {
            $pago = $this->listarTraFu($estado, $fechaDesde, $fechaHasta, $tram, $valtram, $fuefin);
        } elseif ($modalidad != 'Todo' && $tram != 'Todo' && is_null($tipoRe) && is_null($local) && !is_null($fuefin)) {
            $pago = $this->listarMoTraFu($estado, $fechaDesde, $fechaHasta, $modalidad, $tram, $valtram, $fuefin);
        } elseif ($modalidad == 'Todo' && $tram == 'Todo' && is_null($tipoRe) && is_null($fuefin) && !is_null($local)) {
            $pago = $this->listarLoc($estado, $fechaDesde, $fechaHasta, $local, $vallocal);
        } elseif ($modalidad == 'Todo' && $tram != 'Todo' && is_null($tipoRe) && is_null($fuefin) && !is_null($local)) {
            $pago = $this->listarTraLo($estado, $fechaDesde, $fechaHasta, $tram, $valtram, $local, $vallocal);
        } elseif ($modalidad == 'Todo' && $tram == 'Todo' && is_null($tipoRe) && !is_null($fuefin) && !is_null($local)) {
            $pago = $this->listarFueLo($estado, $fechaDesde, $fechaHasta, $fuefin, $local, $vallocal);
        } elseif ($modalidad != 'Todo' && $tram == 'Todo' && !is_null($tipoRe) && is_null($fuefin) && !is_null($local)) {
            $pago = $this->listarMoTiLo($estado, $fechaDesde, $fechaHasta, $modalidad, $tipoRe, $local, $vallocal);
        } elseif ($modalidad != 'Todo' && $tram != 'Todo' && !is_null($tipoRe) && !is_null($fuefin) && !is_null($local)) {
            $pago = $this->listarTodo($estado, $fechaDesde, $fechaHasta, $modalidad, $tipoRe, $fuefin, $local, $vallocal, $tram, $valtram);
        } else {
            $pago = null;
        }
        return $pago;
    }

    public function listarTodo($estado, $fechaDesde, $fechaHasta, $modalidad, $tipre, $fuefi, $local, $valloc, $tram, $valtra)
    {
        $pago = DB::table('pago')->select(['pago.codpago as codigopago', 'pago.modalidad as modalidad', 'sede.nombresede as nombresede', 'facultad.nombre as nombrefacultad',
            'escuela.nombre as nombreescuela', 'pago.fecha as fechapago', 'tramite.nombre as nombretramite', 'tramite.clasificador as clasi', 'tramite.fuentefinanc as fuentefinanc',
            'tramite.tipoRecurso as tiporecursod', 'subtramite.nombre as nombresubtramite', 'subtramite.precio as precio', 'pago.detalle as pagodetalle'])
            ->leftjoin('personal', 'pago.copersonal', '=', 'personal.idpersonal')
            ->leftjoin('persona', 'personal.idpersona', '=', 'persona.codPersona')
            ->leftjoin('subtramite', 'pago.idsubtramite', '=', 'subtramite.codsubtramite')
            ->leftjoin('tramite', 'tramite.codtramite', '=', 'subtramite.idtramite')
            ->leftjoin('persona as p', 'pago.idpersona', '=', 'p.codPersona')
            ->leftjoin('alumno', 'persona.codPersona', '=', 'alumno.idpersona')
            ->leftjoin('escuela', 'alumno.coescuela', '=', 'escuela.idescuela')
            ->leftjoin('facultad', 'escuela.codigofacultad', '=', 'facultad.idfacultad')
            ->leftjoin('sede', 'facultad.cosede', '=', 'sede.codsede')
            ->where([
                ['pago.estado', $estado],
                ['pago.fecha', '>', $fechaDesde],
                ['pago.fecha', '<', $fechaHasta],
                ['tramite.tipoRecurso', '=', $tipre],
                ['pago.modalidad', '=', $modalidad],
                ['tramite.fuentefinanc', '=', $fuefi],
                [$local, '=', $valloc],
                [$tram, '=', $valtra]
            ])->paginate(30);
        return $pago;
    }

    public function listarMoTiLo($estado, $fechaDesde, $fechaHasta, $modalidad, $tipre, $local, $valloc)
    {
        $pago = DB::table('pago')->select(['pago.codpago as codigopago', 'pago.modalidad as modalidad', 'sede.nombresede as nombresede', 'facultad.nombre as nombrefacultad',
            'escuela.nombre as nombreescuela', 'pago.fecha as fechapago', 'tramite.nombre as nombretramite', 'tramite.clasificador as clasi', 'tramite.fuentefinanc as fuentefinanc',
            'tramite.tiporecurso as tiporecurso', 'subtramite.nombre as nombresubtramite', 'subtramite.precio as precio', 'pago.detalle as pagodetalle'])
            ->leftjoin('personal', 'pago.copersonal', '=', 'personal.idpersonal')
            ->leftjoin('persona', 'personal.idpersona', '=', 'persona.codPersona')
            ->leftjoin('subtramite', 'pago.idsubtramite', '=', 'subtramite.codsubtramite')
            ->leftjoin('tramite', 'tramite.codtramite', '=', 'subtramite.idtramite')
            ->leftjoin('persona as p', 'pago.idpersona', '=', 'p.codPersona')
            ->leftjoin('alumno', 'persona.codPersona', '=', 'alumno.idpersona')
            ->leftjoin('escuela', 'alumno.coescuela', '=', 'escuela.idescuela')
            ->leftjoin('facultad', 'escuela.codigofacultad', '=', 'facultad.idfacultad')
            ->leftjoin('sede', 'facultad.cosede', '=', 'sede.codsede')
            ->where([
                ['pago.estado', $estado],
                ['pago.fecha', '>', $fechaDesde],
                ['pago.fecha', '<', $fechaHasta],
                ['tramite.tipoRecurso', '=', $tipre],
                ['pago.modalidad', '=', $modalidad],
                [$local, '=', $valloc]
            ])->paginate(30);
        return $pago;
    }

    public function listarFueLo($estado, $fechaDesde, $fechaHasta, $fue, $local, $valloc)
    {
        $pago = DB::table('pago')->select(['pago.codpago as codigopago', 'pago.modalidad as modalidad', 'sede.nombresede as nombresede', 'facultad.nombre as nombrefacultad',
            'escuela.nombre as nombreescuela', 'pago.fecha as fechapago', 'tramite.nombre as nombretramite', 'tramite.clasificador as clasi', 'tramite.fuentefinanc as fuentefinanc',
            'tramite.tiporecurso as tiporecurso', 'subtramite.nombre as nombresubtramite', 'subtramite.precio as precio', 'pago.detalle as pagodetalle'])
            ->leftjoin('personal', 'pago.copersonal', '=', 'personal.idpersonal')
            ->leftjoin('persona', 'personal.idpersona', '=', 'persona.codPersona')
            ->leftjoin('subtramite', 'pago.idsubtramite', '=', 'subtramite.codsubtramite')
            ->leftjoin('tramite', 'tramite.codtramite', '=', 'subtramite.idtramite')
            ->leftjoin('persona as p', 'pago.idpersona', '=', 'p.codPersona')
            ->leftjoin('alumno', 'persona.codPersona', '=', 'alumno.idpersona')
            ->leftjoin('escuela', 'alumno.coescuela', '=', 'escuela.idescuela')
            ->leftjoin('facultad', 'escuela.codigofacultad', '=', 'facultad.idfacultad')
            ->leftjoin('sede', 'facultad.cosede', '=', 'sede.codsede')
            ->where([
                ['pago.estado', $estado],
                ['pago.fecha', '>=', $fechaDesde],
                ['pago.fecha', '<=', $fechaHasta],
                ['tramite.fuentefinanc', '=', $fue],
                [$local, '=', $valloc]
            ])->paginate(30);
        return $pago;
    }

    public function listarTraLo($estado, $fechaDesde, $fechaHasta, $tram, $valtra, $local, $valloc)
    {
        $pago = DB::table('pago')->select(['pago.codpago as codigopago', 'pago.modalidad as modalidad', 'sede.nombresede as nombresede', 'facultad.nombre as nombrefacultad',
            'escuela.nombre as nombreescuela', 'pago.fecha as fechapago', 'tramite.nombre as nombretramite', 'tramite.clasificador as clasi', 'tramite.fuentefinanc as fuentefinanc',
            'tramite.tiporecurso as tiporecurso', 'subtramite.nombre as nombresubtramite', 'subtramite.precio as precio', 'pago.detalle as pagodetalle'])
            ->leftjoin('personal', 'pago.copersonal', '=', 'personal.idpersonal')
            ->leftjoin('persona', 'personal.idpersona', '=', 'persona.codPersona')
            ->leftjoin('subtramite', 'pago.idsubtramite', '=', 'subtramite.codsubtramite')
            ->leftjoin('tramite', 'tramite.codtramite', '=', 'subtramite.idtramite')
            ->leftjoin('persona as p', 'pago.idpersona', '=', 'p.codPersona')
            ->leftjoin('alumno', 'persona.codPersona', '=', 'alumno.idpersona')
            ->leftjoin('escuela', 'alumno.coescuela', '=', 'escuela.idescuela')
            ->leftjoin('facultad', 'escuela.codigofacultad', '=', 'facultad.idfacultad')
            ->leftjoin('sede', 'facultad.cosede', '=', 'sede.codsede')
            ->where([
                ['pago.estado', $estado],
                ['pago.fecha', '>', $fechaDesde],
                ['pago.fecha', '<', $fechaHasta],
                [$local, '=', $valloc],
                [$tram, '=', $valtra]
            ])->paginate(30);
        return $pago;
    }

    public function listarLoc($estado, $fechaDesde, $fechaHasta, $local, $valloc)
    {
        $pago = DB::table('pago')->select(['pago.codpago as codigopago', 'pago.modalidad as modalidad', 'sede.nombresede as nombresede', 'facultad.nombre as nombrefacultad',
            'escuela.nombre as nombreescuela', 'pago.fecha as fechapago', 'tramite.nombre as nombretramite', 'tramite.clasificador as clasi', 'tramite.fuentefinanc as fuentefinanc',
            'tramite.tiporecurso as tiporecurso', 'subtramite.nombre as nombresubtramite', 'subtramite.precio as precio', 'pago.detalle as pagodetalle'])
            ->leftjoin('personal', 'pago.copersonal', '=', 'personal.idpersonal')
            ->leftjoin('persona', 'personal.idpersona', '=', 'persona.codPersona')
            ->leftjoin('subtramite', 'pago.idsubtramite', '=', 'subtramite.codsubtramite')
            ->leftjoin('tramite', 'tramite.codtramite', '=', 'subtramite.idtramite')
            ->leftjoin('persona as p', 'pago.idpersona', '=', 'p.codPersona')
            ->leftjoin('alumno', 'persona.codPersona', '=', 'alumno.idpersona')
            ->leftjoin('escuela', 'alumno.coescuela', '=', 'escuela.idescuela')
            ->leftjoin('facultad', 'escuela.codigofacultad', '=', 'facultad.idfacultad')
            ->leftjoin('sede', 'facultad.cosede', '=', 'sede.codsede')
            ->where([
                ['pago.estado', $estado],
                ['pago.fecha', '>', $fechaDesde],
                ['pago.fecha', '<', $fechaHasta],
                [$local, '=', $valloc]
            ])->paginate(30);
        return $pago;
    }

    public function listarMoTraFu($estado, $fechaDesde, $fechaHasta, $modalidad, $tram, $valtra, $fuen)
    {
        $pago = DB::table('pago')->select(['pago.codpago as codigopago', 'pago.modalidad as modalidad', 'sede.nombresede as nombresede', 'facultad.nombre as nombrefacultad',
            'escuela.nombre as nombreescuela', 'pago.fecha as fechapago', 'tramite.nombre as nombretramite', 'tramite.clasificador as clasi', 'tramite.fuentefinanc as fuentefinanc',
            'tramite.tiporecurso as tiporecurso', 'subtramite.nombre as nombresubtramite', 'subtramite.precio as precio', 'pago.detalle as pagodetalle'])
            ->leftjoin('personal', 'pago.copersonal', '=', 'personal.idpersonal')
            ->leftjoin('persona', 'personal.idpersona', '=', 'persona.codPersona')
            ->leftjoin('subtramite', 'pago.idsubtramite', '=', 'subtramite.codsubtramite')
            ->leftjoin('tramite', 'tramite.codtramite', '=', 'subtramite.idtramite')
            ->leftjoin('persona as p', 'pago.idpersona', '=', 'p.codPersona')
            ->leftjoin('alumno', 'persona.codPersona', '=', 'alumno.idpersona')
            ->leftjoin('escuela', 'alumno.coescuela', '=', 'escuela.idescuela')
            ->leftjoin('facultad', 'escuela.codigofacultad', '=', 'facultad.idfacultad')
            ->leftjoin('sede', 'facultad.cosede', '=', 'sede.codsede')
            ->where([
                ['pago.estado', $estado],
                ['pago.fecha', '>', $fechaDesde],
                ['pago.fecha', '<', $fechaHasta],
                ['tramite.fuentefinanc', '=', $fuen],
                ['pago.modalidad', '=', $modalidad],
                [$tram, '=', $valtra]
            ])->paginate(30);
        return $pago;
    }

    public function listarTraFu($estado, $fechaDesde, $fechaHasta, $tram, $valtra, $fuen)
    {
        $pago = DB::table('pago')->select(['pago.codpago as codigopago', 'pago.modalidad as modalidad', 'sede.nombresede as nombresede', 'facultad.nombre as nombrefacultad',
            'escuela.nombre as nombreescuela', 'pago.fecha as fechapago', 'tramite.nombre as nombretramite', 'tramite.clasificador as clasi', 'tramite.fuentefinanc as fuentefinanc',
            'tramite.tiporecurso as tiporecurso', 'subtramite.nombre as nombresubtramite', 'subtramite.precio as precio', 'pago.detalle as pagodetalle'])
            ->leftjoin('personal', 'pago.copersonal', '=', 'personal.idpersonal')
            ->leftjoin('persona', 'personal.idpersona', '=', 'persona.codPersona')
            ->leftjoin('subtramite', 'pago.idsubtramite', '=', 'subtramite.codsubtramite')
            ->leftjoin('tramite', 'tramite.codtramite', '=', 'subtramite.idtramite')
            ->leftjoin('persona as p', 'pago.idpersona', '=', 'p.codPersona')
            ->leftjoin('alumno', 'persona.codPersona', '=', 'alumno.idpersona')
            ->leftjoin('escuela', 'alumno.coescuela', '=', 'escuela.idescuela')
            ->leftjoin('facultad', 'escuela.codigofacultad', '=', 'facultad.idfacultad')
            ->leftjoin('sede', 'facultad.cosede', '=', 'sede.codsede')
            ->where([
                ['pago.estado', $estado],
                ['pago.fecha', '>', $fechaDesde],
                ['pago.fecha', '<', $fechaHasta],
                ['tramite.fuentefinanc', '=', $fuen],
                [$tram, '=', $valtra]
            ])->paginate(30);
        return $pago;
    }

    public function listarMoFu($estado, $fechaDesde, $fechaHasta, $modalidad, $fuen)
    {
        $pago = DB::table('pago')->select(['pago.codpago as codigopago', 'pago.modalidad as modalidad', 'sede.nombresede as nombresede', 'facultad.nombre as nombrefacultad',
            'escuela.nombre as nombreescuela', 'pago.fecha as fechapago', 'tramite.nombre as nombretramite', 'tramite.clasificador as clasi', 'tramite.fuentefinanc as fuentefinanc',
            'tramite.tiporecurso as tiporecurso', 'subtramite.nombre as nombresubtramite', 'subtramite.precio as precio', 'pago.detalle as pagodetalle'])
            ->leftjoin('personal', 'pago.copersonal', '=', 'personal.idpersonal')
            ->leftjoin('persona', 'personal.idpersona', '=', 'persona.codPersona')
            ->leftjoin('subtramite', 'pago.idsubtramite', '=', 'subtramite.codsubtramite')
            ->leftjoin('tramite', 'tramite.codtramite', '=', 'subtramite.idtramite')
            ->leftjoin('persona as p', 'pago.idpersona', '=', 'p.codPersona')
            ->leftjoin('alumno', 'persona.codPersona', '=', 'alumno.idpersona')
            ->leftjoin('escuela', 'alumno.coescuela', '=', 'escuela.idescuela')
            ->leftjoin('facultad', 'escuela.codigofacultad', '=', 'facultad.idfacultad')
            ->leftjoin('sede', 'facultad.cosede', '=', 'sede.codsede')
            ->where([
                ['pago.estado', $estado],
                ['pago.fecha', '>', $fechaDesde],
                ['pago.fecha', '<', $fechaHasta],
                ['tramite.fuentefinanc', '=', $fuen],
                ['pago.modalidad', '=', $modalidad]
            ])->paginate(30);
        return $pago;
    }

    public function listarFu($estado, $fechaDesde, $fechaHasta, $fuen)
    {
        $pago = DB::table('pago')->select(['pago.codpago as codigopago', 'pago.modalidad as modalidad', 'sede.nombresede as nombresede', 'facultad.nombre as nombrefacultad',
            'escuela.nombre as nombreescuela', 'pago.fecha as fechapago', 'tramite.nombre as nombretramite', 'tramite.clasificador as clasi', 'tramite.fuentefinanc as fuentefinanc',
            'tramite.tiporecurso as tiporecurso', 'subtramite.nombre as nombresubtramite', 'subtramite.precio as precio', 'pago.detalle as pagodetalle'])
            ->leftjoin('personal', 'pago.copersonal', '=', 'personal.idpersonal')
            ->leftjoin('persona', 'personal.idpersona', '=', 'persona.codPersona')
            ->leftjoin('subtramite', 'pago.idsubtramite', '=', 'subtramite.codsubtramite')
            ->leftjoin('tramite', 'tramite.codtramite', '=', 'subtramite.idtramite')
            ->leftjoin('persona as p', 'pago.idpersona', '=', 'p.codPersona')
            ->leftjoin('alumno', 'persona.codPersona', '=', 'alumno.idpersona')
            ->leftjoin('escuela', 'alumno.coescuela', '=', 'escuela.idescuela')
            ->leftjoin('facultad', 'escuela.codigofacultad', '=', 'facultad.idfacultad')
            ->leftjoin('sede', 'facultad.cosede', '=', 'sede.codsede')
            ->where([
                ['pago.estado', $estado],
                ['pago.fecha', '>', $fechaDesde],
                ['pago.fecha', '<', $fechaHasta],
                ['tramite.fuentefinanc', '=', $fuen]
            ])->paginate(30);
        return $pago;
    }

    public function listarMoTraTiLo($estado, $fechaDesde, $fechaHasta, $tipore, $modalidad, $tram, $valtra, $local, $valloc)
    {
        $pago = DB::table('pago')->select(['pago.codpago as codigopago', 'pago.modalidad as modalidad', 'sede.nombresede as nombresede', 'facultad.nombre as nombrefacultad',
            'escuela.nombre as nombreescuela', 'pago.fecha as fechapago', 'tramite.nombre as nombretramite', 'tramite.clasificador as clasi', 'tramite.fuentefinanc as fuentefinanc',
            'tramite.tiporecurso as tiporecurso', 'subtramite.nombre as nombresubtramite', 'subtramite.precio as precio', 'pago.detalle as pagodetalle'])
            ->leftjoin('personal', 'pago.copersonal', '=', 'personal.idpersonal')
            ->leftjoin('persona', 'personal.idpersona', '=', 'persona.codPersona')
            ->leftjoin('subtramite', 'pago.idsubtramite', '=', 'subtramite.codsubtramite')
            ->leftjoin('tramite', 'tramite.codtramite', '=', 'subtramite.idtramite')
            ->leftjoin('persona as p', 'pago.idpersona', '=', 'p.codPersona')
            ->leftjoin('alumno', 'persona.codPersona', '=', 'alumno.idpersona')
            ->leftjoin('escuela', 'alumno.coescuela', '=', 'escuela.idescuela')
            ->leftjoin('facultad', 'escuela.codigofacultad', '=', 'facultad.idfacultad')
            ->leftjoin('sede', 'facultad.cosede', '=', 'sede.codsede')
            ->where([
                ['pago.estado', $estado],
                ['pago.fecha', '>', $fechaDesde],
                ['pago.fecha', '<', $fechaHasta],
                ['tramite.tipoRecurso', '=', $tipore],
                ['pago.modalidad', '=', $modalidad],
                [$tram, '=', $valtra],
                [$local, '=', $valloc]
            ])->paginate(30);
        return $pago;
    }

    public function listarMoTraFuTi($estado, $fechaDesde, $fechaHasta, $tipore, $modalidad, $fuefi, $tram, $valtra)
    {
        $pago = DB::table('pago')->select(['pago.codpago as codigopago', 'pago.modalidad as modalidad', 'sede.nombresede as nombresede', 'facultad.nombre as nombrefacultad',
            'escuela.nombre as nombreescuela', 'pago.fecha as fechapago', 'tramite.nombre as nombretramite', 'tramite.clasificador as clasi', 'tramite.fuentefinanc as fuentefinanc',
            'tramite.tiporecurso as tiporecurso', 'subtramite.nombre as nombresubtramite', 'subtramite.precio as precio', 'pago.detalle as pagodetalle'])
            ->leftjoin('personal', 'pago.copersonal', '=', 'personal.idpersonal')
            ->leftjoin('persona', 'personal.idpersona', '=', 'persona.codPersona')
            ->leftjoin('subtramite', 'pago.idsubtramite', '=', 'subtramite.codsubtramite')
            ->leftjoin('tramite', 'tramite.codtramite', '=', 'subtramite.idtramite')
            ->leftjoin('persona as p', 'pago.idpersona', '=', 'p.codPersona')
            ->leftjoin('alumno', 'persona.codPersona', '=', 'alumno.idpersona')
            ->leftjoin('escuela', 'alumno.coescuela', '=', 'escuela.idescuela')
            ->leftjoin('facultad', 'escuela.codigofacultad', '=', 'facultad.idfacultad')
            ->leftjoin('sede', 'facultad.cosede', '=', 'sede.codsede')
            ->where([
                ['pago.estado', $estado],
                ['pago.fecha', '>', $fechaDesde],
                ['pago.fecha', '<', $fechaHasta],
                ['tramite.tipoRecurso', '=', $tipore],
                ['pago.modalidad', '=', $modalidad],
                ['tramite.fuentefinanc', '=', $fuefi],
                [$tram, '=', $valtra]
            ])->paginate(30);
        return $pago;
    }

    public function listarMoFueTipFu($estado, $fechaDesde, $fechaHasta, $tipore, $modalidad, $fuefi)
    {
        $pago = DB::table('pago')->select(['pago.codpago as codigopago', 'pago.modalidad as modalidad', 'sede.nombresede as nombresede', 'facultad.nombre as nombrefacultad',
            'escuela.nombre as nombreescuela', 'pago.fecha as fechapago', 'tramite.nombre as nombretramite', 'tramite.clasificador as clasi', 'tramite.fuentefinanc as fuentefinanc',
            'tramite.tiporecurso as tiporecurso', 'subtramite.nombre as nombresubtramite', 'subtramite.precio as precio', 'pago.detalle as pagodetalle'])
            ->leftjoin('personal', 'pago.copersonal', '=', 'personal.idpersonal')
            ->leftjoin('persona', 'personal.idpersona', '=', 'persona.codPersona')
            ->leftjoin('subtramite', 'pago.idsubtramite', '=', 'subtramite.codsubtramite')
            ->leftjoin('tramite', 'tramite.codtramite', '=', 'subtramite.idtramite')
            ->leftjoin('persona as p', 'pago.idpersona', '=', 'p.codPersona')
            ->leftjoin('alumno', 'persona.codPersona', '=', 'alumno.idpersona')
            ->leftjoin('escuela', 'alumno.coescuela', '=', 'escuela.idescuela')
            ->leftjoin('facultad', 'escuela.codigofacultad', '=', 'facultad.idfacultad')
            ->leftjoin('sede', 'facultad.cosede', '=', 'sede.codsede')
            ->where([
                ['pago.estado', $estado],
                ['pago.fecha', '>=', $fechaDesde],
                ['pago.fecha', '<=', $fechaHasta],
                ['tramite.tipoRecurso', '=', $tipore],
                ['pago.modalidad', '=', $modalidad],
                ['tramite.fuentefinanc', '=', $fuefi]
            ])->paginate(30);
        return $pago;
    }

    public function listarTip($estado, $fechaDesde, $fechaHasta, $tipore, $modalidad, $tram, $valTram)
    {
        $pago = DB::table('pago')->select(['pago.codpago as codigopago', 'pago.modalidad as modalidad', 'sede.nombresede as nombresede', 'facultad.nombre as nombrefacultad',
            'escuela.nombre as nombreescuela', 'pago.fecha as fechapago', 'tramite.nombre as nombretramite', 'tramite.clasificador as clasi', 'tramite.fuentefinanc as fuentefinanc',
            'tramite.tiporecurso as tiporecurso', 'subtramite.nombre as nombresubtramite', 'subtramite.precio as precio', 'pago.detalle as pagodetalle'])
            ->leftjoin('personal', 'pago.copersonal', '=', 'personal.idpersonal')
            ->leftjoin('persona', 'personal.idpersona', '=', 'persona.codPersona')
            ->leftjoin('subtramite', 'pago.idsubtramite', '=', 'subtramite.codsubtramite')
            ->leftjoin('tramite', 'tramite.codtramite', '=', 'subtramite.idtramite')
            ->leftjoin('persona as p', 'pago.idpersona', '=', 'p.codPersona')
            ->leftjoin('alumno', 'persona.codPersona', '=', 'alumno.idpersona')
            ->leftjoin('escuela', 'alumno.coescuela', '=', 'escuela.idescuela')
            ->leftjoin('facultad', 'escuela.codigofacultad', '=', 'facultad.idfacultad')
            ->leftjoin('sede', 'facultad.cosede', '=', 'sede.codsede')
            ->where([
                ['pago.estado', $estado],
                ['pago.fecha', '>=', $fechaDesde],
                ['pago.fecha', '<=', $fechaHasta],
                ['tramite.tipoRecurso', '=', $tipore],
                ['pago.modalidad', '=', $modalidad],
                [$tram, '=', $valTram]
            ])->paginate(30);
        return $pago;
    }

    public function listarTipLo($estado, $fechaDesde, $fechaHasta, $tipore, $local, $valloc)
    {
        $pago = DB::table('pago')->select(['pago.codpago as codigopago', 'pago.modalidad as modalidad', 'sede.nombresede as nombresede', 'facultad.nombre as nombrefacultad',
            'escuela.nombre as nombreescuela', 'pago.fecha as fechapago', 'tramite.nombre as nombretramite', 'tramite.clasificador as clasi', 'tramite.fuentefinanc as fuentefinanc',
            'tramite.tiporecurso as tiporecurso', 'subtramite.nombre as nombresubtramite', 'subtramite.precio as precio', 'pago.detalle as pagodetalle'])
            ->leftjoin('personal', 'pago.copersonal', '=', 'personal.idpersonal')
            ->leftjoin('persona', 'personal.idpersona', '=', 'persona.codPersona')
            ->leftjoin('subtramite', 'pago.idsubtramite', '=', 'subtramite.codsubtramite')
            ->leftjoin('tramite', 'tramite.codtramite', '=', 'subtramite.idtramite')
            ->leftjoin('persona as p', 'pago.idpersona', '=', 'p.codPersona')
            ->leftjoin('alumno', 'persona.codPersona', '=', 'alumno.idpersona')
            ->leftjoin('escuela', 'alumno.coescuela', '=', 'escuela.idescuela')
            ->leftjoin('facultad', 'escuela.codigofacultad', '=', 'facultad.idfacultad')
            ->leftjoin('sede', 'facultad.cosede', '=', 'sede.codsede')
            ->where([
                ['pago.estado', $estado],
                ['pago.fecha', '>=', $fechaDesde],
                ['pago.fecha', '<=', $fechaHasta],
                ['tramite.tipoRecurso', '=', $tipore],
                [$local, '=', $valloc]
            ])->paginate(30);
        return $pago;
    }

    public function listarFueTip($estado, $fechaDesde, $fechaHasta, $tipRe, $fuefi)
    {
        $pago = DB::table('pago')->select(['pago.codpago as codigopago', 'pago.modalidad as modalidad', 'sede.nombresede as nombresede', 'facultad.nombre as nombrefacultad',
            'escuela.nombre as nombreescuela', 'pago.fecha as fechapago', 'tramite.nombre as nombretramite', 'tramite.clasificador as clasi', 'tramite.fuentefinanc as fuentefinanc',
            'tramite.tiporecurso as tiporecurso', 'subtramite.nombre as nombresubtramite', 'subtramite.precio as precio', 'pago.detalle as pagodetalle'])
            ->leftjoin('personal', 'pago.copersonal', '=', 'personal.idpersonal')
            ->leftjoin('persona', 'personal.idpersona', '=', 'persona.codPersona')
            ->leftjoin('subtramite', 'pago.idsubtramite', '=', 'subtramite.codsubtramite')
            ->leftjoin('tramite', 'tramite.codtramite', '=', 'subtramite.idtramite')
            ->leftjoin('persona as p', 'pago.idpersona', '=', 'p.codPersona')
            ->leftjoin('alumno', 'persona.codPersona', '=', 'alumno.idpersona')
            ->leftjoin('escuela', 'alumno.coescuela', '=', 'escuela.idescuela')
            ->leftjoin('facultad', 'escuela.codigofacultad', '=', 'facultad.idfacultad')
            ->leftjoin('sede', 'facultad.cosede', '=', 'sede.codsede')
            ->where([
                ['pago.estado', $estado],
                ['pago.fecha', '>=', $fechaDesde],
                ['pago.fecha', '<=', $fechaHasta],
                ['tramite.tipoRecurso', '=', $tipRe],
                ['tramite.fuentefinanc', '=', $fuefi]
            ])->paginate(30);
        return $pago;
    }

    public function listarTraTip($estado, $fechaDesde, $fechaHasta, $tram, $valtra, $tipRe)
    {
        $pago = DB::table('pago')->select(['pago.codpago as codigopago', 'pago.modalidad as modalidad', 'sede.nombresede as nombresede', 'facultad.nombre as nombrefacultad',
            'escuela.nombre as nombreescuela', 'pago.fecha as fechapago', 'tramite.nombre as nombretramite', 'tramite.clasificador as clasi', 'tramite.fuentefinanc as fuentefinanc',
            'tramite.tiporecurso as tiporecurso', 'subtramite.nombre as nombresubtramite', 'subtramite.precio as precio', 'pago.detalle as pagodetalle'])
            ->leftjoin('personal', 'pago.copersonal', '=', 'personal.idpersonal')
            ->leftjoin('persona', 'personal.idpersona', '=', 'persona.codPersona')
            ->leftjoin('subtramite', 'pago.idsubtramite', '=', 'subtramite.codsubtramite')
            ->leftjoin('tramite', 'tramite.codtramite', '=', 'subtramite.idtramite')
            ->leftjoin('persona as p', 'pago.idpersona', '=', 'p.codPersona')
            ->leftjoin('alumno', 'persona.codPersona', '=', 'alumno.idpersona')
            ->leftjoin('escuela', 'alumno.coescuela', '=', 'escuela.idescuela')
            ->leftjoin('facultad', 'escuela.codigofacultad', '=', 'facultad.idfacultad')
            ->leftjoin('sede', 'facultad.cosede', '=', 'sede.codsede')
            ->where([
                ['pago.estado', $estado],
                ['pago.fecha', '>=', $fechaDesde],
                ['pago.fecha', '<=', $fechaHasta],
                ['tramite.tipoRecurso', '=', $tipRe],
                [$tram, '=', $valtra],
            ])->paginate(30);
        return $pago;
    }

    public function listarTipoRe($estado, $fechaDesde, $fechaHasta, $tipRe)
    {
        $pago = DB::table('pago')->select(['pago.codpago as codigopago', 'pago.modalidad as modalidad', 'sede.nombresede as nombresede', 'facultad.nombre as nombrefacultad',
            'escuela.nombre as nombreescuela', 'pago.fecha as fechapago', 'tramite.nombre as nombretramite', 'tramite.clasificador as clasi', 'tramite.fuentefinanc as fuentefinanc',
            'tramite.tiporecurso as tiporecurso', 'subtramite.nombre as nombresubtramite', 'subtramite.precio as precio', 'pago.detalle as pagodetalle'])
            ->leftjoin('personal', 'pago.copersonal', '=', 'personal.idpersonal')
            ->leftjoin('persona', 'personal.idpersona', '=', 'persona.codPersona')
            ->leftjoin('subtramite', 'pago.idsubtramite', '=', 'subtramite.codsubtramite')
            ->leftjoin('tramite', 'tramite.codtramite', '=', 'subtramite.idtramite')
            ->leftjoin('persona as p', 'pago.idpersona', '=', 'p.codPersona')
            ->leftjoin('alumno', 'persona.codPersona', '=', 'alumno.idpersona')
            ->leftjoin('escuela', 'alumno.coescuela', '=', 'escuela.idescuela')
            ->leftjoin('facultad', 'escuela.codigofacultad', '=', 'facultad.idfacultad')
            ->leftjoin('sede', 'facultad.cosede', '=', 'sede.codsede')
            ->where([
                ['pago.estado', $estado],
                ['pago.fecha', '>=', $fechaDesde],
                ['pago.fecha', '<=', $fechaHasta],
                ['tramite.tipoRecurso', '=', $tipRe],

            ])->paginate(30);
        return $pago;
    }

    public function listarMoTrFuLo($estado, $fechaDesde, $fechaHasta, $tram, $valtra, $fuefi, $local, $valLoc)
    {
        $pago = DB::table('pago')->select(['pago.codpago as codigopago', 'pago.modalidad as modalidad', 'sede.nombresede as nombresede', 'facultad.nombre as nombrefacultad',
            'escuela.nombre as nombreescuela', 'pago.fecha as fechapago', 'tramite.nombre as nombretramite', 'tramite.clasificador as clasi', 'tramite.fuentefinanc as fuentefinanc',
            'tramite.tiporecurso as tiporecurso', 'subtramite.nombre as nombresubtramite', 'subtramite.precio as precio', 'pago.detalle as pagodetalle'])
            ->leftjoin('personal', 'pago.copersonal', '=', 'personal.idpersonal')
            ->leftjoin('persona', 'personal.idpersona', '=', 'persona.codPersona')
            ->leftjoin('subtramite', 'pago.idsubtramite', '=', 'subtramite.codsubtramite')
            ->leftjoin('tramite', 'tramite.codtramite', '=', 'subtramite.idtramite')
            ->leftjoin('persona as p', 'pago.idpersona', '=', 'p.codPersona')
            ->leftjoin('alumno', 'persona.codPersona', '=', 'alumno.idpersona')
            ->leftjoin('escuela', 'alumno.coescuela', '=', 'escuela.idescuela')
            ->leftjoin('facultad', 'escuela.codigofacultad', '=', 'facultad.idfacultad')
            ->leftjoin('sede', 'facultad.cosede', '=', 'sede.codsede')
            ->where([
                ['pago.estado', $estado],
                ['pago.fecha', '>=', $fechaDesde],
                ['pago.fecha', '<=', $fechaHasta],
                ['tramite.fuentefinanc', '=', $fuefi],
                [$tram, '=', $valtra],
                [$local, '=', $valLoc]
            ])->paginate(30);
        return $pago;
    }

    public function listarTr($estado, $fechaDesde, $fechaHasta, $tram, $valtra)
    {
        $pago = DB::table('pago')->select(['pago.codpago as codigopago', 'pago.modalidad as modalidad', 'sede.nombresede as nombresede', 'facultad.nombre as nombrefacultad',
            'escuela.nombre as nombreescuela', 'pago.fecha as fechapago', 'tramite.nombre as nombretramite', 'tramite.clasificador as clasi', 'tramite.fuentefinanc as fuentefinanc',
            'tramite.tiporecurso as tiporecurso', 'subtramite.nombre as nombresubtramite', 'subtramite.precio as precio', 'pago.detalle as pagodetalle'])
            ->leftjoin('personal', 'pago.copersonal', '=', 'personal.idpersonal')
            ->leftjoin('persona', 'personal.idpersona', '=', 'persona.codPersona')
            ->leftjoin('subtramite', 'pago.idsubtramite', '=', 'subtramite.codsubtramite')
            ->leftjoin('tramite', 'tramite.codtramite', '=', 'subtramite.idtramite')
            ->leftjoin('persona as p', 'pago.idpersona', '=', 'p.codPersona')
            ->leftjoin('alumno', 'persona.codPersona', '=', 'alumno.idpersona')
            ->leftjoin('escuela', 'alumno.coescuela', '=', 'escuela.idescuela')
            ->leftjoin('facultad', 'escuela.codigofacultad', '=', 'facultad.idfacultad')
            ->leftjoin('sede', 'facultad.cosede', '=', 'sede.codsede')
            ->where([
                ['pago.estado', $estado],
                ['pago.fecha', '>=', $fechaDesde],
                ['pago.fecha', '<=', $fechaHasta],
                [$tram, '=', $valtra]
            ])->paginate(30);
        return $pago;
    }

    public function listarMoFuLo($estado, $modalidad, $fechaDesde, $fechaHasta, $fuefi, $local, $valLoc)
    {
        $pago = DB::table('pago')->select(['pago.codpago as codigopago', 'pago.modalidad as modalidad', 'sede.nombresede as nombresede', 'facultad.nombre as nombrefacultad',
            'escuela.nombre as nombreescuela', 'pago.fecha as fechapago', 'tramite.nombre as nombretramite', 'tramite.clasificador as clasi', 'tramite.fuentefinanc as fuentefinanc',
            'tramite.tiporecurso as tiporecurso', 'subtramite.nombre as nombresubtramite', 'subtramite.precio as precio', 'pago.detalle as pagodetalle'])
            ->leftjoin('personal', 'pago.copersonal', '=', 'personal.idpersonal')
            ->leftjoin('persona', 'personal.idpersona', '=', 'persona.codPersona')
            ->leftjoin('subtramite', 'pago.idsubtramite', '=', 'subtramite.codsubtramite')
            ->leftjoin('tramite', 'tramite.codtramite', '=', 'subtramite.idtramite')
            ->leftjoin('persona as p', 'pago.idpersona', '=', 'p.codPersona')
            ->leftjoin('alumno', 'persona.codPersona', '=', 'alumno.idpersona')
            ->leftjoin('escuela', 'alumno.coescuela', '=', 'escuela.idescuela')
            ->leftjoin('facultad', 'escuela.codigofacultad', '=', 'facultad.idfacultad')
            ->leftjoin('sede', 'facultad.cosede', '=', 'sede.codsede')
            ->where([
                ['pago.estado', $estado],
                ['pago.fecha', '>=', $fechaDesde],
                ['pago.fecha', '<=', $fechaHasta],
                ['pago.modalidad', '=', $modalidad],
                ['tramite.fuentefinanc', '=', $fuefi],
                [$local, '=', $valLoc]
            ])->paginate(30);
        return $pago;
    }

    public function listarMoLo($estado, $modalidad, $fechaDesde, $fechaHasta, $local, $valLoc)
    {
        $pago = DB::table('pago')->select(['pago.codpago as codigopago', 'pago.modalidad as modalidad', 'sede.nombresede as nombresede', 'facultad.nombre as nombrefacultad',
            'escuela.nombre as nombreescuela', 'pago.fecha as fechapago', 'tramite.nombre as nombretramite', 'tramite.clasificador as clasi', 'tramite.fuentefinanc as fuentefinanc',
            'tramite.tiporecurso as tiporecurso', 'subtramite.nombre as nombresubtramite', 'subtramite.precio as precio', 'pago.detalle as pagodetalle'])
            ->leftjoin('personal', 'pago.copersonal', '=', 'personal.idpersonal')
            ->leftjoin('persona', 'personal.idpersona', '=', 'persona.codPersona')
            ->leftjoin('subtramite', 'pago.idsubtramite', '=', 'subtramite.codsubtramite')
            ->leftjoin('tramite', 'tramite.codtramite', '=', 'subtramite.idtramite')
            ->leftjoin('persona as p', 'pago.idpersona', '=', 'p.codPersona')
            ->leftjoin('alumno', 'persona.codPersona', '=', 'alumno.idpersona')
            ->leftjoin('escuela', 'alumno.coescuela', '=', 'escuela.idescuela')
            ->leftjoin('facultad', 'escuela.codigofacultad', '=', 'facultad.idfacultad')
            ->leftjoin('sede', 'facultad.cosede', '=', 'sede.codsede')
            ->where([
                ['pago.estado', $estado],
                ['pago.fecha', '>=', $fechaDesde],
                ['pago.fecha', '<=', $fechaHasta],
                ['pago.modalidad', '=', $modalidad],
                [$local, '=', $valLoc]
            ])->paginate(30);
        return $pago;
    }

    public function listarMoTiFuLo($estado, $modalidad, $fechaDesde, $fechaHasta, $tipRe, $fuenteFin, $local, $valLoc)
    {
        $pago = DB::table('pago')->select(['pago.codpago as codigopago', 'pago.modalidad as modalidad', 'sede.nombresede as nombresede', 'facultad.nombre as nombrefacultad',
            'escuela.nombre as nombreescuela', 'pago.fecha as fechapago', 'tramite.nombre as nombretramite', 'tramite.clasificador as clasi', 'tramite.fuentefinanc as fuentefinanc',
            'tramite.tiporecurso as tiporecurso', 'subtramite.nombre as nombresubtramite', 'subtramite.precio as precio', 'pago.detalle as pagodetalle'])
            ->leftjoin('personal', 'pago.copersonal', '=', 'personal.idpersonal')
            ->leftjoin('persona', 'personal.idpersona', '=', 'persona.codPersona')
            ->leftjoin('subtramite', 'pago.idsubtramite', '=', 'subtramite.codsubtramite')
            ->leftjoin('tramite', 'tramite.codtramite', '=', 'subtramite.idtramite')
            ->leftjoin('persona as p', 'pago.idpersona', '=', 'p.codPersona')
            ->leftjoin('alumno', 'persona.codPersona', '=', 'alumno.idpersona')
            ->leftjoin('escuela', 'alumno.coescuela', '=', 'escuela.idescuela')
            ->leftjoin('facultad', 'escuela.codigofacultad', '=', 'facultad.idfacultad')
            ->leftjoin('sede', 'facultad.cosede', '=', 'sede.codsede')
            ->where([
                ['pago.estado', $estado],
                ['pago.fecha', '>=', $fechaDesde],
                ['pago.fecha', '<=', $fechaHasta],
                ['pago.modalidad', '=', $modalidad],
                ['tramite.tipoRecurso', '=', $tipRe],
                ['tramite.fuentefinanc', '=', $fuenteFin],
                [$local, '=', $valLoc]
            ])->paginate(30);
        return $pago;
    }


    public function listarModTip($estado, $modalidad, $fechaDesde, $fechaHasta, $tipRe)
    {

        $pago = DB::select('SELECT po.codpago as codigopago,po.modalidad as modalidad, ifnull(se.nombresede,\'es cliente\') as nombresede,  ifnull(fac.nombre,\'es cliente\') as nombrefacultad,
                             ifnull(es.nombre,\'es cliente\') as  nombreescuela, po.fecha as fechapago,tr.nombre as nombretramite,tr.clasificador as clasi,tr.fuentefinanc as fuentefinanc,tr.tiporecurso as tiporecurso, st.nombre as nombresubtramite,
                            st.precio as precio,po.detalle as pagodetalle
                            FROM unt.pago as po
                            LEFT JOIN unt.persona per ON (po.idpersona = per.codPersona)
                            LEFT JOIN unt.alumno al ON (per.codPersona = al.idPersona)
                            LEFT JOIN unt.escuela es ON (al.coEscuela=es.idEscuela)
                            LEFT JOIN unt.facultad fac ON(es.codigoFacultad = fac.idFacultad)
                            LEFT JOIN unt.sede sed ON (fac.coSede = sed.codSede)
                            LEFT JOIN unt.personal ps ON (ps.idpersonal=po.copersonal)
                            LEFT JOIN unt.persona pl ON (ps.idpersona=pl.codPersona)
                            LEFT JOIN unt.subtramite st ON (po.idSubtramite =st.codSubtramite)
                            LEFT JOIN unt.tramite tr ON (st.idTramite=tr.codTramite) 
                            Left join unt.sede se ON(se.CodSede=fac.coSede)
                            WHERE po.estado=' . $estado . ' and po.fecha >= \'2000-02-23\' and po.fecha <=\'2017-03-31\' 
                             and tr.tipoRecurso=' . $tipRe . '
                              and po.modalidad = \'' . $modalidad . '\'');

        return $pago;
    }


    public function listarTramModLoc($estado, $modalidad, $tramite, $tramiteVal, $fechaDesde, $fechaHasta, $local, $valLoc)
    {
        $pago = DB::select('SELECT po.codpago as codigopago,po.modalidad as modalidad, ifnull(se.nombresede,\'es cliente\') as nombresede,  ifnull(fac.nombre,\'es cliente\') as nombrefacultad,
                             ifnull(es.nombre,\'es cliente\') as  nombreescuela, po.fecha as fechapago,tr.nombre as nombretramite,tr.clasificador as clasi,tr.fuentefinanc as fuentefinanc,tr.tiporecurso as tiporecurso, st.nombre as nombresubtramite,
                            st.precio as precio,po.detalle as pagodetalle
                            FROM unt.pago as po
                            LEFT JOIN unt.persona per ON (po.idpersona = per.codPersona)
                            LEFT JOIN unt.alumno al ON (per.codPersona = al.idPersona)
                            LEFT JOIN unt.escuela es ON (al.coEscuela=es.idEscuela)
                            LEFT JOIN unt.facultad fac ON(es.codigoFacultad = fac.idFacultad)
                            LEFT JOIN unt.sede sed ON (fac.coSede = sed.codSede)
                            LEFT JOIN unt.personal ps ON (ps.idpersonal=po.copersonal)
                            LEFT JOIN unt.persona pl ON (ps.idpersona=pl.codPersona)
                            LEFT JOIN unt.subtramite st ON (po.idSubtramite =st.codSubtramite)
                            LEFT JOIN unt.tramite tr ON (st.idTramite=tr.codTramite) 
                            Left join unt.sede se ON(se.CodSede=fac.coSede)
                            WHERE po.estado=' . $estado . ' and po.fecha >= \'2000-02-23\' and po.fecha <=\'2017-03-31\' and ' . $tramite . '=' . $tramiteVal . '
                             and ' . $local . '=' . $valLoc . '
                              and po.modalidad = \'' . $modalidad . '\'');

        return $pago;
    }

    public function listarModTram($estado, $modalidad, $tramite, $tramiteVal, $fechaDesde, $fechaHasta)
    {

        $pago= DB::select('SELECT po.codpago as codigopago,po.modalidad as modalidad, ifnull(se.nombresede,\'es cliente\') as nombresede,  ifnull(fac.nombre,\'es cliente\') as nombrefacultad,
                             ifnull(es.nombre,\'es cliente\') as  nombreescuela, po.fecha as fechapago,tr.nombre as nombretramite,tr.clasificador as clasi,tr.fuentefinanc as fuentefinanc,tr.tiporecurso as tiporecurso, st.nombre as nombresubtramite,
                            st.precio as precio,po.detalle as pagodetalle
                            FROM unt.pago as po
                            LEFT JOIN unt.persona per ON (po.idpersona = per.codPersona)
                            LEFT JOIN unt.alumno al ON (per.codPersona = al.idPersona)
                            LEFT JOIN unt.escuela es ON (al.coEscuela=es.idEscuela)
                            LEFT JOIN unt.facultad fac ON(es.codigoFacultad = fac.idFacultad)
                            LEFT JOIN unt.sede sed ON (fac.coSede = sed.codSede)
                            LEFT JOIN unt.personal ps ON (ps.idpersonal=po.copersonal)
                            LEFT JOIN unt.persona pl ON (ps.idpersona=pl.codPersona)
                            LEFT JOIN unt.subtramite st ON (po.idSubtramite =st.codSubtramite)
                            LEFT JOIN unt.tramite tr ON (st.idTramite=tr.codTramite) 
                            Left join unt.sede se ON(se.CodSede=fac.coSede)
                            WHERE po.estado='.$estado.' and po.fecha >= \'2000-02-23\' and po.fecha <=\'2017-03-31\' and '.$tramite.'='.$tramiteVal.'
                              and po.modalidad = \''.$modalidad.'\'' );

        return $pago;

    }

    public function listarPagoModalidad($estado, $modalidad, $fechaDesde, $fechaHasta)
    {
        $pago= DB::select('SELECT po.codpago as codigopago,po.modalidad as modalidad, ifnull(se.nombresede,\'es cliente\') as nombresede,  ifnull(fac.nombre,\'es cliente\') as nombrefacultad,
                             ifnull(es.nombre,\'es cliente\') as  nombreescuela, po.fecha as fechapago,tr.nombre as nombretramite,tr.clasificador as clasi,tr.fuentefinanc as fuentefinanc,tr.tiporecurso as tiporecurso, st.nombre as nombresubtramite,
                            st.precio as precio,po.detalle as pagodetalle
                            FROM unt.pago as po
                            LEFT JOIN unt.persona per ON (po.idpersona = per.codPersona)
                            LEFT JOIN unt.alumno al ON (per.codPersona = al.idPersona)
                            LEFT JOIN unt.escuela es ON (al.coEscuela=es.idEscuela)
                            LEFT JOIN unt.facultad fac ON(es.codigoFacultad = fac.idFacultad)
                            LEFT JOIN unt.sede sed ON (fac.coSede = sed.codSede)
                            LEFT JOIN unt.personal ps ON (ps.idpersonal=po.copersonal)
                            LEFT JOIN unt.persona pl ON (ps.idpersona=pl.codPersona)
                            LEFT JOIN unt.subtramite st ON (po.idSubtramite =st.codSubtramite)
                            LEFT JOIN unt.tramite tr ON (st.idTramite=tr.codTramite) 
                            Left join unt.sede se ON(se.CodSede=fac.coSede)
                            WHERE po.estado='.$estado.' and po.fecha >= \'2000-02-23\' and po.fecha <=\'2017-03-31\' and po.modalidad = \''.$modalidad.'\'' );
        return $pago;
    }

    public function listarPagoNada($estado, $fechaDesde, $fechaHasta)
    {
        $pago= DB::select('SELECT po.codpago as codigopago,po.modalidad as modalidad, ifnull(se.nombresede,\'es cliente\') as nombresede,  ifnull(fac.nombre,\'es cliente\') as nombrefacultad,
                            ifnull(es.nombre,\'es cliente\') as  nombreescuela, po.fecha as fechapago,tr.nombre as nombretramite,tr.clasificador as clasi,tr.fuentefinanc as fuentefinanc,tr.tiporecurso as tiporecurso, st.nombre as nombresubtramite,
                            st.precio as precio,po.detalle as pagodetalle
                            FROM unt.pago as po
                            LEFT JOIN unt.persona per ON (po.idpersona = per.codPersona)
                            LEFT JOIN unt.alumno al ON (per.codPersona = al.idPersona)
                            LEFT JOIN unt.escuela es ON (al.coEscuela=es.idEscuela)
                            LEFT JOIN unt.facultad fac ON(es.codigoFacultad = fac.idFacultad)
                            LEFT JOIN unt.sede sed ON (fac.coSede = sed.codSede)
                            LEFT JOIN unt.personal ps ON (ps.idpersonal=po.copersonal)
                            LEFT JOIN unt.persona pl ON (ps.idpersona=pl.codPersona)
                            LEFT JOIN unt.subtramite st ON (po.idSubtramite =st.codSubtramite)
                            LEFT JOIN unt.tramite tr ON (st.idTramite=tr.codTramite) 
                            Left join unt.sede se ON(se.CodSede=fac.coSede)
                            WHERE po.estado='.$estado.' and po.fecha >= \'2000-02-23\' and po.fecha <=\'2017-03-31\'  ');
        return $pago;
    }


}
