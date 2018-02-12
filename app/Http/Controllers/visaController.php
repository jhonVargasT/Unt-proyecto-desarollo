<?php

namespace App\Http\Controllers;

use App\alumnomodel;
use App\clientemodel;
use App\pagomodel;
use App\personamodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class visaController extends Controller
{
    public function registrarPago($idperona, $idtasa, $detalle, $cantidad)
    {
        date_default_timezone_set('America/Lima');
        $dato = date('Y-m-d H:i:s');
        $p = new pagomodel();
        $p->setModalidad('online');
        $p->setCantidad($cantidad);
        $p->setDetalle($detalle);
        $p->setFecha($dato);
        $p->setIdPersona($idperona);
        $id = $this->idSubtramite($idtasa);
        $p->setIdSubtramite($id);
        $cont = $this->contadorSubtramite($idtasa);
        $contaux = $cont + 1;
        $valid = $p->savePagoOnline($contaux);//SQL, insersion del pago
        return $valid;
    }

    public function contadorSubtramite($idtasa)
    {
        $cont = null;
        $contador = DB::select('select contador from subtramite where codSubtramite=:codSubtramite and estado=1', ['codSubtramite' => $idtasa]);
        foreach ($contador as $c) {
            $cont = $c->contador;
        }
        return $cont;
    }

    public function idSubtramite($codigoSubtramite)
    {
        $id = null;
        $cons = DB::select('select codSubtramite from subtramite where codigoSubtramite=:codigoSubtramite and estado=1', ['codigoSubtramite' => $codigoSubtramite]);
        foreach ($cons as $c) {
            $id = $c->codSubtramite;
        }
        return $id;
    }

    public function tokenVisa(Request $request)
    {
        if (isset($request->total)) {
            $sessionToken = $this->getGUID();
            $merchantid = '137254211';
            $accessKey = 'AKIAIKABOKKCTPS2LVSA';
            $secretAccessKey = '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';
            $amount = $request->total;
            $sessionKey = $this->create_token($amount, "dev", $merchantid, $accessKey, $secretAccessKey, $sessionToken);
            $this->guarda_sessionKey($sessionKey);
            $this->guarda_sessionToken($sessionToken);
            $form = $this->boton($sessionToken, $merchantid, $amount, $request->nombres, $request->apellidos, $request->select, $request->text, $request->idt, $request->detalle, $request->multiplicador);
            return view('Ventanilla/Culqi/visa')->with(['form' => $form, 'nombres' => $request->nombres, 'pagar' => $request->pagar,
                'apellidos' => $request->apellidos, 'select' => $request->select, 'text' => $request->text, 'escuela' => $request->escuela,
                'facultad' => $request->facultad, 'selectt' => $request->selectt, 'txtsub' => $request->txtsub, 'subtramite' => $request->subtramite,
                'detalle' => $request->detalle, 'boletapagar' => $request->boletapagar, 'total' => $request->total, 'id' => $request->idt, 'multiplicador' => $request->multiplicador]);
        } elseif (isset($request->total) == 0 || isset($request->total) == '') {
            return view('Ventanilla/Culqi/visa');
        }
    }

    public function buscarPersona($select, $text)
    {
        $pers = new personamodel();
        $cli = new clientemodel();
        $al = new alumnomodel();
        $codper = null;

        if ($select == 'Dni') {
            $codper = $pers->obtnerIdDni($text);//SQL, obtener datos de la persona por su dni
        } elseif ($select == 'Ruc') {
            $codper = $cli->consultarClienteRUC($text);//SQL, obtener datos del cliente por su ruc
        } elseif ($select == 'Codigo de alumno') {
            $codper = $al->consultaridPersonaAlumno($text);//SQL, obtener datos del alumno por su codigo de alumno
        }
        return $codper;
    }

    public function boton($sessionToken, $merchantid, $amount, $nombres, $apellidos, $select, $text, $idt, $detalle, $cantidad)
    {
        $numorden = $this->contador();
        $idPer = $this->buscarPersona($select, $text);
        if ($detalle) {
            $formulario = "
        <form action=\"/transactionD/$idPer/$idt/$detalle/$cantidad\" method='post'>
            <script src=\"https://static-content.vnforapps.com/v1/js/checkout.js?qa=true\"
                data-sessiontoken=\"$sessionToken\"
                data-merchantid=\"$merchantid\"
                data-buttonsize=\"large\"
                data-buttoncolor=\"\" 
                data-merchantlogo =\"http://www.unt.edu.pe/img/logo.png\"
                data-merchantname=\"\"
                data-formbuttoncolor=\"#0A0A2A\"
                data-showamount=\"\"
                data-purchasenumber=\"$numorden\"
                data-amount=\"$amount\"
                data-cardholdername=\"$nombres\"
                data-cardholderlastname=\"$apellidos\"
                data-cardholderemail=\"\"
                data-usertoken=\"\"
                data-recurrence=\"false\"
                data-frequency=\"Quarterly\"
                data-recurrencetype=\"fixed\"
                data-recurrenceamount=\"200\"
                data-documenttype=\"\"
                data-documentid=\"\"
                data-beneficiaryid=\"\"
                data-productid=\"\"
                data-phone=\"\"
            /></script>
        </form>";
            return $formulario;
        } else {
            $formulario = "
        <form action=\"/transaction/$idPer/$idt/$cantidad\" method='post'>
            <script src=\"https://static-content.vnforapps.com/v1/js/checkout.js?qa=true\"
                data-sessiontoken=\"$sessionToken\"
                data-merchantid=\"$merchantid\"
                data-buttonsize=\"large\"
                data-buttoncolor=\"\" 
                data-merchantlogo =\"http://www.unt.edu.pe/img/logo.png\"
                data-merchantname=\"\"
                data-formbuttoncolor=\"#0A0A2A\"
                data-showamount=\"\"
                data-purchasenumber=\"$numorden\"
                data-amount=\"$amount\"
                data-cardholdername=\"$nombres\"
                data-cardholderlastname=\"$apellidos\"
                data-cardholderemail=\"\"
                data-usertoken=\"\"
                data-recurrence=\"false\"
                data-frequency=\"Quarterly\"
                data-recurrencetype=\"fixed\"
                data-recurrenceamount=\"200\"
                data-documenttype=\"\"
                data-documentid=\"\"
                data-beneficiaryid=\"\"
                data-productid=\"\"
                data-phone=\"\"
            /></script>
        </form>";
            return $formulario;
        }
    }

    //4547751138486006 fecha 0318 cvv 740
    public function transactionD(Request $request, $idpe, $idt, $detalle, $cantidad)
    {
        if (isset($request->transactionToken)) {
            $sessionToken = $this->recupera_sessionToken();
            $transactionToken = $request->transactionToken;
            $respuesta = $this->authorization("dev", '137254211', $transactionToken, 'AKIAIKABOKKCTPS2LVSA', 'Cpe2yTzXCNGL6ZO9gqADsR9Cqmr2D+9dOpN4EgYs', $sessionToken);//return view('Ventanilla/Culqi/visa')->with(['respuesta' => $respuesta]);
            if ($respuesta['errorMessage'] == 'OK') {
                $value = $this->registrarPago($idpe, $idt, $detalle, $cantidad);
                if ($value == true) {
                    return redirect('/visa')->with('true', 'Pago realizado con exito');
                } else {
                    return redirect('/visa')->with('false', 'Pago realizado en el banco con exito, error al guardar en el sistema');
                }
            } else {
                return redirect('/visa')->with('false', 'Pago realizado sin exito');
            }
        } else {
            return redirect('/visa')->with('false', 'Visanet no responde');
        }
    }

    public function transaction(Request $request, $idpe, $idt, $cantidad)
    {
        $value = null;
        if (isset($request->transactionToken)) {
            $sessionToken = $this->recupera_sessionToken();
            $transactionToken = $request->transactionToken;
            $respuesta = $this->authorization("dev", '137254211', $transactionToken, 'AKIAIKABOKKCTPS2LVSA', 'Cpe2yTzXCNGL6ZO9gqADsR9Cqmr2D+9dOpN4EgYs', $sessionToken);//return view('Ventanilla/Culqi/visa')->with(['respuesta' => $respuesta]);
            if ($respuesta['errorMessage'] == 'OK') {
                $value = $this->registrarPago($idpe, $idt, '', $cantidad);
                if ($value == true) {
                    return redirect('/visa')->with('true', 'Pago realizado con exito');
                } else {
                    return redirect('/visa')->with('false', 'Pago realizado en el banco con exito, error al guardar en el sistema');
                }
            } else {
                return redirect('/visa')->with('false', 'Pago realizado sin exito');
            }
        } else {
            return redirect('/visa')->with('false', 'Visanet no responde');
        }
    }

    function authorization($environment, $merchantId, $transactionToken, $accessKey, $secretKey, $sessionToken)
    {
        $url = null;
        switch ($environment) {
            case 'prd':
                $url = "https://apice.vnforapps.com/api.authorization/api/v1/authorization/web/{$merchantId}";
                break;
            case 'dev':
                $url = "https://devapice.vnforapps.com/api.authorization/api/v1/authorization/web/{$merchantId}";
                break;
        }
        $header = array("Content-Type: application/json", "VisaNet-Session-Key: $sessionToken");
        $request_body = "{
        \"transactionToken\":\"$transactionToken\",
        \"sessionToken\":\"$sessionToken\"
    }";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$accessKey:$secretKey");
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($ch);
        $json = json_decode($response, true);
        return $json;
    }

    function getGUID()
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((double)microtime() * 10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = chr(123)// "{"
                . substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4) . $hyphen
                . substr($charid, 20, 12) . $hyphen
                . chr(125);// "}"
            $uuid = substr($uuid, 1, 36);
            return $uuid;
        }
    }

    function create_token($amount, $environment, $merchantId, $accessKey, $secretKey, $uuid)
    {
        $url = null;
        switch ($environment) {
            case 'prd':
                $url = "https://apice.vnforapps.com/api.ecommerce/api/v1/ecommerce/token/{$merchantId}";
                break;
            case 'dev':
                $url = "https://devapice.vnforapps.com/api.ecommerce/api/v1/ecommerce/token/{$merchantId}";
                break;
        }
        $header = array("Content-Type: application/json", "VisaNet-Session-Key: $uuid");
        $request_body = "{
        \"amount\":{$amount}
    }";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$accessKey:$secretKey");
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($ch);
        $json = json_decode($response);
        $dato = $json->sessionKey;
        return $dato;
    }

    function guarda_sessionKey($sessionKey)
    {
        $archivo = "sessionKey.txt";
        $fp = fopen($archivo, "w+");
        fwrite($fp, $sessionKey, 96);
        fclose($fp);
    }

    function guarda_sessionToken($sessionToken)
    {
        $archivo = "sessionToken.txt";
        $fp = fopen($archivo, "w+");
        fwrite($fp, $sessionToken, 96);
        fclose($fp);
    }

    function recupera_sessionToken()
    {
        $archivo = "sessionToken.txt";
        $fp = fopen($archivo, "r");
        $valor = fgets($fp, 96);
        fclose($fp);
        return $valor;
    }

    function contador()
    {
        $archivo = "contador.txt";
        $fp = fopen($archivo, "r");
        $contador = fgets($fp, 26);
        fclose($fp);
        ++$contador;
        $fp = fopen($archivo, "w+");
        fwrite($fp, $contador, 26);
        fclose($fp);
        return $contador;
    }

    function redirect()
    {
        return Redirect::to('http://www.google.com');
    }
}
