<?php

namespace App\Http\Controllers;

use App\clientemodel;
use App\loguntemodel;
use App\personamodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class clienteController extends Controller
{
    //Registra los datos del cliente
    public function registrarCliente(Request $request)
    {
        $cliente = new clientemodel();
        $cliente->setDni($request->dni);
        $cliente->setNombres($request->nombres);
        $cliente->setApellidos($request->apellidos);
        $cliente->setRuc($request->ruc);
        $cliente->setRazonSocial($request->razonSocial);
        $cliente->setCorreo($request->correo);
        $cli = $cliente->savecliente();//SQL de insercion del cliente (persona y cliente)

        if ($cli == true) {
            return back()->with('true', 'Cliente ' . $request->nombres . ' guardada con exito')->withInput();
        } else {
            return back()->with('false', 'Cliente ' . $request->nombres . ' no guardada, puede que ya exista');
        }
    }

    //Carga los datos del cliente a ser modificados
    public function cargarCliente($codPersona)
    {
        $valueA = Session::get('tipoCuentaA');
        $valueV = Session::get('tipoCuentaV');

        $cliente = new clientemodel();
        $cli = $cliente->consultarClienteid($codPersona);//Busqueda del cliente mediante su codigo de persona

        if ($valueA == 'Administrador')
            return view('Administrador/Cliente/Edit')->with(['cliente' => $cli]);
        if ($valueV == 'Ventanilla')
            return view('Ventanilla/Cliente/Edit')->with(['cliente' => $cli]);
    }

    //Modifica los datos del cliente
    public function editarCliente($codPersona, Request $request)
    {
        $valueA = Session::get('tipoCuentaA');
        $valueV = Session::get('tipoCuentaV');

        $cliente = new clientemodel();
        $cliente->setDni($request->dni);
        $cliente->setNombres($request->nombres);
        $cliente->setApellidos($request->apellidos);
        $cliente->setRuc($request->ruc);
        $cliente->setRazonSocial($request->razonSocial);
        $cliente->setCorreo($request->correo);
        $cliente->editarCliente($codPersona);//SQL de actualizar los datos del cliente

        if ($valueA == 'Administrador')
            return view('Administrador/Cliente/Search')->with(['nombre' => $request->nombres]);
        if ($valueV == 'Ventanilla')
            return view('Ventanilla/Cliente/Search')->with(['nombre' => $request->nombres]);
    }

    //Busqueda del cliente
    public function listarCliente(Request $request)
    {
        $valueA = Session::get('tipoCuentaA');
        $valueV = Session::get('tipoCuentaV');
        $valueR = Session::get('tipoCuentaR');

        $cli = null;
        $cliente = new clientemodel();

        if ($request->select == 'Dni') {
            $cli = $cliente->consultarClienteDNI($request->text);//SQL, busca al cliente por su dni
        } else {
            if ($request->select == 'Apellidos') {
                $cli = $cliente->consultarClienteApellidos($request->text);//SQL, busca al cliente por sus apellidos
            } else {
                if ($request->select == 'Ruc') {
                    $cli = $cliente->consultarClientesRUC($request->text);//SQL, busca al cliente por su ruc
                } else {
                    if ($request->select == 'Razon social') {
                        $cli = $cliente->consultarAlumnoClienteSocial($request->text);//SQL, busca al cliente por su razon social
                    }
                }
            }
        }
        if ($valueA == 'Administrador')
            return view('Administrador/Cliente/Search')->with(['cliente' => $cli, 'txt' => $request->text, 'select' => $request->select]);
        if ($valueV == 'Ventanilla')
            return view('Ventanilla/Cliente/Search')->with(['cliente' => $cli, 'txt' => $request->text, 'select' => $request->select]);
        if ($valueR == 'Reportes')
            return view('Ventanilla/Cliente/Search')->with(['cliente' => $cli, 'txt' => $request->text, 'select' => $request->select]);
    }

    //Elimina (cambia de estado 1 a 0) al registro del cliente(persona y cliente)
    public function eliminarCliente($codPersona, Request $request)
    {
        $valueA = Session::get('tipoCuentaA');
        $valueV = Session::get('tipoCuentaV');

        $cliente = new clientemodel();
        $val = $cliente->eliminarCliente($codPersona);//SQl, cambia de estado al cliente

        if ($valueA == 'Administrador') {
            if ($val == true) {
                return back()->with('true', 'Cliente ' . $request->nombres . ' eliminada con exito')->withInput();
            } else {
                return back()->with('false', 'Cliente ' . $request->nombres . ' no se elimino')->withInput();
            }
        } else {
            if ($valueV == 'Ventanilla') {
                if ($val == true) {
                    return back()->with('true', 'Cliente ' . $request->nombres . ' eliminada con exito')->withInput();
                } else {
                    return back()->with('false', 'Cliente ' . $request->nombres . ' no se elimino')->withInput();
                }
            }
        }
    }
}
