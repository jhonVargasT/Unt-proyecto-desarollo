<?php

namespace App;

use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use PDOException;
use App\Http\Controllers\util;

class pagomodel
{
    private $detalle;
    private $fecha;
    private $modalidad;
    private $idPersona;
    private $idSubtramite;
    private $coPersonal;
    private $deuda;
    private $cantidad;
    private $idProduccionAlumno;

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

    /**
     * @return mixed
     */
    public function getIdProduccionAlumno()
    {
        return $this->idProduccionAlumno;
    }

    /**
     * @param mixed $idProduccionAlumno
     * @return pagomodel
     */
    public function setIdProduccionAlumno($idProduccionAlumno)
    {
        $this->idProduccionAlumno = $idProduccionAlumno;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param mixed $cantidad
     * @return pagomodel
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
        return $this;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function bdPersonaDni($var)
    {
        try {
            $cp = null;
            $personabd = DB::table('persona')->where('dni', '=', $var)->where('estado', 1)->get();
            foreach ($personabd as $pbd) {
                $cp = $pbd->codPersona;
            }
        } catch
        (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'bdPersonaRuc/pagomodel');
            return null;

        }
        return $cp;
    }

    public function bdPersonaRuc($var)
    {
        try {
            $obj = null;
            $personabd = DB::table('persona')
                ->leftJoin('cliente', 'persona.codPersona', '=', 'cliente.idPersona')
                ->where('cliente.ruc', '=', $var)
                ->get();
            foreach ($personabd as $per) {
                $obj = $per->codPersona;
            }
        } catch
        (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'bdPersonaRuc/pagomodel');
            return null;

        }
        return $obj;
    }

    public function bdPersonaCodigoAlumno($var)
    {
        try {
            $obj = null;
            $personabd = DB::table('persona')
                ->leftJoin('alumno', 'persona.codPersona', '=', 'alumno.idPersona')
                ->where('alumno.codigoAlumno', '=', $var)
                ->get();
            foreach ($personabd as $per) {
                $obj = $per->codPersona;
            }
        } catch
        (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'bdPersonaCodigoAlumno/pagomodel');
            return null;

        }
        return $obj;
    }

    public function bdSubtramite($var)
    {
        try {
            $obj = null;
            $subtramitebd = DB::table('subtramite')->where('nombre', '=', $var)->where('estado', 1)->get();
            foreach ($subtramitebd as $subbd) {
                $obj = $subbd->codSubtramite;
            }
        } catch
        (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'bdSubtramite/pagomodel');
            return null;

        }
        return $obj;
    }

    public function obtenerPagosresumensiaf($fecha)
    {
        try {
            $pago = DB::select('SELECT tr.clasificador as clasificadorsiaf, tr.nombre as nombreTramite,st.codigoSubtramite as codigoSubtramite, st.nombre as nombresubtramite,sum(st.precio) as precio, count(po.codPago) as nurPagos
                    FROM tramite as tr
                    LEFT JOIN subtramite st ON (tr.codTramite = st.idTramite)
                    LEFT JOIN pago po ON (st.codSubtramite=po.idSubtramite )
                    ' . $fecha . ' 
                    group by st.codSubtramite order by tr.nombre;');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'obtenerPagosresumensiaf/pagomodel');
            return null;
        }
        return $pago;
    }

    //Guardar pago
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
        if (Session::has('personalC')) {//Si existe session(pago por ventanilla)
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
                        DB::table('pago')->insert(['detalle' => $this->detalle, 'fecha' => $this->fecha, 'modalidad' => $this->modalidad, 'idPersona' => $this->idPersona, 'idSubtramite' => $this->idSubtramite, 'coPersonal' => $this->coPersonal, 'idProduccionAlumno' => $this->idProduccionAlumno, 'cantidad' => $this->cantidad]);
                        DB::table('subtramite')->where('codSubtramite', $this->idSubtramite)->update(['contador' => $contaux]);
                    } elseif ($this->deuda != 0) {
                        DB::table('pago')->insert(['detalle' => $this->detalle, 'fecha' => $this->fecha, 'modalidad' => $this->modalidad, 'idPersona' => $this->idPersona, 'idSubtramite' => $this->idSubtramite, 'coPersonal' => $this->coPersonal, 'estadodeuda' => $this->deuda, 'cantidad' => $this->cantidad]);
                        DB::table('subtramite')->where('codSubtramite', $this->idSubtramite)->update(['contador' => $contaux]);
                    }
                    $logunt->saveLogUnt();
                });
            } catch (PDOException $e) {
                $util = new util();
                $util->insertarError($e->getMessage(), ' savePago/pagomodel');
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    public function savePagoOnline($contaux)
    {
        try {
            $result = DB::transaction(function () use ($contaux) {//insertar pago y enviar correo de la boleta virtual al usuario
                $id = DB::table('pago')->insertGetId(['detalle' => $this->detalle, 'fecha' => $this->fecha, 'modalidad' => $this->modalidad, 'idPersona' => $this->idPersona, 'idSubtramite' => $this->idSubtramite, 'idProduccionAlumno' => $this->idProduccionAlumno]);
                DB::table('subtramite')->where('codSubtramite', $this->idSubtramite)->update(['contador' => $contaux]);
                return $id;
            });

        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), ' savePagoOnline/pagomodel');
            return null;
        }
        return $result;
    }

    public function boletaVirtual($codPago)
    {
        $total = null;
        $pag = $this->consultarCodigoPagoReporteR($codPago);//SQL, consultar pago por codigo de pago

        foreach ($pag as $p) {
            $total = $total + $p->precio;
        }
        view()->share(['pago' => $pag, 'total' => $total]);

        $pdf = app('dompdf.wrapper');

        $pdf->loadView('Ventanilla/Pagos/reporte');
        $pdf->stream('pagoAlumno.pdf');
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
                    DB::table('pago')->insert(['detalle' => $this->detalle, 'fecha' => $this->fecha, 'modalidad' => $this->modalidad, 'idPersona' => $this->idPersona, 'idSubtramite' => $this->idSubtramite]);
                    DB::table('subtramite')->where('codSubtramite', $this->idSubtramite)->update(['contador' => $contaux]);
                    $logunt->saveLogUnt();
                });
            } catch (PDOException $e) {
                $util = new util();
                $util->insertarError($e->getMessage(), 'saveExcel/pagomodel');
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    public function listarpagosresumen($tiempo)
    {
        try {
            $result = DB::select('SELECT tr.clasificador as clasificadorsiaf, tr.nombre as nombreTramite,sum(st.precio) as importe
                            FROM unt.tramite as tr
                            LEFT JOIN unt.subtramite st ON (tr.codTramite = st.idTramite)
                            LEFT JOIN unt.pago po ON (st.codSubtramite=po.idSubtramite )
                            ' . $tiempo . '
                            group by (tr.codTramite) ');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarpagosresumen/pagomodel');
            return null;
        }
        return $result;
    }

    public function consultarAlumnoDNI($dni, $val)
    {
        try {
            $alumnobd = DB::select('SELECT pago.codPago, p1.dni AS p1dni, p1.nombres AS p1nombres, p1.apellidos AS p1apellidos, subtramite.nombre, pago.fecha AS pfecha, (cantidad*precio) as precio, pago.modalidad, detalle, estadodeuda,
        p2.nombres AS pnombres, p2.apellidos AS papellidos FROM pago
        LEFT JOIN subtramite ON pago.idSubtramite = subtramite.codSubtramite
        LEFT JOIN personal ON pago.coPersonal = personal.idPersonal
        LEFT JOIN persona AS p1 ON p1.codPersona = pago.idPersona
        LEFT JOIN persona AS p2 ON p2.codPersona = personal.idPersona
        WHERE pago.idSubtramite = subtramite.codSubtramite
        AND p1.codPersona = pago.idPersona AND pago.estado = 1 
        and pago.estadodeuda = ' . $val . '
        AND p1.dni = ' . $dni . ' order by pago.codPago desc ');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarAlumnoDNI/pagomodel');
            return null;
        }
        return $alumnobd;
    }

    public function consultarAlumnoCodigo($codAlumno, $val)
    {
        try {
            $alumnobd = DB::select('select pago.codPago, p1.dni as p1dni, p1.nombres as p1nombres, p1.apellidos as p1apellidos,subtramite.nombre, pago.fecha as pfecha ,(cantidad*precio) as precio, pago.modalidad, p2.nombres as pnombres, p2.apellidos as papellidos, detalle, estadodeuda from pago
        left join subtramite on pago.idSubtramite = subtramite.codSubtramite
        left join personal on pago.coPersonal = personal.idPersonal
        left join persona as p1 on p1.codPersona = pago.idPersona
        left join persona as p2 on p2.codPersona = personal.idPersona
        left join alumno on p1.codPersona=alumno.idPersona
        where pago.idSubtramite = subtramite.codSubtramite
        and p1.codPersona = pago.idPersona
        and p1.codPersona=alumno.idPersona
        and pago.estadodeuda = ' . $val . '
        and pago.estado=1 and alumno.codAlumno =:codAlumno order by pago.codPago desc ', ['codAlumno' => $codAlumno]);
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarAlumnoCodigo/pagomodel');
            return null;
        }
        return $alumnobd;
    }

    public function consultarClienteRuc($ruc, $val)
    {
        try {
            $clientebd = DB::select('select pago.codPago, p1.dni as p1dni, p1.nombres as p1nombres, p1.apellidos as p1apellidos,subtramite.nombre, pago.fecha as pfecha ,(cantidad*precio) as precio, pago.modalidad, p2.nombres as pnombres, p2.apellidos as papellidos, detalle, estadodeuda from pago
        left join subtramite on pago.idSubtramite = subtramite.codSubtramite
        left join personal on pago.coPersonal = personal.idPersonal
        left join persona as p1 on p1.codPersona = pago.idPersona
        left join persona as p2 on p2.codPersona = personal.idPersona
        left join cliente on p1.codPersona=cliente.idPersona
        where pago.idSubtramite = subtramite.codSubtramite
        and p1.codPersona = pago.idPersona
        and p1.codPersona=cliente.idPersona
        and pago.estadodeuda = ' . $val . '
        and pago.estado=1  and cliente.ruc = ' . $ruc . ' order by pago.codPago desc ');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarClienteRuc/pagomodel');
            return null;
        }
        return $clientebd;
    }

    public function consultarCodigoPago($codPago, $val)
    {
        try {
            $pagobd = DB::select('select pago.codPago, p1.dni as p1dni, p1.nombres as p1nombres, p1.apellidos as p1apellidos,subtramite.nombre, pago.fecha as pfecha ,(cantidad*precio) as precio, pago.modalidad, p2.nombres as pnombres, p2.apellidos as papellidos, detalle, estadodeuda from pago
        left join subtramite on pago.idSubtramite = subtramite.codSubtramite
        left join personal on pago.coPersonal = personal.idPersonal
        left join persona as p1 on p1.codPersona = pago.idPersona
        left join persona as p2 on p2.codPersona = personal.idPersona
        where pago.idSubtramite = subtramite.codSubtramite
        and p1.codPersona = pago.idPersona
        and pago.estado=1 and pago.estadodeuda = ' . $val . ' and pago.codPago = ' . $codPago . ' order by pago.codPago desc');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarCodigoPago/pagomodel');
            return null;
        }
        return $pagobd;
    }

    public function consultarCodigoPagoReporte($codPago, $val)
    {
        try {
            $pagobd = DB::select('select pago.codPago, p1.dni as p1dni, p1.nombres as p1nombres, p1.apellidos as p1apellidos,subtramite.nombre, pago.fecha as pfecha ,(cantidad*precio) as precio, pago.modalidad, p2.nombres as pnombres, p2.apellidos as papellidos, detalle, estadodeuda from pago
        left join subtramite on pago.idSubtramite = subtramite.codSubtramite
        left join personal on pago.coPersonal = personal.idPersonal
        left join persona as p1 on p1.codPersona = pago.idPersona
        left join persona as p2 on p2.codPersona = personal.idPersona
        where pago.idSubtramite = subtramite.codSubtramite
        and p1.codPersona = pago.idPersona
        and pago.estado=1 and subtramite.estado=1 and p1.estado =1 and pago.estadodeuda = ' . $val . ' and p2.estado=1 and pago.codPago = ' . $codPago . ' order by pago.codPago desc');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), ' consultarCodigoPagoReporte/pagomodel');
            return null;
        }
        return $pagobd;
    }

    public function consultarCodigoPagoReporteR($codPago)
    {
        try {
            $pagobd = DB::select('SELECT 
                    pago.codPago,
                    p1.dni AS p1dni,
                    p1.nombres AS p1nombres,
                    p1.apellidos AS p1apellidos,
                    subtramite.nombre,
                    pago.fecha AS pfecha,
                    (cantidad*precio) as precio,
                    pago.modalidad,
                    detalle,
                    estadodeuda
                FROM
                    pago
                        LEFT JOIN
                    subtramite ON pago.idSubtramite = subtramite.codSubtramite
                        LEFT JOIN
                    personal ON pago.coPersonal = personal.idPersonal
                        LEFT JOIN
                    persona AS p1 ON p1.codPersona = pago.idPersona
                WHERE
                    pago.idSubtramite = subtramite.codSubtramite
                        AND p1.codPersona = pago.idPersona
                        AND pago.estado = 1
                        AND subtramite.estado = 1
                        AND p1.estado = 1
                        AND pago.estadodeuda = 0
                        AND pago.codPago = ' . $codPago . '
                ORDER BY pago.codPago DESC');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarCodigoPagoReporteR/pagomodel');
            return null;
        }
        return $pagobd;
    }

    public function consultarCodigoPersonal($codPersonal)
    {
        try {
            date_default_timezone_set('America/Lima');
            $dato = date('Y-m-d');
            $pagobd = DB::select('select pago.codPago, p1.dni as p1dni, p1.nombres as p1nombres, p1.apellidos as p1apellidos,subtramite.nombre, pago.fecha as pfecha ,(cantidad*precio) as precio, pago.modalidad, p2.nombres as pnombres, p2.apellidos as papellidos, detalle, estadodeuda from pago
        left join subtramite on pago.idSubtramite = subtramite.codSubtramite
        left join personal on pago.coPersonal = personal.idPersonal
        left join persona as p1 on p1.codPersona = pago.idPersona
        left join persona as p2 on p2.codPersona = personal.idPersona
        where pago.idSubtramite = subtramite.codSubtramite
        and pago.coPersonal = personal.idPersonal
        and p1.codPersona = pago.idPersona
        and p2.codPersona = personal.idPersona and pago.modalidad= "ventanilla"
        and pago.estado=1 and subtramite.estado=1 and p1.estado =1 and p2.estado=1 and personal.codPersonal =:codPersonal and pago.fecha like "%' . $dato . '%" order by pago.fecha desc', ['codPersonal' => $codPersonal]);
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarCodigoPersonal/pagomodel');
            return null;
        }
        return $pagobd;
    }

    public function consultarPagos($val)
    {
        try {
            $alumnobd = DB::select(' SELECT pago.codPago, p1.dni AS p1dni,p1.nombres AS p1nombres, p1.apellidos AS p1apellidos,subtramite.nombre, pago.fecha AS pfecha, (cantidad*precio) as precio, pago.modalidad, detalle, p2.nombres AS pnombres,p2.apellidos AS papellidos, estadodeuda FROM pago 
        LEFT JOIN subtramite ON pago.idSubtramite = subtramite.codSubtramite
        LEFT JOIN personal ON pago.coPersonal = personal.idPersonal
        LEFT JOIN persona AS p1 ON p1.codPersona = pago.idPersona
        LEFT JOIN persona AS p2 ON p2.codPersona = personal.idPersona
        WHERE pago.idSubtramite = subtramite.codSubtramite
        AND p1.codPersona = pago.idPersona and pago.estadodeuda = ' . $val . '  AND pago.estado = 1 order by pago.codPago desc ');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'consultarPagos/pagomodel');
            return null;
        }
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
            $util = new util();
            $util->insertarError($e->getMessage(), 'eliminarPago/pagomodel');
            return false;
        }
        return true;
    }

    public function devolucionPago($codPago)
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
                DB::table('pago')->where('codPago', $codPago)->update(['estado' => 0]);
                $logunt->saveLogUnt();
            });
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'devolucionPago/pagomodel');
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
            $util = new util();
            $util->insertarError($e->getMessage(), ' eliminarDeuda/pagomodel');
            return false;
        }
        return true;
    }

    public function obteneridProduccionAlumno($cpro, $cod)
    {
        try {
            $prod = null;
            $prouccionbd = DB::select('select codProduccionAlumno from produccionalumno where codAlumno = ' . $cod . ' and idProduccion= ' . $cpro . ' ');

            foreach ($prouccionbd as $p) {
                $prod = $p->codProduccionAlumno;
            }
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'obteneridProduccionAlumno/pagomodel');
            return null;
        }
        return $prod;
    }

    // pago,personal,subtramite,escuela,facultad
    public function listarPagosfacultad($estado, $modalidad, $fechaDesde, $fechaHasta, $facultad, $subtramite)
    {
        try {
            $pago = DB::table('pago')
                ->join('subtramite', 'subtramite.codSubtramite', '=', 'pago.idSubtramite')
                ->join('personal', 'users.idPersonal', '=', 'pago.coPersonal')
                ->select('users.*', 'contacts.phone', 'pago.price')
                ->where(['estado' => $estado, 'modalidad' => $modalidad])
                ->get();
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'obteneridProduccionAlumno/pagomodel');
            return null;
        }
        return $pago;
    }

    // pago,personal,subtramite,escuela,facultad
    public function listarGeneral($estado, $modalidad, $fechaDesde, $fechaHasta, $tram, $valtram, $tipoRe, $fuefin, $local, $vallocal, $centroProducion)
    {

        $pago = null;
        if ($modalidad == 'Todo' && $tram == 'Todo' && empty($tipoRe) && empty($fuefin) && empty($local) && empty($centroProducion)) {
            $pago = $this->listarPagoNada($estado, $fechaDesde, $fechaHasta);
        } elseif ($modalidad != 'Todo' && $tram == 'Todo' && empty($tipoRe) && empty($fuefin) && empty($local) && empty($centroProducion)) {
            $pago = $this->listarPagoModalidad($estado, $modalidad, $fechaDesde, $fechaHasta);
        } elseif ($modalidad != 'Todo' && $tram != 'Todo' && empty($tipoRe) && empty($fuefin) && empty($local) && empty($centroProducion)) {
            $pago = $this->listarModTram($estado, $modalidad, $tram, $valtram, $fechaDesde, $fechaHasta);
        } elseif ($modalidad != 'Todo' && $tram != 'Todo' && empty($tipoRe) && empty($fuefin) && !empty($local) && empty($centroProducion)) {
            $pago = $this->listarTramModLoc($estado, $modalidad, $tram, $valtram, $fechaDesde, $fechaHasta, $local, $vallocal);
        } elseif ($modalidad != 'Todo' && $tram == 'Todo' && empty($fuefin) && empty($local) && !empty($tipoRe) && empty($centroProducion)) {
            $pago = $this->listarModTip($estado, $modalidad, $fechaDesde, $fechaHasta, $tipoRe);
        } elseif ($modalidad != 'Todo' && !empty($tipoRe) && !empty($fuefin) && !empty($local) && $tram == 'Todo') {
            $pago = $this->listarMoTiFuLo($estado, $modalidad, $fechaDesde, $fechaHasta, $tipoRe, $fuefin, $local, $vallocal);
        } elseif ($modalidad != 'Todo' && $tram == 'Todo' && empty($tipoRe) && empty($fuefin) && !empty($local) && empty($centroProducion)) {
            $pago = $this->listarMoLo($estado, $modalidad, $fechaDesde, $fechaHasta, $local, $vallocal);
        } elseif ($modalidad != 'Todo' && $tram == 'Todo' && empty($tipoRe) && !empty($fuefin) && !empty($local) && empty($centroProducion)) {
            $pago = $this->listarMoFuLo($estado, $modalidad, $fechaDesde, $fechaHasta, $fuefin, $local, $vallocal);
        } elseif ($modalidad == 'Todo' && $tram != 'Todo' && empty($tipoRe) && empty($fuefin) && empty($local) && empty($centroProducion)) {
            $pago = $this->listarTr($estado, $fechaDesde, $fechaHasta, $tram, $valtram);
        } elseif ($modalidad != 'Todo' && $tram != 'Todo' && empty($tipoRe) && !empty($fuefin) && !empty($local) && empty($centroProducion)) {
            $pago = $this->listarMoTrFuLo($estado, $fechaDesde, $fechaHasta, $tram, $valtram, $fuefin, $local, $vallocal);
        } elseif ($modalidad == 'Todo' && $tram == 'Todo' && empty($fuefin) && !empty($tipoRe) && empty($local) && empty($centroProducion)) {
            $pago = $this->listarTipoRe($estado, $fechaDesde, $fechaHasta, $tipoRe);
        } elseif ($modalidad == 'Todo' && $tram != 'Todo' && empty($fuefin) && !empty($tipoRe) && empty($local) && empty($centroProducion)) {
            $pago = $this->listarTraTip($estado, $fechaDesde, $fechaHasta, $tram, $valtram, $tipoRe);
        } elseif ($modalidad == 'Todo' && $tram == 'Todo' && !empty($fuefin) && !empty($tipoRe) && empty($local) && empty($centroProducion)) {
            $pago = $this->listarFueTip($estado, $fechaDesde, $fechaHasta, $tipoRe, $fuefin);
        } elseif ($modalidad == 'Todo' && $tram == 'Todo' && empty($fuefin) && !empty($tipoRe) && !empty($local) && empty($centroProducion)) {
            $pago = $this->listarFueTipLo($estado, $fechaDesde, $fechaHasta, $tipoRe, $local, $vallocal);
        } elseif ($modalidad != 'Todo' && $tram != 'Todo' && empty($fuefin) && empty($local) && !empty($tipoRe) && empty($centroProducion)) {
            $pago = $this->listarTip($estado, $fechaDesde, $fechaHasta, $tipoRe, $modalidad, $tram, $valtram);
        } elseif ($modalidad != 'Todo' && $tram == 'Todo' && empty($local) && !empty($fuefin) && !empty($tipoRe) && empty($centroProducion)) {
            $pago = $this->listarMoFueTipFu($estado, $fechaDesde, $fechaHasta, $tipoRe, $modalidad, $fuefin);
        } elseif ($modalidad != 'Todo' && $tram != 'Todo' && !empty($fuefin) && !empty($tipoRe) && empty($local) && empty($centroProducion)) {
            $pago = $this->listarMoTraFuTi($estado, $fechaDesde, $fechaHasta, $tipoRe, $modalidad, $fuefin, $tram, $valtram);
        } elseif ($modalidad != 'Todo' && $tram != 'Todo' && empty($fuefin) && !empty($tipoRe) && !empty($local) && empty($centroProducion)) {
            $pago = $this->listarMoTraTiLo($estado, $fechaDesde, $fechaHasta, $tipoRe, $modalidad, $tram, $valtram, $local, $vallocal);
        } elseif ($modalidad == 'Todo' && $tram == 'Todo' && !empty($fuefin) && empty($tipoRe) && empty($local) && empty($centroProducion)) {
            $pago = $this->listarFu($estado, $fechaDesde, $fechaHasta, $fuefin);
        } elseif ($modalidad != 'Todo' && $tram == 'Todo' && empty($tipoRe) && empty($local) && !empty($fuefin) && empty($centroProducion)) {
            $pago = $this->listarMoFu($estado, $fechaDesde, $fechaHasta, $modalidad, $fuefin);
        } elseif ($modalidad == 'Todo' && $tram != 'Todo' && empty($tipoRe) && empty($local) && !empty($fuefin) && empty($centroProducion)) {
            $pago = $this->listarTraFu($estado, $fechaDesde, $fechaHasta, $tram, $valtram, $fuefin);
        } elseif ($modalidad != 'Todo' && $tram != 'Todo' && empty($tipoRe) && empty($local) && !empty($fuefin) && empty($centroProducion)) {
            $pago = $this->listarMoTraFu($estado, $fechaDesde, $fechaHasta, $modalidad, $tram, $valtram, $fuefin);
        } elseif ($modalidad == 'Todo' && $tram == 'Todo' && empty($tipoRe) && empty($fuefin) && !empty($local) && empty($centroProducion)) {
            $pago = $this->listarLoc($estado, $fechaDesde, $fechaHasta, $local, $vallocal);
        } elseif ($modalidad == 'Todo' && $tram != 'Todo' && empty($tipoRe) && empty($fuefin) && !empty($local) && empty($centroProducion)) {
            $pago = $this->listarTraLo($estado, $fechaDesde, $fechaHasta, $tram, $valtram, $local, $vallocal);
        } elseif ($modalidad == 'Todo' && $tram == 'Todo' && empty($tipoRe) && !empty($fuefin) && !empty($local) && empty($centroProducion)) {
            $pago = $this->listarFueLo($estado, $fechaDesde, $fechaHasta, $fuefin, $local, $vallocal);
        } elseif ($modalidad != 'Todo' && $tram == 'Todo' && !empty($tipoRe) && empty($fuefin) && !empty($local) && empty($centroProducion)) {
            $pago = $this->listarMoTiLo($estado, $fechaDesde, $fechaHasta, $modalidad, $tipoRe, $local, $vallocal);
        } elseif ($modalidad != 'Todo' && $tram != 'Todo' && !empty($tipoRe) && !empty($fuefin) && !empty($local) && empty($centroProducion)) {
            $pago = $this->listarTodo($estado, $fechaDesde, $fechaHasta, $modalidad, $tipoRe, $fuefin, $local, $vallocal, $tram, $valtram);
        } elseif (!empty($centroProducion) && $modalidad == 'Todo' && $tram == 'Todo' && empty($local) && empty($tipoRe) && empty($fuefin)) {
            $pago = $this->listarPagoProduccionTodo($centroProducion, $fechaDesde, $fechaHasta, $estado);

        } elseif (!empty($centroProducion) && $modalidad != 'Todo' && $tram == 'Todo' && empty($local) && empty($tipoRe) && empty($fuefin)) {
            $pago = $this->listarPagoProduccionmodalidad($centroProducion, $fechaDesde, $fechaHasta, $estado, $modalidad);
        } elseif (!empty($centroProducion) && $modalidad == 'Todo' && $tram != 'Todo' && empty($local) && empty($tipoRe) && empty($fuefin)) {
            $pago = $this->listarPagoProduccionTramite($centroProducion, $fechaDesde, $fechaHasta, $estado, $tram, $valtram);
        } elseif (!empty($centroProducion) && $modalidad == 'Todo' && $tram == 'Todo' && empty($local) && !empty($tipoRe) && empty($fuefin)) {
            $pago = $this->listarPagoProduccionTipRe($centroProducion, $fechaDesde, $fechaHasta, $estado, $tipoRe);
        } elseif (!empty($centroProducion) && $modalidad == 'Todo' && $tram == 'Todo' && empty($local) && empty($tipoRe) && !empty($fuefin)) {
            $pago = $this->listarPagoProduccionFueFi($centroProducion, $fechaDesde, $fechaHasta, $estado, $fuefin);
        } elseif (!empty($centroProducion) && $modalidad != 'Todo' && $tram != 'Todo' && empty($local) && empty($tipoRe) && empty($fuefin)) {
            $pago = $this->listarPagoProduccionModalidadTramite($centroProducion, $fechaDesde, $fechaHasta, $estado, $tram, $valtram, $modalidad);
        } elseif (!empty($centroProducion) && $modalidad != 'Todo' && $tram == 'Todo' && empty($local) && !empty($tipoRe) && empty($fuefin)) {
            $pago = $this->listarPagoProduccionModalidadTipre($centroProducion, $fechaDesde, $fechaHasta, $estado, $tipoRe, $modalidad);

        } elseif (!empty($centroProducion) && $modalidad != 'Todo' && $tram == 'Todo' && empty($local) && empty($tipoRe) && !empty($fuefin)) {
            $pago = $this->listarPagoProduccionModalidadfuefi($centroProducion, $fechaDesde, $fechaHasta, $estado, $fuefin, $modalidad);
        } elseif (!empty($centroProducion) && $modalidad != 'Todo' && $tram != 'Todo' && empty($local) && !empty($tipoRe) && !empty($fuefin)) {
            $pago = $this->listarPagoProduccionModalidadTramTipoReFueFI($centroProducion, $fechaDesde, $fechaHasta, $estado, $fuefin, $modalidad, $tipoRe, $tram, $valtram);
        } elseif (!empty($centroProducion) && $modalidad != 'Todo' && $tram != 'Todo' && empty($local) && !empty($tipoRe) && empty($fuefin)) {
            $pago = $this->listarPagoProduccionModalidadTramTipoRe($centroProducion, $fechaDesde, $fechaHasta, $estado, $modalidad, $tipoRe, $tram, $valtram);
        } elseif (!empty($centroProducion) && $modalidad != 'Todo' && $tram != 'Todo' && empty($local) && empty($tipoRe) && !empty($fuefin)) {
            $pago = $this->listarPagoProduccionModalidadTramFueFi($centroProducion, $fechaDesde, $fechaHasta, $estado, $modalidad, $fuefin, $tram, $valtram);
        } elseif (!empty($centroProducion) && $modalidad == 'Todo' && $tram != 'Todo' && empty($local) && empty($tipoRe) && !empty($fuefin)) {
            $pago = $this->listarpagosProduccionTramiteFuefi($centroProducion, $fechaDesde, $fechaHasta, $estado, $fuefin, $tram, $valtram);
        } elseif (!empty($centroProducion) && $modalidad == 'Todo' && $tram != 'Todo' && empty($local) && !empty($tipoRe) && empty($fuefin)) {
            $pago = $this->listarpagosProduccionTramiteTipoRe($centroProducion, $fechaDesde, $fechaHasta, $estado, $tipoRe, $tram, $valtram);
        } elseif (!empty($centroProducion) && $modalidad == 'Todo' && $tram != 'Todo' && empty($local) && !empty($tipoRe) && !empty($fuefin)) {
            $pago = $this->listarpagosProduccionTramiteTipoReFuefi($centroProducion, $fechaDesde, $fechaHasta, $estado, $tipoRe, $tram, $valtram, $fuefin);
        } elseif (!empty($centroProducion) && $modalidad == 'Todo' && $tram == 'Todo' && empty($local) && !empty($tipoRe) && !empty($fuefin)) {
            $pago = $this->listarPagosPrduccionFueFiTipoRe($centroProducion, $fechaDesde, $fechaHasta, $estado, $tipoRe, $fuefin);
        } else {

            $pago = null;
        }
        return $pago;
    }

    public function listarPagosPrduccionFueFiTipoRe($centroProduccion, $fechaDesde, $fechaHasta, $estado, $tipoRe, $fuefin)
    {
        try {
            $pago = DB::select('SELECT po.codpago as codigopago,po.modalidad as modalidad,pro.nombre  as nombresede, null as nombrefacultad,
                            null  as  nombreescuela, po.fecha as fechapago, tr.nombre as nombretramite,tr.clasificador as clasi,tr.fuentefinanc as fuentefinanc,tr.tiporecurso as tiporecurso, st.nombre as nombresubtramite,
                            st.precio as precio,po.detalle as pagodetalle
                             FROM pago as po
                            LEFT JOIN persona per ON (po.idpersona = per.codPersona)
                            LEFT JOIN alumno al ON (per.codPersona = al.idPersona)
                            LEFT JOIN personal ps ON (ps.idpersonal=po.copersonal)
                            LEFT JOIN persona pl ON (ps.idpersona=pl.codPersona)
                            LEFT JOIN subtramite st ON (po.idSubtramite =st.codSubtramite)
                            LEFT JOIN tramite tr ON (st.idTramite=tr.codTramite) 
                            LEFT JOIN produccionalumno pa ON (pa.codProduccionAlumno = po.idProduccionAlumno)
                            LEFT JOIN produccion pro ON (pro.codProduccion =  pa.idProduccion)
                             where idProduccionAlumno is not null and po.estado = ' . $estado . ' and tr.fuentefinanc=\'' . $fuefin . '\'  and tr.tipoRecurso=\'' . $tipoRe . '\'      and pro.nombre = \'' . $centroProduccion . '\' and  date(po.fecha) between \'' . $fechaDesde . '\'  and  \'' . $fechaHasta . '\' '

            );
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarPagosPrduccionFueFiTipoRe/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarpagosProduccionTramiteTipoReFuefi($centroProduccion, $fechaDesde, $fechaHasta, $estado, $tipoRe, $tram, $valtra, $fuefin)
    {
        try {
            $pago = DB::select('SELECT po.codpago as codigopago,po.modalidad as modalidad,pro.nombre  as nombresede, null as nombrefacultad,
                            null  as  nombreescuela, po.fecha as fechapago, tr.nombre as nombretramite,tr.clasificador as clasi,tr.fuentefinanc as fuentefinanc,tr.tiporecurso as tiporecurso, st.nombre as nombresubtramite,
                            st.precio as precio,po.detalle as pagodetalle
                             FROM pago as po
                            LEFT JOIN persona per ON (po.idpersona = per.codPersona)
                            LEFT JOIN alumno al ON (per.codPersona = al.idPersona)
                            LEFT JOIN personal ps ON (ps.idpersonal=po.copersonal)
                            LEFT JOIN persona pl ON (ps.idpersona=pl.codPersona)
                            LEFT JOIN subtramite st ON (po.idSubtramite =st.codSubtramite)
                            LEFT JOIN tramite tr ON (st.idTramite=tr.codTramite) 
                            LEFT JOIN produccionalumno pa ON (pa.codProduccionAlumno = po.idProduccionAlumno)
                            LEFT JOIN produccion pro ON (pro.codProduccion =  pa.idProduccion)
                             where idProduccionAlumno is not null and po.estado = ' . $estado . ' and tr.fuentefinanc=\'' . $fuefin . '\'  and tr.tipoRecurso=\'' . $tipoRe . '\'  and ' . $tram . '= \'' . $valtra . '\'      and pro.nombre = \'' . $centroProduccion . '\' and  date(po.fecha) between \'' . $fechaDesde . '\'  and  \'' . $fechaHasta . '\' '

            );
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarpagosProduccionTramiteTipoReFuefi/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarpagosProduccionTramiteTipoRe($centroProduccion, $fechaDesde, $fechaHasta, $estado, $tipoRe, $tram, $valtra)
    {
        try {
            $pago = DB::select('SELECT po.codpago as codigopago,po.modalidad as modalidad,pro.nombre  as nombresede, null as nombrefacultad,
                            null  as  nombreescuela, po.fecha as fechapago, tr.nombre as nombretramite,tr.clasificador as clasi,tr.fuentefinanc as fuentefinanc,tr.tiporecurso as tiporecurso, st.nombre as nombresubtramite,
                            st.precio as precio,po.detalle as pagodetalle
                             FROM pago as po
                            LEFT JOIN persona per ON (po.idpersona = per.codPersona)
                            LEFT JOIN alumno al ON (per.codPersona = al.idPersona)
                            LEFT JOIN personal ps ON (ps.idpersonal=po.copersonal)
                            LEFT JOIN persona pl ON (ps.idpersona=pl.codPersona)
                            LEFT JOIN subtramite st ON (po.idSubtramite =st.codSubtramite)
                            LEFT JOIN tramite tr ON (st.idTramite=tr.codTramite) 
                            LEFT JOIN produccionalumno pa ON (pa.codProduccionAlumno = po.idProduccionAlumno)
                            LEFT JOIN produccion pro ON (pro.codProduccion =  pa.idProduccion)
                             where idProduccionAlumno is not null and po.estado = ' . $estado . '   and tr.tipoRecurso=\'' . $tipoRe . '\'  and ' . $tram . '= \'' . $valtra . '\'      and pro.nombre = \'' . $centroProduccion . '\' and  date(po.fecha) between \'' . $fechaDesde . '\'  and  \'' . $fechaHasta . '\' '

            );
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarpagosProduccionTramiteTipoRe/pagomodel');
            return null;
        }
        return $pago;

    }

    public function listarpagosProduccionTramiteFuefi($centroProduccion, $fechaDesde, $fechaHasta, $estado, $fuefin, $tram, $valtra)
    {
        try {
            $pago = DB::select('SELECT po.codpago as codigopago,po.modalidad as modalidad,pro.nombre  as nombresede, null as nombrefacultad,
                            null  as  nombreescuela, po.fecha as fechapago, tr.nombre as nombretramite,tr.clasificador as clasi,tr.fuentefinanc as fuentefinanc,tr.tiporecurso as tiporecurso, st.nombre as nombresubtramite,
                            st.precio as precio,po.detalle as pagodetalle
                             FROM pago as po
                            LEFT JOIN persona per ON (po.idpersona = per.codPersona)
                            LEFT JOIN alumno al ON (per.codPersona = al.idPersona)
                            LEFT JOIN personal ps ON (ps.idpersonal=po.copersonal)
                            LEFT JOIN persona pl ON (ps.idpersona=pl.codPersona)
                            LEFT JOIN subtramite st ON (po.idSubtramite =st.codSubtramite)
                            LEFT JOIN tramite tr ON (st.idTramite=tr.codTramite) 
                            LEFT JOIN produccionalumno pa ON (pa.codProduccionAlumno = po.idProduccionAlumno)
                            LEFT JOIN produccion pro ON (pro.codProduccion =  pa.idProduccion)
                             where idProduccionAlumno is not null and po.estado = ' . $estado . '   and tr.fuentefinanc=\'' . $fuefin . '\'  and ' . $tram . '= \'' . $valtra . '\'      and pro.nombre = \'' . $centroProduccion . '\' and  date(po.fecha) between \'' . $fechaDesde . '\'  and  \'' . $fechaHasta . '\' '

            );
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), ' listarpagosProduccionTramiteFuefi/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarPagoProduccionModalidadTramFueFi($centroProduccion, $fechaDesde, $fechaHasta, $estado, $modalidad, $fuefin, $tram, $valtra)
    {
        try {
            $pago = DB::select('SELECT po.codpago as codigopago,po.modalidad as modalidad,pro.nombre  as nombresede, null as nombrefacultad,
                            null  as  nombreescuela, po.fecha as fechapago, tr.nombre as nombretramite,tr.clasificador as clasi,tr.fuentefinanc as fuentefinanc,tr.tiporecurso as tiporecurso, st.nombre as nombresubtramite,
                            st.precio as precio,po.detalle as pagodetalle
                             FROM pago as po
                            LEFT JOIN persona per ON (po.idpersona = per.codPersona)
                            LEFT JOIN alumno al ON (per.codPersona = al.idPersona)
                            LEFT JOIN personal ps ON (ps.idpersonal=po.copersonal)
                            LEFT JOIN persona pl ON (ps.idpersona=pl.codPersona)
                            LEFT JOIN subtramite st ON (po.idSubtramite =st.codSubtramite)
                            LEFT JOIN tramite tr ON (st.idTramite=tr.codTramite) 
                            LEFT JOIN produccionalumno pa ON (pa.codProduccionAlumno = po.idProduccionAlumno)
                            LEFT JOIN produccion pro ON (pro.codProduccion =  pa.idProduccion)
                             where idProduccionAlumno is not null and po.estado = ' . $estado . '   and tr.fuentefinanc=\'' . $fuefin . '\'  and ' . $tram . '= \'' . $valtra . '\'    and po.modalidad = \'' . $modalidad . '\'    and pro.nombre = \'' . $centroProduccion . '\' and  date(po.fecha) between \'' . $fechaDesde . '\'  and  \'' . $fechaHasta . '\' '

            );
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarPagoProduccionModalidadTramFueFi/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarPagoProduccionModalidadTramTipoRe($centroProduccion, $fechaDesde, $fechaHasta, $estado, $modalidad, $tipoRe, $tram, $valtra)
    {
        try {
            $pago = DB::select('SELECT po.codpago as codigopago,po.modalidad as modalidad,pro.nombre  as nombresede, null as nombrefacultad,
                            null  as  nombreescuela, po.fecha as fechapago, tr.nombre as nombretramite,tr.clasificador as clasi,tr.fuentefinanc as fuentefinanc,tr.tiporecurso as tiporecurso, st.nombre as nombresubtramite,
                            st.precio as precio,po.detalle as pagodetalle
                             FROM pago as po
                            LEFT JOIN persona per ON (po.idpersona = per.codPersona)
                            LEFT JOIN alumno al ON (per.codPersona = al.idPersona)
                            LEFT JOIN personal ps ON (ps.idpersonal=po.copersonal)
                            LEFT JOIN persona pl ON (ps.idpersona=pl.codPersona)
                            LEFT JOIN subtramite st ON (po.idSubtramite =st.codSubtramite)
                            LEFT JOIN tramite tr ON (st.idTramite=tr.codTramite) 
                            LEFT JOIN produccionalumno pa ON (pa.codProduccionAlumno = po.idProduccionAlumno)
                            LEFT JOIN produccion pro ON (pro.codProduccion =  pa.idProduccion)
                             where idProduccionAlumno is not null and po.estado = ' . $estado . '   and ' . $tram . '= \'' . $valtra . '\'   and tr.tipoRecurso=\'' . $tipoRe . '\'  and po.modalidad = \'' . $modalidad . '\'    and pro.nombre = \'' . $centroProduccion . '\' and  date(po.fecha) between \'' . $fechaDesde . '\'  and  \'' . $fechaHasta . '\' '

            );
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarPagoProduccionModalidadTramTipoRe/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarPagoProduccionModalidadTramTipoReFueFI($centroProduccion, $fechaDesde, $fechaHasta, $estado, $fuefin, $modalidad, $tipoRe, $tram, $valtra)
    {
        try {
            $pago = DB::select('SELECT po.codpago as codigopago,po.modalidad as modalidad,pro.nombre  as nombresede, null as nombrefacultad,
                            null  as  nombreescuela, po.fecha as fechapago, tr.nombre as nombretramite,tr.clasificador as clasi,tr.fuentefinanc as fuentefinanc,tr.tiporecurso as tiporecurso, st.nombre as nombresubtramite,
                            st.precio as precio,po.detalle as pagodetalle
                             FROM pago as po
                            LEFT JOIN persona per ON (po.idpersona = per.codPersona)
                            LEFT JOIN alumno al ON (per.codPersona = al.idPersona)
                            LEFT JOIN personal ps ON (ps.idpersonal=po.copersonal)
                            LEFT JOIN persona pl ON (ps.idpersona=pl.codPersona)
                            LEFT JOIN subtramite st ON (po.idSubtramite =st.codSubtramite)
                            LEFT JOIN tramite tr ON (st.idTramite=tr.codTramite) 
                            LEFT JOIN produccionalumno pa ON (pa.codProduccionAlumno = po.idProduccionAlumno)
                            LEFT JOIN produccion pro ON (pro.codProduccion =  pa.idProduccion)
                             where idProduccionAlumno is not null and po.estado = ' . $estado . '   and ' . $tram . '= \'' . $valtra . '\'   and tr.tipoRecurso=\'' . $tipoRe . '\'  and tr.fuentefinanc=\'' . $fuefin . '\' and po.modalidad = \'' . $modalidad . '\'    and pro.nombre = \'' . $centroProduccion . '\' and  date(po.fecha) between \'' . $fechaDesde . '\'  and  \'' . $fechaHasta . '\' '

            );
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarPagoProduccionModalidadTramTipoReFueFI(/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarPagoProduccionModalidadfuefi($centroProduccion, $fechaDesde, $fechaHasta, $estado, $fuefin, $modalidad)
    {
        try {
            $pago = DB::select('SELECT po.codpago as codigopago,po.modalidad as modalidad,pro.nombre  as nombresede, null as nombrefacultad,
                            null  as  nombreescuela, po.fecha as fechapago, tr.nombre as nombretramite,tr.clasificador as clasi,tr.fuentefinanc as fuentefinanc,tr.tiporecurso as tiporecurso, st.nombre as nombresubtramite,
                            st.precio as precio,po.detalle as pagodetalle
                             FROM pago as po
                            LEFT JOIN persona per ON (po.idpersona = per.codPersona)
                            LEFT JOIN alumno al ON (per.codPersona = al.idPersona)
                            LEFT JOIN personal ps ON (ps.idpersonal=po.copersonal)
                            LEFT JOIN persona pl ON (ps.idpersona=pl.codPersona)
                            LEFT JOIN subtramite st ON (po.idSubtramite =st.codSubtramite)
                            LEFT JOIN tramite tr ON (st.idTramite=tr.codTramite) 
                            LEFT JOIN produccionalumno pa ON (pa.codProduccionAlumno = po.idProduccionAlumno)
                            LEFT JOIN produccion pro ON (pro.codProduccion =  pa.idProduccion)
                             where idProduccionAlumno is not null and po.estado = ' . $estado . '   and tr.fuentefinanc=\'' . $fuefin . '\' and po.modalidad = \'' . $modalidad . '\'    and pro.nombre = \'' . $centroProduccion . '\' and  date(po.fecha) between \'' . $fechaDesde . '\'  and  \'' . $fechaHasta . '\' '

            );
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarPagoProduccionModalidadfuefi/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarPagoProduccionModalidadTipre($centroProduccion, $fechaDesde, $fechaHasta, $estado, $tipoRe, $modalidad)
    {
        try {
            $pago = DB::select('SELECT po.codpago as codigopago,po.modalidad as modalidad,pro.nombre  as nombresede, null as nombrefacultad,
                            null  as  nombreescuela, po.fecha as fechapago, tr.nombre as nombretramite,tr.clasificador as clasi,tr.fuentefinanc as fuentefinanc,tr.tiporecurso as tiporecurso, st.nombre as nombresubtramite,
                            st.precio as precio,po.detalle as pagodetalle
                             FROM pago as po
                            LEFT JOIN persona per ON (po.idpersona = per.codPersona)
                            LEFT JOIN alumno al ON (per.codPersona = al.idPersona)
                            LEFT JOIN personal ps ON (ps.idpersonal=po.copersonal)
                            LEFT JOIN persona pl ON (ps.idpersona=pl.codPersona)
                            LEFT JOIN subtramite st ON (po.idSubtramite =st.codSubtramite)
                            LEFT JOIN tramite tr ON (st.idTramite=tr.codTramite) 
                            LEFT JOIN produccionalumno pa ON (pa.codProduccionAlumno = po.idProduccionAlumno)
                            LEFT JOIN produccion pro ON (pro.codProduccion =  pa.idProduccion)
                             where idProduccionAlumno is not null and po.estado = ' . $estado . '   and tr.tipoRecurso=\'' . $tipoRe . '\' and po.modalidad = \'' . $modalidad . '\'    and pro.nombre = \'' . $centroProduccion . '\' and  date(po.fecha) between \'' . $fechaDesde . '\'  and  \'' . $fechaHasta . '\' '

            );
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarPagoProduccionModalidadTipre/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarPagoProduccionModalidadTramite($centroProduccion, $fechaDesde, $fechaHasta, $estado, $tram, $valtra, $modalidad)
    {
        try {
            $pago = DB::select('SELECT po.codpago as codigopago,po.modalidad as modalidad,pro.nombre  as nombresede, null as nombrefacultad,
                            null  as  nombreescuela, po.fecha as fechapago, tr.nombre as nombretramite,tr.clasificador as clasi,tr.fuentefinanc as fuentefinanc,tr.tiporecurso as tiporecurso, st.nombre as nombresubtramite,
                            st.precio as precio,po.detalle as pagodetalle
                             FROM pago as po
                            LEFT JOIN persona per ON (po.idpersona = per.codPersona)
                            LEFT JOIN alumno al ON (per.codPersona = al.idPersona)
                            LEFT JOIN personal ps ON (ps.idpersonal=po.copersonal)
                            LEFT JOIN persona pl ON (ps.idpersona=pl.codPersona)
                            LEFT JOIN subtramite st ON (po.idSubtramite =st.codSubtramite)
                            LEFT JOIN tramite tr ON (st.idTramite=tr.codTramite) 
                            LEFT JOIN produccionalumno pa ON (pa.codProduccionAlumno = po.idProduccionAlumno)
                            LEFT JOIN produccion pro ON (pro.codProduccion =  pa.idProduccion)
                             where idProduccionAlumno is not null and po.estado = ' . $estado . '  and po.modalidad = \'' . $modalidad . '\'   and ' . $tram . '= \'' . $valtra . '\'  and pro.nombre = \'' . $centroProduccion . '\' and  date(po.fecha) between \'' . $fechaDesde . '\'  and  \'' . $fechaHasta . '\' '

            );
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarPagoProduccionModalidadTramite/pagomodel');
            return null;
        }
        return $pago;
    }


    public function listarPagoProduccionFueFi($centroProduccion, $fechaDesde, $fechaHasta, $estado, $fuefin)
    {
        try {
            $pago = DB::select('SELECT po.codpago as codigopago,po.modalidad as modalidad,pro.nombre  as nombresede, null as nombrefacultad,
                            null  as  nombreescuela, po.fecha as fechapago, tr.nombre as nombretramite,tr.clasificador as clasi,tr.fuentefinanc as fuentefinanc,tr.tiporecurso as tiporecurso, st.nombre as nombresubtramite,
                            st.precio as precio,po.detalle as pagodetalle
                             FROM pago as po
                            LEFT JOIN persona per ON (po.idpersona = per.codPersona)
                            LEFT JOIN alumno al ON (per.codPersona = al.idPersona)
                            LEFT JOIN personal ps ON (ps.idpersonal=po.copersonal)
                            LEFT JOIN persona pl ON (ps.idpersona=pl.codPersona)
                            LEFT JOIN subtramite st ON (po.idSubtramite =st.codSubtramite)
                            LEFT JOIN tramite tr ON (st.idTramite=tr.codTramite) 
                            LEFT JOIN produccionalumno pa ON (pa.codProduccionAlumno = po.idProduccionAlumno)
                            LEFT JOIN produccion pro ON (pro.codProduccion =  pa.idProduccion)
                             where idProduccionAlumno is not null and po.estado = ' . $estado . '    and tr.fuentefinanc=\'' . $fuefin . '\'   and pro.nombre = \'' . $centroProduccion . '\' and  date(po.fecha) between \'' . $fechaDesde . '\'  and  \'' . $fechaHasta . '\' '

            );
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarPagoProduccionFueFi/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarPagoProduccionTipRe($centroProduccion, $fechaDesde, $fechaHasta, $estado, $tipoRe)
    {
        try {
            $pago = DB::select('SELECT po.codpago as codigopago,po.modalidad as modalidad,pro.nombre  as nombresede, null as nombrefacultad,
                            null  as  nombreescuela, po.fecha as fechapago, tr.nombre as nombretramite,tr.clasificador as clasi,tr.fuentefinanc as fuentefinanc,tr.tiporecurso as tiporecurso, st.nombre as nombresubtramite,
                            st.precio as precio,po.detalle as pagodetalle
                             FROM pago as po
                            LEFT JOIN persona per ON (po.idpersona = per.codPersona)
                            LEFT JOIN alumno al ON (per.codPersona = al.idPersona)
                            LEFT JOIN personal ps ON (ps.idpersonal=po.copersonal)
                            LEFT JOIN persona pl ON (ps.idpersona=pl.codPersona)
                            LEFT JOIN subtramite st ON (po.idSubtramite =st.codSubtramite)
                            LEFT JOIN tramite tr ON (st.idTramite=tr.codTramite) 
                            LEFT JOIN produccionalumno pa ON (pa.codProduccionAlumno = po.idProduccionAlumno)
                            LEFT JOIN produccion pro ON (pro.codProduccion =  pa.idProduccion)
                             where idProduccionAlumno is not null  and po.estado = ' . $estado . '    and tr.tipoRecurso=\'' . $tipoRe . '\'  and pro.nombre = \'' . $centroProduccion . '\' and  date(po.fecha) between \'' . $fechaDesde . '\'  and  \'' . $fechaHasta . '\' '

            );
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarPagoProduccionTipRe/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarPagoProduccionTramite($centroProduccion, $fechaDesde, $fechaHasta, $estado, $tram, $valtra)
    {
        try {
            $pago = DB::select('SELECT po.codpago as codigopago,po.modalidad as modalidad,pro.nombre  as nombresede, null as nombrefacultad,
                            null  as  nombreescuela, po.fecha as fechapago, tr.nombre as nombretramite,tr.clasificador as clasi,tr.fuentefinanc as fuentefinanc,tr.tiporecurso as tiporecurso, st.nombre as nombresubtramite,
                            st.precio as precio,po.detalle as pagodetalle
                             FROM pago as po
                            LEFT JOIN persona per ON (po.idpersona = per.codPersona)
                            LEFT JOIN alumno al ON (per.codPersona = al.idPersona)
                            LEFT JOIN personal ps ON (ps.idpersonal=po.copersonal)
                            LEFT JOIN persona pl ON (ps.idpersona=pl.codPersona)
                            LEFT JOIN subtramite st ON (po.idSubtramite =st.codSubtramite)
                            LEFT JOIN tramite tr ON (st.idTramite=tr.codTramite) 
                            LEFT JOIN produccionalumno pa ON (pa.codProduccionAlumno = po.idProduccionAlumno)
                            LEFT JOIN produccion pro ON (pro.codProduccion =  pa.idProduccion)
                             where idProduccionAlumno is not null and po.estado = ' . $estado . '   and ' . $tram . '= \'' . $valtra . '\' and pro.nombre = \'' . $centroProduccion . '\' and  date(po.fecha) between \'' . $fechaDesde . '\'  and  \'' . $fechaHasta . '\' '

            );
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarPagoProduccionTramite/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarPagoProduccionmodalidad($centroProduccion, $fechaDesde, $fechaHasta, $estado, $modalidad)
    {
        try {
            $pago = DB::select('SELECT po.codpago as codigopago,po.modalidad as modalidad,pro.nombre  as nombresede, null as nombrefacultad,
                            null  as  nombreescuela, po.fecha as fechapago, tr.nombre as nombretramite,tr.clasificador as clasi,tr.fuentefinanc as fuentefinanc,tr.tiporecurso as tiporecurso, st.nombre as nombresubtramite,
                            st.precio as precio,po.detalle as pagodetalle
                             FROM pago as po
                            LEFT JOIN persona per ON (po.idpersona = per.codPersona)
                            LEFT JOIN alumno al ON (per.codPersona = al.idPersona)
                            LEFT JOIN personal ps ON (ps.idpersonal=po.copersonal)
                            LEFT JOIN persona pl ON (ps.idpersona=pl.codPersona)
                            LEFT JOIN subtramite st ON (po.idSubtramite =st.codSubtramite)
                            LEFT JOIN tramite tr ON (st.idTramite=tr.codTramite) 
                            LEFT JOIN produccionalumno pa ON (pa.codProduccionAlumno = po.idProduccionAlumno)
                            LEFT JOIN produccion pro ON (pro.codProduccion =  pa.idProduccion)
                             where idProduccionAlumno is not null and po.estado = ' . $estado . ' and po.modalidad = \'' . $modalidad . '\'  and pro.nombre = \'' . $centroProduccion . '\' and  date(po.fecha) between \'' . $fechaDesde . '\'  and  \'' . $fechaHasta . '\' '

            );
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarPagoProduccionmodalidad/pagomodel');
            return null;
        }
        return $pago;

    }

    public function listarPagoProduccionTodo($centroProduccion, $fechaDesde, $fechaHasta, $estado)
    {
        try {
            $pago = DB::select('SELECT po.codpago as codigopago,po.modalidad as modalidad,pro.nombre  as nombresede, null as nombrefacultad,
                            null  as  nombreescuela, po.fecha as fechapago, tr.nombre as nombretramite,tr.clasificador as clasi,tr.fuentefinanc as fuentefinanc,tr.tiporecurso as tiporecurso, st.nombre as nombresubtramite,
                            st.precio as precio,po.detalle as pagodetalle
                             FROM pago as po
                            LEFT JOIN persona per ON (po.idpersona = per.codPersona)
                            LEFT JOIN alumno al ON (per.codPersona = al.idPersona)
                            LEFT JOIN personal ps ON (ps.idpersonal=po.copersonal)
                            LEFT JOIN persona pl ON (ps.idpersona=pl.codPersona)
                            LEFT JOIN subtramite st ON (po.idSubtramite =st.codSubtramite)
                            LEFT JOIN tramite tr ON (st.idTramite=tr.codTramite) 
                            LEFT JOIN produccionalumno pa ON (pa.codProduccionAlumno = po.idProduccionAlumno)
                            LEFT JOIN produccion pro ON (pro.codProduccion =  pa.idProduccion)
                             where idProduccionAlumno is not null and po.estado = ' . $estado . ' and pro.nombre = \'' . $centroProduccion . '\' and  date(po.fecha) between \'' . $fechaDesde . '\'  and  \'' . $fechaHasta . '\' '

            );
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarPagoProduccionTodo/pagomodel');
            return null;
        }
        return $pago;
    }

    /************** listar pagos centros de produccion ***************/


    /***** listar pagos centros universidad*****/
    public function listarFueTipLo($estado, $fechaDesde, $fechaHasta, $tipoRe, $local, $vallocal)
    {
        try {
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
                            WHERE  po.estado=' . $estado . '  and idProduccionAlumno is null and   date(po.fecha)  BETWEEN  \'' . $fechaDesde . '\' and \'' . $fechaHasta . '\' 
                             and ' . $local . '=\'' . $vallocal . '\'
                             and tr.tipoRecurso=\'' . $tipoRe . '\' ');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarFueTipLo/pagomodel');
            return null;
        }
        return $pago;

    }

    public function listarTodo($estado, $fechaDesde, $fechaHasta, $modalidad, $tipre, $fuefi, $local, $valloc, $tram, $valtra)
    {
        try {
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
                            WHERE  po.estado=' . $estado . '  and idProduccionAlumno is null and po.modalidad = \'' . $modalidad . '\' and date(po.fecha)  BETWEEN  \'' . $fechaDesde . '\' and \'' . $fechaHasta . '\'  
                             and ' . $local . '=\'' . $valloc . '\' and tr.fuentefinanc=\'' . $fuefi . '\'
                             and tr.tipoRecurso=\'' . $tipre . '\' and ' . $tram . '= \'' . $valtra . '\'');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarTodo/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarMoTiLo($estado, $fechaDesde, $fechaHasta, $modalidad, $tipre, $local, $valloc)
    {
        try {
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
                            WHERE  po.estado=' . $estado . '  and idProduccionAlumno is null and po.modalidad = \'' . $modalidad . '\' and date(po.fecha)  BETWEEN  \'' . $fechaDesde . '\' and \'' . $fechaHasta . '\'  
                             and ' . $local . '=\'' . $valloc . '\' 
                             and tr.tipoRecurso=\'' . $tipre . '\' ');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarMoTiLo/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarFueLo($estado, $fechaDesde, $fechaHasta, $fue, $local, $valloc)
    {
        try {
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
                            WHERE  po.estado=' . $estado . ' and idProduccionAlumno is null  and date(po.fecha)  BETWEEN  \'' . $fechaDesde . '\' and \'' . $fechaHasta . '\' 
                             and ' . $local . '=\'' . $valloc . '\' and tr.fuentefinanc=\'' . $fue . '\'
                            ');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarFueLo/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarTraLo($estado, $fechaDesde, $fechaHasta, $tram, $valtra, $local, $valloc)
    {
        try {
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
                            WHERE  po.estado=' . $estado . ' and idProduccionAlumno is null   and date(po.fecha)  BETWEEN  \'' . $fechaDesde . '\' and \'' . $fechaHasta . '\' 
                             and ' . $local . '=\'' . $valloc . '\' and ' . $tram . '= \'' . $valtra . '\'');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarTraLo/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarLoc($estado, $fechaDesde, $fechaHasta, $local, $valloc)
    {
        try {
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
                            WHERE  po.estado=' . $estado . ' and idProduccionAlumno is null  and date(po.fecha)  BETWEEN  \'' . $fechaDesde . '\' and \'' . $fechaHasta . '\' 
                             and ' . $local . '=\'' . $valloc . '\'');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarLoc/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarMoTraFu($estado, $fechaDesde, $fechaHasta, $modalidad, $tram, $valtra, $fuen)
    {
        try {
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
                            WHERE  po.estado=' . $estado . '  and idProduccionAlumno is null and po.modalidad = \'' . $modalidad . '\' and date(po.fecha)  BETWEEN  \'' . $fechaDesde . '\' and \'' . $fechaHasta . '\'   
                             and tr.fuentefinanc=\'' . $fuen . '\'and ' . $tram . '= \'' . $valtra . '\'');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarMoTraFu/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarTraFu($estado, $fechaDesde, $fechaHasta, $tram, $valtra, $fuen)
    {
        try {
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
                            WHERE  po.estado=' . $estado . '  and idProduccionAlumno is null  and date(po.fecha)  BETWEEN  \'' . $fechaDesde . '\' and \'' . $fechaHasta . '\'  
                             and tr.fuentefinanc=\'' . $fuen . '\'and ' . $tram . '= \'' . $valtra . '\'');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarTraFu/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarMoFu($estado, $fechaDesde, $fechaHasta, $modalidad, $fuen)
    {
        try {
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
                            WHERE  po.estado=' . $estado . '  and idProduccionAlumno is null and date(po.fecha)  BETWEEN  \'' . $fechaDesde . '\' and \'' . $fechaHasta . '\' 
                            and tr.fuentefinanc=\'' . $fuen . '\'');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarMoFu/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarFu($estado, $fechaDesde, $fechaHasta, $fuen)
    {
        try {
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
                            WHERE  po.estado=' . $estado . '  and idProduccionAlumno is null and date(po.fecha)  BETWEEN  \'' . $fechaDesde . '\' and \'' . $fechaHasta . '\' 
                              and tr.fuentefinanc=\'' . $fuen . '\'');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarFu/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarMoTraTiLo($estado, $fechaDesde, $fechaHasta, $tipore, $modalidad, $tram, $valtra, $local, $valloc)
    {
        try {
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
                            WHERE  po.estado=' . $estado . '  and idProduccionAlumno is null and po.modalidad = \'' . $modalidad . '\' and date(po.fecha)  BETWEEN  \'' . $fechaDesde . '\' and \'' . $fechaHasta . '\'  
                             and ' . $local . '=\'' . $valloc . '\' 
                             and tr.tipoRecurso=\'' . $tipore . '\' and ' . $tram . '= \'' . $valtra . '\'');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarMoTraTiLo/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarMoTraFuTi($estado, $fechaDesde, $fechaHasta, $tipore, $modalidad, $fuefi, $tram, $valtra)
    {
        try {
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
                            WHERE  po.estado=' . $estado . '  and idProduccionAlumno is null and po.modalidad = \'' . $modalidad . '\' and date(po.fecha)  BETWEEN  \'' . $fechaDesde . '\' and \'' . $fechaHasta . '\'    and tr.fuentefinanc=\'' . $fuefi . '\'
                             and tr.tipoRecurso=\'' . $tipore . '\' and ' . $tram . '= \'' . $valtra . '\'');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarMoTraFuTi/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarMoFueTipFu($estado, $fechaDesde, $fechaHasta, $tipore, $modalidad, $fuefi)
    {
        try {
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
                            WHERE  po.estado=' . $estado . '  and idProduccionAlumno is null and po.modalidad = \'' . $modalidad . '\' and date(po.fecha)  BETWEEN  \'' . $fechaDesde . '\' and \'' . $fechaHasta . '\'  and tr.fuentefinanc=\'' . $fuefi . '\'
                             and tr.tipoRecurso=\'' . $tipore . '\' ');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarMoFueTipFu/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarTip($estado, $fechaDesde, $fechaHasta, $tipore, $modalidad, $tram, $valTram)
    {
        try {
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
                            WHERE  po.estado=' . $estado . '  and idProduccionAlumno is null and po.modalidad = \'' . $modalidad . '\' and date(po.fecha)  BETWEEN  \'' . $fechaDesde . '\' and \'' . $fechaHasta . '\'   
                             and tr.tipoRecurso=\'' . $tipore . '\' and ' . $tram . '= \'' . $valTram . '\'');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarTip/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarTipLo($estado, $fechaDesde, $fechaHasta, $tipore, $local, $valloc)
    {
        try {
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
                            WHERE  po.estado=' . $estado . '  and idProduccionAlumno is null and date(po.fecha)  BETWEEN  \'' . $fechaDesde . '\' and \'' . $fechaHasta . '\'  
                             and ' . $local . '=\'' . $valloc . '\' 
                             and tr.tipoRecurso=\'' . $tipore . '\'');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarTipLo/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarFueTip($estado, $fechaDesde, $fechaHasta, $tipRe, $fuefi)
    {
        try {
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
                            WHERE  po.estado=' . $estado . '  and idProduccionAlumno is null and date(po.fecha)  BETWEEN  \'' . $fechaDesde . '\' and \'' . $fechaHasta . '\' 
                             and tr.fuentefinanc=\'' . $fuefi . '\'
                             and tr.tipoRecurso=\'' . $tipRe . '\' ');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarFueTip/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarTraTip($estado, $fechaDesde, $fechaHasta, $tram, $valtra, $tipRe)
    {
        try {
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
                            WHERE  po.estado=' . $estado . '  and idProduccionAlumno is null and date(po.fecha)  BETWEEN  \'' . $fechaDesde . '\' and \'' . $fechaHasta . '\' 
                             and tr.tipoRecurso=\'' . $tipRe . '\' and ' . $tram . '= \'' . $valtra . '\'');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarTraTip/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarTipoRe($estado, $fechaDesde, $fechaHasta, $tipRe)
    {
        try {
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
                            WHERE  po.estado=' . $estado . '  and idProduccionAlumno is null and date(po.fecha)  BETWEEN  \'' . $fechaDesde . '\' and \'' . $fechaHasta . '\'   
                             and tr.tipoRecurso=\'' . $tipRe . '\'');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarTipoRe/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarMoTrFuLo($estado, $fechaDesde, $fechaHasta, $tram, $valtra, $fuefi, $local, $valLoc)
    {
        try {
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
                            WHERE  po.estado=' . $estado . '   and idProduccionAlumno is null and date(po.fecha)  BETWEEN  \'' . $fechaDesde . '\' and \'' . $fechaHasta . '\'  
                             and ' . $local . '=\'' . $valLoc . '\' and tr.fuentefinanc=\'' . $fuefi . '\' and ' . $tram . '= \'' . $valtra . '\'');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarMoTrFuLo/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarTr($estado, $fechaDesde, $fechaHasta, $tram, $valtra)
    {
        try {
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
                            WHERE  po.estado=' . $estado . '  and idProduccionAlumno is null and date(po.fecha)  BETWEEN  \'' . $fechaDesde . '\' and \'' . $fechaHasta . '\'  
                             and ' . $tram . '= \'' . $valtra . '\'');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarTr/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarMoFuLo($estado, $modalidad, $fechaDesde, $fechaHasta, $fuefi, $local, $valLoc)
    {
        try {
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
                            WHERE  po.estado=' . $estado . '  and idProduccionAlumno is null and po.modalidad = \'' . $modalidad . '\'and date(po.fecha)  BETWEEN  \'' . $fechaDesde . '\' and \'' . $fechaHasta . '\'  
                             and ' . $local . '=\'' . $valLoc . '\' and tr.fuentefinanc=\'' . $fuefi . '\'');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarMoFuLo/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarMoLo($estado, $modalidad, $fechaDesde, $fechaHasta, $local, $valLoc)
    {
        try {
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
                            WHERE  po.estado=' . $estado . '  and idProduccionAlumno is null and po.modalidad = \'' . $modalidad . '\' and date(po.fecha)  BETWEEN  \'' . $fechaDesde . '\' and \'' . $fechaHasta . '\' 
                             and ' . $local . '=\'' . $valLoc . '\'');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarMoLo/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarMoTiFuLo($estado, $modalidad, $fechaDesde, $fechaHasta, $tipRe, $fuenteFin, $local, $valLoc)
    {
        try {
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
                            WHERE  po.estado=' . $estado . ' and idProduccionAlumno is null and po.modalidad = \'' . $modalidad . '\' and date(po.fecha)  BETWEEN  \'' . $fechaDesde . '\' and \'' . $fechaHasta . '\'  
                             and ' . $local . '=\'' . $valLoc . '\' and tr.fuentefinanc=\'' . $fuenteFin . '\'
                             and tr.tipoRecurso=\'' . $tipRe . '\'');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarMoTiFuLo/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarModTip($estado, $modalidad, $fechaDesde, $fechaHasta, $tipRe)
    {
        try {
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
                            WHERE  po.estado=' . $estado . '  and idProduccionAlumno is null and po.modalidad = \'' . $modalidad . '\' and date(po.fecha)  BETWEEN  \'' . $fechaDesde . '\' and \'' . $fechaHasta . '\' 
                             and tr.tipoRecurso=\'' . $tipRe . '\'');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarModTip/pagomodel');
            return null;
        }

        return $pago;
    }

    public function listarTramModLoc($estado, $modalidad, $tramite, $tramiteVal, $fechaDesde, $fechaHasta, $local, $valLoc)
    {
        try {
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
                            WHERE po.estado=' . $estado . '  and idProduccionAlumno is null and date(po.fecha)  BETWEEN  \'' . $fechaDesde . '\' and \'' . $fechaHasta . '\'   and ' . $tramite . '= \'' . $tramiteVal . '\'
                             and ' . $local . '=\'' . $valLoc . '\'
                              and po.modalidad = \'' . $modalidad . '\'');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarTramModLoc/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarModTram($estado, $modalidad, $tramite, $tramiteVal, $fechaDesde, $fechaHasta)
    {
        try {
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
                            WHERE po.estado= \'' . $estado . '\' and idProduccionAlumno is null and date(po.fecha)  BETWEEN  \'' . $fechaDesde . '\' and \'' . $fechaHasta . '\'  and ' . $tramite . '= \'' . $tramiteVal . '\'
                              and po.modalidad = \'' . $modalidad . '\'');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarModTram/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarPagoModalidad($estado, $modalidad, $fechaDesde, $fechaHasta)
    {
        try {
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
                            WHERE po.estado=' . $estado . '  and idProduccionAlumno is null and  date(po.fecha)  BETWEEN  \'' . $fechaDesde . '\' and \'' . $fechaHasta . '\'   and po.modalidad = \'' . $modalidad . '\'');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarPagoModalidad/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarPagoNada($estado, $fechaDesde, $fechaHasta)
    {
        try {
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
                            WHERE po.estado=' . $estado . '  and idProduccionAlumno is null and date(po.fecha)  BETWEEN  \'' . $fechaDesde . '\' and \'' . $fechaHasta . '\'   ');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarPagoNada/pagomodel');
            return null;
        }
        return $pago;
    }

    public function listarPagosPersonal($codPersonal)
    {
        try {
            date_default_timezone_set('America/Lima');
            $date = date('Y-m-d');
            $pago = DB::select('SELECT tr.clasificador as clasificadorsiaf, tr.nombre as nombreTramite,st.codigoSubtramite as codigoSubtramite, st.nombre,sum((cantidad*precio)) as precio, count(po.codPago) as nurPagos
                            FROM unt.tramite as tr
                            LEFT JOIN unt.subtramite st ON (tr.codTramite = st.idTramite)
                            LEFT JOIN unt.pago po ON (st.codSubtramite=po.idSubtramite )
                            LEFT JOIN unt.personal pl ON (pl.idPersonal=po.coPersonal )
                            where po.fecha like "%' . $date . '%"  and idProduccionAlumno is null and pl.codPersonal="' . $codPersonal . '"
                            group by (st.codSubtramite) order by (tr.nombre)');
        } catch (PDOException $e) {
            $util = new util();
            $util->insertarError($e->getMessage(), 'listarPagosPersonal/pagomodel');
            return null;
        }
        return $pago;
    }
}