<?php

namespace App\Http\Controllers;

use App\clientemodel;
use App\loguntemodel;
use App\personamodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class clienteController extends Controller
{
    public function registrarCliente(Request $request)
    {
        $cliente = new clientemodel();
        $cliente->setDni($request->dni);
        $cliente->setNombres($request->nombres);
        $cliente->setApellidos($request->apellidos);
        $cliente->setRuc($request->ruc);
        $cliente->setRazonSocial($request->razonSocial);
        $cli = $cliente->savecliente();

        if ($cli == true) {
            return back()->with('true', 'Cliente ' . $request->nombres . ' guardada con exito')->withInput();
        } else {
            return back()->with('false', 'Cliente ' . $request->nombres . ' no guardada, puede que ya exista');
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
