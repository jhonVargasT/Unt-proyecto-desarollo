<?php

namespace App\Http\Controllers;

use App\personalmodel;
use App\personamodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class personalController extends Controller
{
    public function registrarPersonal(Request $request)
    {
        $personal = new personalmodel();
        $personal->setDni($request->dni);
        $personal->setNombres($request->nombres);
        $personal->setApellidos($request->apellidos);
        $personal->setCuenta($request->cuenta);
        $personal->setPassword($request->contraseña);
        $personal->setTipoCuenta($request->tipocuenta);
        $personal->setCodPersonal($request->codigoPersonal);
        $p = $personal->savepersonal();

        if ($p == true) {
            return back()->with('true', 'Personal ' . $request->nombres . ' guardada con exito')->withInput();
        } else {
            return back()->with('false', 'Personal ' . $request->nombres . ' no guardada, puede que ya exista');
        }
    }

    public function logOutPersonal()
    {
        Session::forget('misession');
        return view('Index');
    }

    public function loguearPersonal(Request $request)
    {
        $personal = new personalmodel();
        $perso = new personamodel();
        $personal->setCuenta($request->cuenta);
        $personal->setPassword($request->password);
        $person = $personal->logear();
        foreach ($person as $per) {
            $personal->setCuenta($per->cuenta);
            $personal->setPassword($per->password);
            $personal->setTipoCuenta($per->tipoCuenta);
            $persona = $perso->obtnerId($per->idPersona);
            foreach ($persona as $p) {
                $personal->setNombres($p->nombres);
                $personal->setApellidos($p->apellidos);
            }
        }
        Session::put(['misession'=>$personal->getNombres().' '.$personal->getApellidos()]);
        Session::put('personalC', $personal->getCuenta());
        if ($personal->getTipoCuenta() == 'Administrador' && $personal->getCuenta() != '') {
            return view('/Administrador/body');
        } else {
            if ($personal->getTipoCuenta() == 'Ventanilla'&& $personal->getCuenta() != '') {
                return view('Ventanilla/Body');
            } else {
                return back()->with('true', 'Cuenta ' . $personal->getCuenta(). ' no encontrada o contraseña incorrecta')->withInput();
            }
        }
    }

    public function cargarPersonal($idPersona)
    {
        $personal = new personalmodel();
        $pers = $personal->consultarPersonalid($idPersona);
        return view('Administrador/Personal/Edit')->with(['personal' => $pers]);
    }

    public function editarPersonal($idPersonal, Request $request)
    {
        $personal = new personalmodel();
        $personal->setDni($request->dni);
        $personal->setNombres($request->nombres);
        $personal->setApellidos($request->apellidos);
        $personal->setCodPersonal($request->codigoPersonal);
        $personal->setCuenta($request->cuenta);
        $personal->setPassword($request->contraseña);
        $personal->setTipoCuenta($request->tipoDeCuenta);
        $personal->editarPersonal($idPersonal);
        return view('Administrador/Personal/Search')->with(['nombre' => $request->nombres]);
    }

    public function listarPersonal(Request $request)
    {
        $pers = null;
        $personal = new personalmodel();

        if ($request->select == 'Dni') {
            $pers = $personal->consultarPersonalDNI($request->text);
        } else {
            if ($request->select == 'Apellidos') {
                $pers = $personal->consultarPersonalApellidos($request->text);
            } else {
                if ($request->select == 'Codigo personal') {
                    $pers = $personal->consultarPersonalCodigo($request->text);
                } else {
                    if ($request->select == 'Cuenta') {
                        $pers = $personal->consultarPersonalCuenta($request->text);
                    } else {
                        if ($request->select == 'Tipo de cuenta') {
                            $pers = $personal->consultaPersonalTipoCuenta($request->text);
                        }
                    }
                }
            }
        }
       return view('Administrador/Personal/Search')->with(['personal' => $pers, 'txt' => $request->text, 'select' => $request->select]);
    }

    public function eliminarPersonal($codPersona, Request $request)
    {
        $personal = new personalmodel();
        $personal->eliminarPersonal($codPersona);
        return view('Administrador/Personal/Search')->with(['nombre' => $request->nombres]);
    }
}
