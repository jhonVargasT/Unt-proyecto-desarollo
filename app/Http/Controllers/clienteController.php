<?php

namespace App\Http\Controllers;
use App\clientemodel;
use App\personamodel;
use Illuminate\Http\Request;

class clienteController extends Controller
{
    public function registrarCliente(Request $request)
    {
        $persona = new personamodel();
        $persona->setDni($request->dni);
        $persona->setNombres($request->nombres);
        $persona->setApellidos($request->apellidos);
        $valp = $persona->save('cliente',$request->ruc);

        $cliente = new clientemodel();
        $cliente->setRuc($request->ruc);
        $cliente->setRazonSocial($request->razonSocial);
        $idP = $cliente->bdPersona($request->dni);
        $cliente->setIdPersona($idP);
        $cli = $cliente->savecliente();

        if($valp&&$cli == true) {
            return view('Administrador/Cliente/Add');
        }
        else{
            return view('Administrador/Cliente/Add');
        }
    }
}
