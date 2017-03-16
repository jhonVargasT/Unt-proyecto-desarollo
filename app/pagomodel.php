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

    public function savePago()
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
                DB::transaction(function () use ($logunt) {
                    if ($this->deuda == 0) {
                        DB::table('pago')->insert(['detalle' => $this->detalle, 'fecha' => $this->fecha, 'modalidad' => $this->modalidad, 'idPersona' => $this->idPersona, 'idSubtramite' => $this->idSubtramite, 'coPersonal' => $this->coPersonal]);
                    } elseif ($this->deuda != 0) {
                        DB::table('pago')->insert(['detalle' => $this->detalle, 'fecha' => $this->fecha, 'modalidad' => $this->modalidad, 'idPersona' => $this->idPersona, 'idSubtramite' => $this->idSubtramite, 'coPersonal' => $this->coPersonal, 'deuda' => $this->deuda]);
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

    public function consultarAlumnoDNI($dni, $val, $op)
    {
        $alumnobd = DB::select('SELECT pago.codPago, p1.dni AS p1dni, p1.nombres AS p1nombres, p1.apellidos AS p1apellidos, subtramite.nombre, pago.fecha AS pfecha, subtramite.precio, pago.modalidad, detalle, deuda,
        p2.nombres AS pnombres, p2.apellidos AS papellidos FROM pago
        LEFT JOIN subtramite ON pago.idSubtramite = subtramite.codSubtramite
        LEFT JOIN personal ON pago.coPersonal = personal.idPersonal
        LEFT JOIN persona AS p1 ON p1.codPersona = pago.idPersona
        LEFT JOIN persona AS p2 ON p2.codPersona = personal.idPersona
        WHERE pago.idSubtramite = subtramite.codSubtramite AND pago.coPersonal = personal.idPersonal 
        AND p1.codPersona = pago.idPersona AND p2.codPersona = personal.idPersona AND pago.estado = 1 
        and pago.deuda ' . $op . ' ' . $val . '
        AND p1.dni = ' . $dni . ' order by pago.codPago desc ');
        return $alumnobd;
    }

    public function consultarAlumnoCodigo($codAlumno, $val, $op)
    {
        $alumnobd = DB::select('select pago.codPago, p1.dni as p1dni, p1.nombres as p1nombres, p1.apellidos as p1apellidos,subtramite.nombre, pago.fecha as pfecha ,subtramite.precio, pago.modalidad, p2.nombres as pnombres, p2.apellidos as papellidos, detalle, deuda from pago
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
        and pago.deuda ' . $op . ' ' . $val . '
        and pago.estado=1 and alumno.codAlumno = ' . $codAlumno . ' order by pago.codPago desc ');

        return $alumnobd;
    }

    public function consultarClienteRuc($ruc, $val, $op)
    {
        $clientebd = DB::select('select pago.codPago, p1.dni as p1dni, p1.nombres as p1nombres, p1.apellidos as p1apellidos,subtramite.nombre, pago.fecha as pfecha ,subtramite.precio, pago.modalidad, p2.nombres as pnombres, p2.apellidos as papellidos, detalle, deuda from pago
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
        and pago.deuda ' . $op . ' ' . $val . '
        and pago.estado=1  and cliente.ruc = ' . $ruc . ' order by pago.codPago desc ');
        return $clientebd;
    }

    public function consultarCodigoPago($codPago, $val, $op)
    {
        $pagobd = DB::select('select pago.codPago, p1.dni as p1dni, p1.nombres as p1nombres, p1.apellidos as p1apellidos,subtramite.nombre, pago.fecha as pfecha ,subtramite.precio, pago.modalidad, p2.nombres as pnombres, p2.apellidos as papellidos, detalle, deuda from pago
        left join subtramite on pago.idSubtramite = subtramite.codSubtramite
        left join personal on pago.coPersonal = personal.idPersonal
        left join persona as p1 on p1.codPersona = pago.idPersona
        left join persona as p2 on p2.codPersona = personal.idPersona
        where pago.idSubtramite = subtramite.codSubtramite
        and pago.coPersonal = personal.idPersonal
        and p1.codPersona = pago.idPersona
        and p2.codPersona = personal.idPersona
        and pago.estado=1 and pago.deuda ' . $op . ' ' . $val . ' and pago.codPago = ' . $codPago . ' order by pago.codPago desc');

        return $pagobd;
    }

    public function consultarCodigoPagoReporte($codPago, $val, $op)
    {
        $pagobd = DB::select('select pago.codPago, p1.dni as p1dni, p1.nombres as p1nombres, p1.apellidos as p1apellidos,subtramite.nombre, pago.fecha as pfecha ,subtramite.precio, pago.modalidad, p2.nombres as pnombres, p2.apellidos as papellidos, detalle, deuda from pago
        left join subtramite on pago.idSubtramite = subtramite.codSubtramite
        left join personal on pago.coPersonal = personal.idPersonal
        left join persona as p1 on p1.codPersona = pago.idPersona
        left join persona as p2 on p2.codPersona = personal.idPersona
        where pago.idSubtramite = subtramite.codSubtramite
        and pago.coPersonal = personal.idPersonal
        and p1.codPersona = pago.idPersona
        and p2.codPersona = personal.idPersona
        and pago.estado=1 and subtramite.estado=1 and p1.estado =1 and pago.deuda ' . $op . ' ' . $val . ' and p2.estado=1 and pago.codPago = ' . $codPago . ' order by pago.codPago desc');

        return $pagobd;
    }

    public function consultarCodigoPersonal($codPersonal)
    {
        date_default_timezone_set('America/Lima');
        $dato = date('Y-m-d');

        $pagobd = DB::select('select pago.codPago, p1.dni as p1dni, p1.nombres as p1nombres, p1.apellidos as p1apellidos,subtramite.nombre, pago.fecha as pfecha ,subtramite.precio, pago.modalidad, p2.nombres as pnombres, p2.apellidos as papellidos, detalle from pago
        left join subtramite on pago.idSubtramite = subtramite.codSubtramite
        left join personal on pago.coPersonal = personal.idPersonal
        left join persona as p1 on p1.codPersona = pago.idPersona
        left join persona as p2 on p2.codPersona = personal.idPersona
        where pago.idSubtramite = subtramite.codSubtramite
        and pago.coPersonal = personal.idPersonal
        and p1.codPersona = pago.idPersona
        and p2.codPersona = personal.idPersona
        and pago.estado=1 and subtramite.estado=1 and p1.estado =1 and p2.estado=1 and personal.codPersonal = ' . $codPersonal . ' and pago.fecha like "%' . $dato . '%" order by pago.fecha desc');

        return $pagobd;
    }

    public function consultarPagos($val, $op)
    {
        $alumnobd = DB::select(' SELECT pago.codPago, p1.dni AS p1dni,p1.nombres AS p1nombres, p1.apellidos AS p1apellidos,subtramite.nombre, pago.fecha AS pfecha, subtramite.precio, pago.modalidad, detalle, p2.nombres AS pnombres,p2.apellidos AS papellidos, deuda FROM pago 
        LEFT JOIN subtramite ON pago.idSubtramite = subtramite.codSubtramite
        LEFT JOIN personal ON pago.coPersonal = personal.idPersonal
        LEFT JOIN persona AS p1 ON p1.codPersona = pago.idPersona
        LEFT JOIN persona AS p2 ON p2.codPersona = personal.idPersona
        WHERE pago.idSubtramite = subtramite.codSubtramite AND pago.coPersonal = personal.idPersonal 
        AND p1.codPersona = pago.idPersona and pago.deuda ' . $op . ' ' . $val . ' AND p2.codPersona = personal.idPersona AND pago.estado = 1 order by pago.codPago desc ');
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
                DB::table('pago')->where('codPago', $codPago)->update(['deuda' => 0]);
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
    public function listarGeneral($estado, $modalidad, $fechaDesde, $fechaHasta)
    {
        if ($modalidad == 'Todo') {
            $pago = DB::table('pago')->select(['pago.codpago as codigoPago', 'pago.modalidad as modalidad', 'facultad.nombre as NombreFacultad',
                'escuela.nombre as nombreEscuela', 'pago.fecha as fechaPago', 'tramite.nombre as nombreTramite', 'subtramite.nombre as nombreSubTramite', 'subtramite.precio as precio'])
                ->leftjoin('personal', 'pago.copersonal', '=', 'personal.idpersonal')
                ->leftjoin('persona', 'personal.idpersona', '=', 'persona.codPersona')
                ->leftjoin('subtramite', 'pago.idSubtramite', '=', 'subtramite.codSubtramite')
                ->leftjoin('tramite', 'tramite.codTramite', '=', 'subtramite.idTramite')
                ->leftjoin('persona as p', 'pago.idpersona', '=', 'p.codPersona')
                ->leftjoin('alumno', 'persona.codPersona', '=', 'alumno.idPersona')
                ->leftjoin('escuela', 'alumno.coEscuela', '=', 'escuela.idEscuela')
                ->leftjoin('facultad', 'escuela.codigoFacultad', '=', 'facultad.idFacultad')
                ->leftjoin('sede', 'facultad.coSede', '=', 'sede.codSede')
                ->where([
                    ['pago.estado', $estado],
                    ['pago.fecha', '>', $fechaDesde],
                    //  ['pago.fecha', '=', $fechaDesde],
                    ['pago.fecha', '<', $fechaHasta],
                    //   ['pago.fecha', '=', $fechaHasta]
                ])->get();
        } else {
            $pago = DB::table('pago')->select(['pago.codpago as codigoPago', 'pago.modalidad as modalidad', 'sede.nombresede as nombreSede', 'facultad.nombre as NombreFacultad',
                'escuela.nombre as nombreEscuela', 'pago.fecha as fechaPago', 'tramite.nombre as nombreTramite', 'subtramite.nombre as nombreSubTramite', 'subtramite.precio as precio'])
                ->leftjoin('personal', 'pago.copersonal', '=', 'personal.idpersonal')
                ->leftjoin('persona', 'personal.idpersona', '=', 'persona.codPersona')
                ->leftjoin('subtramite', 'pago.idSubtramite', '=', 'subtramite.codSubtramite')
                ->leftjoin('tramite', 'tramite.codTramite', '=', 'subtramite.idTramite')
                ->leftjoin('persona as p', 'pago.idpersona', '=', 'p.codPersona')
                ->leftjoin('alumno', 'persona.codPersona', '=', 'alumno.idPersona')
                ->leftjoin('escuela', 'alumno.coEscuela', '=', 'escuela.idEscuela')
                ->leftjoin('facultad', 'escuela.codigoFacultad', '=', 'facultad.idFacultad')
                ->leftjoin('sede', 'facultad.coSede', '=', 'sede.codSede')
                ->where([
                    ['pago.estado', $estado],
                    ['pago.modalidad', $modalidad],
                    ['pago.fecha', '>', $fechaDesde],
                    //  ['pago.fecha', '=', $fechaDesde],
                    ['pago.fecha', '<', $fechaHasta],
                    //   ['pago.fecha', '=', $fechaHasta]
                ])->get();
        }
        return $pago;

    }

    public function listarTramite($estado, $modalidad, $fechaDesde, $fechaHasta,$idTramite)
    {

            $pago = DB::table('pago')->select(['pago.codpago as codigoPago', 'pago.modalidad as modalidad', 'facultad.nombre as NombreFacultad',
                'escuela.nombre as nombreEscuela', 'pago.fecha as fechaPago', 'tramite.nombre as nombreTramite', 'subtramite.nombre as nombreSubTramite', 'subtramite.precio as precio'])
                ->leftjoin('personal', 'pago.copersonal', '=', 'personal.idpersonal')
                ->leftjoin('persona', 'personal.idpersona', '=', 'persona.codPersona')
                ->leftjoin('subtramite', 'pago.idSubtramite', '=', 'subtramite.codSubtramite')
                ->leftjoin('tramite', 'tramite.codTramite', '=', 'subtramite.idTramite')
                ->leftjoin('persona as p', 'pago.idpersona', '=', 'p.codPersona')
                ->leftjoin('alumno', 'persona.codPersona', '=', 'alumno.idPersona')
                ->leftjoin('escuela', 'alumno.coEscuela', '=', 'escuela.idEscuela')
                ->leftjoin('facultad', 'escuela.codigoFacultad', '=', 'facultad.idFacultad')
                ->leftjoin('sede', 'facultad.coSede', '=', 'sede.codSede')
                ->where([
                    ['pago.estado', $estado],
                    ['pago.fecha', '>', $fechaDesde],
                    //  ['pago.fecha', '=', $fechaDesde],
                    ['pago.fecha', '<', $fechaHasta],
                    //   ['pago.fecha', '=', $fechaHasta]
                ])->get();


        return $pago;
    }


}
