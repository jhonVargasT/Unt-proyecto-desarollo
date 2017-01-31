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
        $valp = $persona->save('cliente', $request->ruc);

        $cliente = new clientemodel();
        $cliente->setRuc($request->ruc);
        $cliente->setRazonSocial($request->razonSocial);
        $idP = $cliente->bdPersona($request->dni);
        $cliente->setIdPersona($idP);
        $cli = $cliente->savecliente();

        if ($valp && $cli == true) {
            return view('Administrador/Cliente/Add');
        } else {
            return view('Administrador/Cliente/Add');
        }
    }

    public function cargarCliente($codPersona)
    {
        $cliente = new clientemodel();
        $cli = $cliente->consultarClienteid($codPersona);
        return view('Administrador/Cliente/Edit')->with(['cliente' => $cli]);
    }

    public function editarCliente($codPersona, Request $request)
    {
        $cliente = new clientemodel();
        $cliente->setDni($request->dni);
        $cliente->setNombres($request->nombres);
        $cliente->setApellidos($request->apellidos);
        $cliente->setRuc($request->ruc);
        $cliente->setRazonSocial($request->razonSocial);
        $cliente->editarCliente($codPersona);
        return view('Administrador/Cliente/Search')->with(['nombre' => $request->nombres]);
    }

    public function listarCliente(Request $request)
    {
        $cli = null;
        $cliente = new clientemodel();

        if ($request->select == 'Dni') {
            $cli = $cliente->consultarAlumnoDNI($request->text);
        } else {
            if ($request->select == 'Apellidos') {
                $cli = $cliente->consultarAlumnoApellidos($request->text);
            } else {
                if ($request->select == 'Ruc') {
                    $cli = $cliente->consultarAlumnoRUC($request->text);
                } else {
                    if ($request->select == 'Razon social') {
                        $cli = $cliente->consultarAlumnoRazonSocial($request->text);
                    }
                }
            }
        }
        return view('Administrador/Cliente/Search')->with(['cliente' => $cli, 'txt' => $request->text, 'select' => $request->select]);
    }

    public function eliminarCliente($codPersona,Request $request)
    {
        $cliente = new clientemodel();
        $cliente->eliminarCliente($codPersona);
        return view('Administrador/Cliente/Search')->with(['nombre'=>$request->nombres]);
    }
}
