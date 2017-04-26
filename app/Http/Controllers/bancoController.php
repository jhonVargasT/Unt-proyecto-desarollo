<?php

namespace App\Http\Controllers;

use App\bancomodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class bancoController extends Controller
{
    public function registrarBanco(Request $request)
    {
        $banco = new bancomodel();
        $banco->setNombreBanco($request->banco);
        $banco->setNroCuenta($request->cuenta);
        $bool = $banco->guardarBanco();

        if ($bool == true) {
            return back()->with('true', 'Banco ' . $request->banco . ' guardada con exito')->withInput();
        } else {
            return back()->with('false', 'Banco ' . $request->banco . ' no guardada, puede que ya exista');
        }
    }

    public function cargarBanco($codBanco)
    {
        $banco = new bancomodel();
        $banc = $banco->consultarBancoid($codBanco);

        return view('Administrador/Banco/Edit')->with(['banco' => $banc]);
    }

    public function editarBanco($codBanco, Request $request)
    {
        $banco = new bancomodel();
        $banco->setNombreBanco($request->banco);
        $banco->setNroCuenta($request->cuenta);
        $banco->editarBanco($codBanco);

        return view('Administrador/Banco/search')->with(['nombre' => $request->banco]);
    }

    public function listarBanco(Request $request)
    {
        $valueA = Session::get('tipoCuentaA');
        $valueR = Session::get('tipoCuentaR');
        $banc = null;

        $banco = new bancomodel();

        if ($request->select == 'Nombre Banco') {
            $banc = $banco->consultarBancoxNombre($request->text);
        } else {
            if ($request->select == 'Cuenta Banco') {
                $banc = $banco->consultarBancoxCuenta($request->text);
            } else {
                if ($request->select == 'Todo') {
                    $banc = $banco->consultarBancos();
                }
            }
        }
        if ($valueA == 'Administrador')
            return view('Administrador/Banco/Search')->with(['banco' => $banc, 'txt' => $request->text, 'select' => $request->select]);
        if ($valueR == 'Reportes')
            return view('Reportes/Banco/Search')->with(['banco' => $banc, 'txt' => $request->text, 'select' => $request->select]);
    }

    public function eliminarBanco($codBanco, Request $request)
    {
        $banco = new bancomodel();
        $val = $banco->eliminarBanco($codBanco);
        if ($val == true) {
            return back()->with('true', 'Banco ' . $request->nombreBanco . ' eliminado con exito')->withInput();
        } else {
            return back()->with('false', 'Sede ' . $request->nombreBanco . ' no eliminada');
        }
    }
}
