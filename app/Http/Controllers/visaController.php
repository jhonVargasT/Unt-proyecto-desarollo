<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class visaController extends Controller
{
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
            $form = $this->boton($sessionToken, $merchantid, $amount, $request->nombres, $request->apellidos);
            return view('Ventanilla/Culqi/visa')->with(['form' => $form, 'nombres' => $request->nombres,
                'apellidos' => $request->apellidos, 'select' => $request->select, 'text' => $request->text, 'escuela' => $request->escuela,
                'facultad' => $request->facultad, 'selectt' => $request->selectt, 'txtsub' => $request->txtsub, 'subtramite' => $request->subtramite,
                'detalle' => $request->detalle, 'boletapagar' => $request->boletapagar, 'total' => $request->total]);
        } elseif (isset($request->total) == 0 || isset($request->total) == '') {
            return view('Ventanilla/Culqi/visa');
        }
    }

    public function boton($sessionToken, $merchanId, $amount, $nombres, $apellidos)
    {
        $numorden = $this->contador();
        $formulario = "
        <form action=\"{{url('/transaction')}}\" method='post'>
            <script src=\"https://static-content.vnforapps.com/v1/js/checkout.js?qa=true\"
                data-sessiontoken=\"$sessionToken\"
                data-merchantid=\"$merchanId\"
                data-buttonsize=\"large\"
                data-buttoncolor=\"\" 
                data-merchantlogo =\"http://www.logrosperu.com/images/logos/universidades/unitru.jpg\"
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
                data-documenttype=\"0\"
                data-documentid=\"\"
                data-beneficiaryid=\"TEST1123\"
                data-productid=\"\"
                data-phone=\"\"
            /></script>
        </form>";
        return $formulario;
    }

    public function transaction(Request $request)
    {
        if (isset($request->transactionToken)) {
            $sessionToken = $this->recupera_sessionToken();
            $transactionToken = $request->transactionToken;
            echo "<pre>";
            var_dump($_POST);
            echo "<pre>";
            $respuesta = $this->authorization("dev", '148131802', $transactionToken, 'AKIAJRWJQBFYLRVB22ZQ', 'fzi9pi12Gm+isyQtICGNzJfYVN6ZFcMOI5+uM0cN', $sessionToken);
            if (version_compare(PHP_VERSION, '5.4.0', '<')) {
                echo "<pre>";
                echo $this->jsonpp($respuesta);
                echo "<pre>";
            } else {
                echo "<pre>";
                var_dump($respuesta);
                echo "<pre>";
            }
        }
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
        $json = json_decode($response);
        if (version_compare(PHP_VERSION, '5.4.0', '<')) {
            $json = json_encode($json);
        } else {
            $json = json_encode($json, JSON_PRETTY_PRINT);
        }
        return $json;
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

    function jsonpp($json, $istr = '')
    {
        $result = '';
        for ($p = $q = $i = 0; isset($json[$p]); $p++) {
            $json[$p] == '"' && ($p > 0 ? $json[$p - 1] : '') != '\\' && $q = !$q;
            if (strchr('}]', $json[$p]) && !$q && $i--) {
                strchr('{[', $json[$p - 1]) || $result .= "\n" . str_repeat($istr, $i);
            }
            $result .= $json[$p];
            if (strchr(',{[', $json[$p]) && !$q) {
                $i += strchr('{[', $json[$p]) === FALSE ? 0 : 1;
                strchr('}]', $json[$p + 1]) || $result .= "\n" . str_repeat($istr, $i);
            }
        }
        return $result;
    }

    function redirect()
    {
        return Redirect::to('http://www.google.com');
    }
}
