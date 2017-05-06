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
    //Registra al pago por tarjeta visa
    public function culqi(Request $request)
    {
        $cont = 0;
        $pers = new personamodel();
        $cli = new clientemodel();
        $al = new alumnomodel();
        $subt = new subtramitemodel();
        $codper = null;
        $codSubtramite = null;
        if ($request->select == 'Dni') {
            $codper = $pers->obtnerIdDni($request->buscar);//SQL, busca a la persona por su dni
        } else {
            if ($request->select == 'Ruc') {
                $codper = $cli->consultarClienteRUC($request->buscar);//SQL, busca al cliente por su ruc
            } else {
                if ($request->select == 'Codigo de alumno') {
                    $codper = $al->consultaridPersonaAlumno($request->buscar);//SQL, busca al alumno por su codigo de alumno
                }
            }
        }
        if ($request->subtramite) {
            $codSubtramite = $subt->consultarSubtramiteidNombre($request->subtramite);//SQL,Busca a la tasa por su nombre
            $cont = $this->contadorSubtramite($request->subtramite);//SQL, buscar al contador de tasa por su nombre
        } elseif ($request->text) {
            $codSubtramite = $subt->consultarSubtramiteidNombre($request->text);//SQL, o busca a la tasa por su codigo
            $cont = $this->contadorSubtramite($request->text);//SQL, o busca al contador de tasa por su codigo
        }

        date_default_timezone_set('America/Lima');
        $dato = date('Y-m-d H:i:s');
        $p = new pagomodel();
        $p->setDetalle($request->detalle);
        $p->setFecha($dato);
        $p->setModalidad('Online');
        $p->setIdPersona($codper);
        $p->setIdSubtramite($codSubtramite);
        $contaux = $cont + 1;
        try {
            // Configurar tu API Key y autenticación
            $SECRET_KEY = "sk_test_Z1aMDe3V3b7BkYIi";
            $culqi = new Culqi(array('api_key' => $SECRET_KEY));
            // Creando Cargo a una tarjeta
            $culqi->Charges->create(
                array(
                    "amount" => $request->precio,
                    "capture" => true,
                    "currency_code" => "PEN",
                    "description" => $request->st,
                    "installments" => 0,
                    "email" => $request->email,
                    "source_id" => $request->token,
                )
            );
            $var = $p->savePagoOnline($contaux);//SQL, inserta los datos del pago (envia al contador de la tasa)
            //$p->boletaVirtual($var);
            return $var;
        } catch (Exception $e) {
            return 'bad';
        }
    }

//Buscar contado por su nombre de la tasa
    public
    function contadorSubtramite($nombreSubtramite)
    {
        $cont = null;
        $contador = DB::select('select contador from subtramite where subtramite.estado=1 and subtramite.nombre="' . $nombreSubtramite . '"');

        foreach ($contador as $c) {
            $cont = $c->contador;
        }
        return $cont;
    }
}
