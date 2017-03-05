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
                    DB::table('pago')->insert(['detalle' => $this->detalle, 'fecha' => $this->fecha, 'modalidad' => $this->modalidad, 'idPersona' => $this->idPersona, 'idSubtramite' => $this->idSubtramite, 'coPersonal' => $this->coPersonal]);
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

    public function consultarAlumnoDNI($dni)
    {
        $alumnobd = DB::select('SELECT pago.codPago, p1.dni AS p1dni, p1.nombres AS p1nombres, p1.apellidos AS p1apellidos, subtramite.nombre, pago.fecha AS pfecha, subtramite.precio, pago.modalidad, detalle,
        p2.nombres AS pnombres, p2.apellidos AS papellidos FROM pago
        LEFT JOIN subtramite ON pago.idSubtramite = subtramite.codSubtramite
        LEFT JOIN personal ON pago.coPersonal = personal.idPersonal
        LEFT JOIN persona AS p1 ON p1.codPersona = pago.idPersona
        LEFT JOIN persona AS p2 ON p2.codPersona = personal.idPersona
        WHERE pago.idSubtramite = subtramite.codSubtramite AND pago.coPersonal = personal.idPersonal AND p1.codPersona = pago.idPersona AND p2.codPersona = personal.idPersona AND pago.estado = 1 AND p1.dni = ' . $dni . ' ');
        return $alumnobd;
    }

    public function consultarAlumnoCodigo($codAlumno)
    {
        $alumnobd = DB::select('select pago.codPago, p1.dni as p1dni, p1.nombres as p1nombres, p1.apellidos as p1apellidos,subtramite.nombre, pago.fecha as pfecha ,subtramite.precio, pago.modalidad, p2.nombres as pnombres, p2.apellidos as papellidos, detalle from pago
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
        and pago.estado=1 and alumno.codAlumno = ' . $codAlumno . ' ');

        return $alumnobd;
    }

    public function consultarClienteRuc($ruc)
    {
        $clientebd = DB::select('select pago.codPago, p1.dni as p1dni, p1.nombres as p1nombres, p1.apellidos as p1apellidos,subtramite.nombre, pago.fecha as pfecha ,subtramite.precio, pago.modalidad, p2.nombres as pnombres, p2.apellidos as papellidos, detalle from pago
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
        and pago.estado=1  and cliente.ruc = ' . $ruc . ' ');
        return $clientebd;
    }

    public function consultarCodigoPago($codPago)
    {
        $pagobd = DB::select('select pago.codPago, p1.dni as p1dni, p1.nombres as p1nombres, p1.apellidos as p1apellidos,subtramite.nombre, pago.fecha as pfecha ,subtramite.precio, pago.modalidad, p2.nombres as pnombres, p2.apellidos as papellidos, detalle from pago
        left join subtramite on pago.idSubtramite = subtramite.codSubtramite
        left join personal on pago.coPersonal = personal.idPersonal
        left join persona as p1 on p1.codPersona = pago.idPersona
        left join persona as p2 on p2.codPersona = personal.idPersona
        where pago.idSubtramite = subtramite.codSubtramite
        and pago.coPersonal = personal.idPersonal
        and p1.codPersona = pago.idPersona
        and p2.codPersona = personal.idPersona
        and pago.estado=1 and pago.codPago = ' . $codPago . ' ');

        return $pagobd;
    }

    public function consultarCodigoPagoReporte($codPago)
    {
        $pagobd = DB::select('select pago.codPago, p1.dni as p1dni, p1.nombres as p1nombres, p1.apellidos as p1apellidos,subtramite.nombre, pago.fecha as pfecha ,subtramite.precio, pago.modalidad, p2.nombres as pnombres, p2.apellidos as papellidos, detalle from pago
        left join subtramite on pago.idSubtramite = subtramite.codSubtramite
        left join personal on pago.coPersonal = personal.idPersonal
        left join persona as p1 on p1.codPersona = pago.idPersona
        left join persona as p2 on p2.codPersona = personal.idPersona
        where pago.idSubtramite = subtramite.codSubtramite
        and pago.coPersonal = personal.idPersonal
        and p1.codPersona = pago.idPersona
        and p2.codPersona = personal.idPersona
        and pago.estado=1 and subtramite.estado=1 and p1.estado =1 and p2.estado=1 and pago.codPago = ' . $codPago . ' ');

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
        and pago.estado=1 and subtramite.estado=1 and p1.estado =1 and p2.estado=1 and personal.codPersonal = ' . $codPersonal . ' and pago.fecha like "%' . $dato . '%"');

        return $pagobd;
    }

    public function consultarPagos()
    {
        $alumnobd = DB::select(' SELECT pago.codPago, p1.dni AS p1dni,p1.nombres AS p1nombres, p1.apellidos AS p1apellidos,subtramite.nombre, pago.fecha AS pfecha, subtramite.precio, pago.modalidad, detalle, p2.nombres AS pnombres,p2.apellidos AS papellidos FROM pago 
        LEFT JOIN subtramite ON pago.idSubtramite = subtramite.codSubtramite
        LEFT JOIN personal ON pago.coPersonal = personal.idPersonal
        LEFT JOIN persona AS p1 ON p1.codPersona = pago.idPersona
        LEFT JOIN persona AS p2 ON p2.codPersona = personal.idPersona
        WHERE pago.idSubtramite = subtramite.codSubtramite AND pago.coPersonal = personal.idPersonal AND p1.codPersona = pago.idPersona AND p2.codPersona = personal.idPersona AND pago.estado = 1');
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
            DB::transaction(function () use ($codPago, $logunt) {
                DB::table('pago')->where('codPago', $codPago)->update(['estado' => 0]);
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
    public function listarPagosClientes($estado, $modalidad, $fechaDesde, $fechaHasta)
    {

        $pago = DB::table('pago')->select('pago.codPago as codPago', 'pago.fecha as fechaPago', 'pago.modalidad as modalidad',
            'tramite.clasificador as clasificadorSiaf', 'tramite.nombre as nombreTramite', 'subtramite.nombre as nombreSubTramite', 'subTramite.precio as precio')
            ->leftjoin('subtramite', 'pago.idSubtramite', '=', 'subtramite.codSubtramite')
            ->leftjoin('tramite', 'subtramite.idTramite', '=', 'tramite.codTramite')
            ->leftjoin('persona', 'pago.idPersona', '=', 'persona.codPersona')
            ->leftjoin('personal', 'pago.coPersonal', '=', 'personal.idPersonal')
            // ->leftjoin('persona','personal.idPersona','=','persona.coPpersona')
            ->where([
                ['pago.estado', $estado],
                ['pago.modalidad', $modalidad],
                ['pago.fecha', '>=', $fechaDesde],
                ['pago.fecha', '<=', $fechaHasta],
            ])->orderBy('fecha')->get();;

        return $pago;
    }

    public function listarPagosAlumnos($estado, $modalidad, $fechaDesde, $fechaHasta)
    {

        $pago = DB::table('pago')->select('pago.codPago as codPago', 'pago.fecha as fechaPago', 'pago.modalidad as modalidad',
            'tramite.clasificador as clasificadorSiaf', 'tramite.nombre as nombreTramite', 'subtramite.nombre as nombreSubTramite', 'subTramite.precio as precio')
            ->leftjoin('subtramite', 'pago.idSubtramite', '=', 'subtramite.codSubtramite')
            ->leftjoin('tramite', 'subtramite.idTramite', '=', 'tramite.codTramite')
            ->leftjoin('personal', 'pago.coPersonal', '=', 'personal.idPersonal')
            ->leftjoin('persona', 'pago.idPersona', '=', 'persona.codPersona')
            ->where([
                ['pago.estado', $estado],
                ['pago.modalidad', $modalidad],
                ['pago.fecha', '>=', $fechaDesde],
                ['pago.fecha', '<=', $fechaHasta],
            ])->orderBy('fecha')->get();;

        return $pago;
    }
}
