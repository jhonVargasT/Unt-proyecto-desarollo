<?php

namespace App\Http\Controllers;

use App\pagomodel;
use App\personamodel;
use App\subtramitemodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function reportePago($txt, $select, $val)
    {
        Excel::create('Laravel Excel', function ($excel) use ($txt, $select, $val) {
            $excel->sheet('Productos', function ($sheet) use ($txt, $select, $val) {
                $data = null;
                $pag = null;
                $pago = new pagomodel();
                if ($select == 'Dni') {
                    $pag = $pago->consultarAlumnoDNI($txt, $val);
                } else {
                    if ($select == 'Codigo alumno') {
                        $pag = $pago->consultarAlumnoCodigo($txt, $val);
                    } else {
                        if ($select == 'Ruc') {
                            $pag = $pago->consultarClienteRuc($txt, $val);
                        } else {
                            if ($select == 'Codigo pago') {
                                $pag = $pago->consultarCodigoPago($txt, $val);
                            } else {
                                if ($select == 'Codigo personal') {
                                    $pag = $pago->consultarCodigoPersonal($txt);
                                } else {
                                    $pag = $pago->consultarPagos($val);
                                }
                            }
                        }
                    }
                }
                foreach ($pag as $p) {
                    $data[] = array(
                        "Codigo Pago" => $p->codPago,
                        "Dni" => $p->p1dni,
                        "Nombres" => $p->p1nombres,
                        "Apellidos" => $p->p1apellidos,
                        "Subtramite" => $p->nombre,
                        "Fecha de Pago" => $p->pfecha,
                        "Monto" => $p->precio,
                        "Modalidad" => $p->modalidad,
                        "Detalle" => $p->detalle,
                        "Cajero Nombres" => $p->pnombres,
                        "Cajero Apellidos" => $p->papellidos,
                    );
                }
                $sheet->FromArray($data);
            });
        })->export('xls');
    }

    public function importExcel(Request $request)
    {
        $val = null;
        $contaux = null;
        $persona = new personamodel();
        $subtramite = new subtramitemodel();
        $pago = new pagomodel();
        if ($request->hasFile('import_file')) {
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function ($reader) {
            })->get();
            if (!empty($data) && $data->count()) {
                foreach ($data->toArray() as $key => $value) {
                    if (!empty($value)) {
                        foreach ($value as $v) {
                            $codPer = $persona->obtnerId($v['dni']);
                            $codSubt = $subtramite->consultarId($v['tasa']);
                            $cont = $this->contadorSubtramite($v['tasa']);
                            $contaux = $cont + 1;
                            $pago->setDetalle($v['detalle']);
                            $date = implode("-", array_reverse(explode("/", $v['fecha'])));
                            $pago->setFecha($date);
                            $pago->setModalidad('Banco');
                            $pago->setIdPersona($codPer);
                            $pago->setIdSubtramite($codSubt);
                        }
                        $val = $pago->saveExcel($contaux);
                        if ($val == true) {
                            return back()->with('true', 'Guardada con exito')->withInput();
                        } else {
                            return back()->with('false', 'No guardada');
                        }
                    }
                }
            }
        }
        return back()->with('error', 'Please Check your file, Something is wrong there.');
    }

    public function contadorSubtramite($nombreSubtramite)
    {
        $cont = null;
        $contador = DB::select('select contador from subtramite where subtramite.estado=1 and subtramite.nombre="' . $nombreSubtramite . '"');

        foreach ($contador as $c) {
            $cont = $c->contador;
        }
        return $cont;
    }
}
