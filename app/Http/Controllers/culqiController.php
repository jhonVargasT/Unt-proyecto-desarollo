<?php

namespace App\Http\Controllers;

use Culqi\Culqi;
use Exception;
use Illuminate\Http\Request;

class culqiController extends Controller
{
    public function culqi(Request $request)
    {
        try {
            // Configurar tu API Key y autenticación
            $SECRET_KEY = "sk_test_Z1aMDe3V3b7BkYIi";
            $culqi = new Culqi(array('api_key' => $SECRET_KEY));
            // Creando Cargo a una tarjeta

            $token = $request->token;
            $precio = $request->precio;
            $descripcion = $request->descripcion;
            $nombres = $request->nombres;
            $apellidos = $request ->apellidos;

            $culqi->Charges->create(
                array(
                    "amount" => $precio,
                    "capture" => true,
                    "currency_code" => "PEN",
                    "description" => $descripcion,
                    "installments" => 0,
                    "email" => "test@culqi.com",
                    "metadata" => array("test" => "test"),
                    "source_id" => $token,
                    "first_name"=> $nombres,
                    "last_name " => $apellidos
                )
            );
            // Respuesta
            return 'ok';
        } catch (Exception $e) {
            return 'bad';
        }
    }
}
