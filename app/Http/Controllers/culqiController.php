<?php

namespace App\Http\Controllers;

use App\alumnomodel;
use App\clientemodel;
use App\pagomodel;
use App\personamodel;
use App\subtramitemodel;
use Culqi\Culqi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class culqiController extends Controller
{
    public function culqi(Request $request)
    {
        $pers = new personamodel();
        $cli = new clientemodel();
        $al = new alumnomodel();
        $subt = new subtramitemodel();
        $codper = null;
        $codSubtramite = null;
        if ($request->select == 'Dni') {
            $codper = $pers->obtnerIdDni($request->buscar);
        } else {
            if ($request->select == 'Ruc') {
                $codper = $cli->consultarClienteRUC($request->buscar);
            } else {
                if ($request->select == 'Codigo de alumno') {
                    $codper = $al->consultaridPersonaAlumno($request->buscar);
                }
            }
        }
        $codSubtramite = $subt->consultarSubtramiteidNombre($request->subtramite);
        date_default_timezone_set('America/Lima');
        $dato = date('Y-m-d H:i:s');
        $p = new pagomodel();
        $p->setDetalle($request->detalle);
        $p->setFecha($dato);
        $p->setModalidad('Online');
        $p->setIdPersona($codper);
        $p->setIdSubtramite($codSubtramite);
        $cont = $this->contadorSubtramite($request->subtramite);
        $contaux = $cont + 1;

        $valid = $p->savePago($contaux);
        if ($valid == true) {
            try {
                // Configurar tu API Key y autenticación
                $SECRET_KEY = "sk_live_FZMiNSBwrCkfUicS";
                $culqi = new Culqi(array('api_key' => $SECRET_KEY));
                // Creando Cargo a una tarjeta

                $culqi->Charges->create(
                    array(
                        "amount" => $request->precio,
                        "capture" => true,
                        "currency_code" => "PEN",
                        "description" => $request->st,
                        "installments" => 0,
                        "email" => "test@culqi.com",
                        "metadata" => array("test" => "test"),
                        "source_id" => $request->token,
                    )
                );
                // Respuesta
                return 'ok';
            } catch (Exception $e) {
                return 'bad';
            }
        } else {
            return false;
        }
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
