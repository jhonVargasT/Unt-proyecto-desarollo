<?php

namespace App\Http\Controllers;

use App\bancomodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class bancoController extends Controller
{

    //Registra a los datos del banco y redirecciona a la misma pagina de registro
    public function registrarBanco(Request $request)
    {
        $banco = new bancomodel();
        $banco->setNombreBanco($request->banco);
        $banco->setNroCuenta($request->cuenta);
        $bool = $banco->guardarBanco();//Sentencia sql que inserta los datos

        if ($bool == true) {
            return back()->with('true', 'Banco ' . $request->banco . ' guardada con exito')->withInput();
        } else {
            return back()->with('false', 'Banco ' . $request->banco . ' no guardada, puede que ya exista');
        }
    }

    //Cargar los datos del banco para desplegarlos en la vista donde se editan los datos
    public function cargarBanco($codBanco)
    {
        $banco = new bancomodel();
        $banc = $banco->consultarBancoid($codBanco);//Consulta sql que saca los datos del banco mediante su ID

        return view('Administrador/Banco/Edit')->with(['banco' => $banc]);
    }

    //Edita los datos cambiando del banco
    public function editarBanco($codBanco, Request $request)
    {
        $banco = new bancomodel();
        $banco->setNombreBanco($request->banco);
        $banco->setNroCuenta($request->cuenta);
        $banco->editarBanco($codBanco);//Sentencia sql que actualiza los datos

        return view('Administrador/Banco/search')->with(['nombre' => $request->banco]);
    }

    //Buscar bancos
    public function listarBanco(Request $request)
    {
        $valueA = Session::get('tipoCuentaA');
        $valueR = Session::get('tipoCuentaR');
        $banc = null;

        $banco = new bancomodel();

        if ($request->select == 'Nombre Banco') {
            $banc = $banco->consultarBancoxNombre($request->text);//Sql que busca al banco por su nombre
        } else {
            if ($request->select == 'Cuenta Banco') {
                $banc = $banco->consultarBancoxCuenta($request->text);//Sql que busca al banco por el numero de cuenta
            } else {
                if ($request->select == 'Todo') {
                    $banc = $banco->consultarBancos();//Sql que busca a todos los bancos
                }
            }
        }
        if ($valueA == 'Administrador')
            return view('Administrador/Banco/Search')->with(['banco' => $banc, 'txt' => $request->text, 'select' => $request->select]);
        if ($valueR == 'Reportes')
            return view('Reportes/Banco/Search')->with(['banco' => $banc, 'txt' => $request->text, 'select' => $request->select]);
    }

    //Elimina (cambia de estado de 1 a 0) un registro de banco mediante su codigo del banco
    public function eliminarBanco($codBanco, Request $request)
    {
        $banco = new bancomodel();
        $val = $banco->eliminarBanco($codBanco);//SQL que cambia de estado al registro
        if ($val == true) {
            return back()->with('true', 'Banco ' . $request->nombreBanco . ' eliminado con exito')->withInput();
        } else {
            return back()->with('false', 'Banco ' . $request->nombreBanco . ' no eliminada');
        }
    }
}
