<?php

namespace App\Http\Controllers;

use App\personalmodel;
use App\personamodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class personalController extends Controller
{
    //Registrar datos del personal
    public function registrarPersonal(Request $request)
    {
        $personal = new personalmodel();
        $personal->setDni($request->dni);
        $personal->setNombres($request->nombres);
        $personal->setApellidos($request->apellidos);
        $personal->setCuenta($request->cuentaAgregar);
        $personal->setPassword($request->contraseñaAgregar);
        $personal->setTipoCuenta($request->tipocuenta);
        $personal->setCodPersonal($request->codigoPersonal);
        $personal->setCorreo($request->correo);
        $idS = $personal->obtenerIdSede($request->sede);//SQL, obtener id de la sede por su nombre
        $personal->setIdSede($idS);
        $p = $personal->savepersonal();//SQL, insertar datos del personal

        if ($p == true) {
            return back()->with('true', 'Personal ' . $request->nombres . ' guardada con exito')->withInput();
        } else {
            return back()->with('false', 'Personal ' . $request->nombres . ' no guardada, puede que ya exista');
        }
    }

    //Cerrar sesion del personal
    public function logOutPersonal()
    {
        Session::flush();
        return redirect()->route('index');
    }

    //Inciciar session del personal
    public function loguearPersonal(Request $request)
    {
        $personal = new personalmodel();
        $perso = new personamodel();
        $personal->setCuenta($request->cuenta);
        $personal->setPassword($request->password);
        $person = $personal->logear();//SQL, obtener datos del personal
        $idpersonal = null;
        foreach ($person as $per) {
            $personal->setCuenta($per->cuenta);
            $personal->setPassword($per->password);
            $personal->setTipoCuenta($per->tipoCuenta);
            Session::put('codPersonal', $per->codPersonal);//crear session del codigo del personal
            $idpersonal = $per->idPersonal;
            $persona = $perso->obtnerId($per->idPersona);//SQL, obtener id de la persona
            foreach ($persona as $p) {
                $personal->setNombres($p->nombres);
                $personal->setApellidos($p->apellidos);
            }
        }
        Session::put(['misession' => $personal->getNombres() . ' ' . $personal->getApellidos()]);//crear sesion del personal (nombres y apellidos0
        Session::put('personalC', $personal->getCuenta());//crear sesion del personal (nombre de usuario)
        Session::put('idpersonal', $idpersonal);//crear sesion del id del personal

        if ($personal->getTipoCuenta() == 'Administrador') {//Crear session del tipo de cuenta para el administrador
            Session::put('tipoCuentaA', $personal->getTipoCuenta());
            Session::put('tipoCuentaV', null);
            Session::put('tipoCuentaR', null);
            Session::put('tipoCuentaI', null);
        } elseif ($personal->getTipoCuenta() == 'Ventanilla') {//Crear session del tipo de cuenta para ventanilla
            Session::put('tipoCuentaV', $personal->getTipoCuenta());
            Session::put('tipoCuentaA', null);
            Session::put('tipoCuentaR', null);
            Session::put('tipoCuentaI', null);
        } elseif ($personal->getTipoCuenta() == 'Reportes') {//Crear session del tipo de cuenta para reportes
            Session::put('tipoCuentaR', $personal->getTipoCuenta());
            Session::put('tipoCuentaV', null);
            Session::put('tipoCuentaA', null);
            Session::put('tipoCuentaI', null);
        } elseif ($personal->getTipoCuenta() == 'Importador') {//Crear session del tipo de cuenta para reportes
            Session::put('tipoCuentaI', $personal->getTipoCuenta());
            Session::put('tipoCuentaR', null);
            Session::put('tipoCuentaV', null);
            Session::put('tipoCuentaA', null);
        }
        //Redireccion a vista dependiendo del tipo de cuenta
        if ($personal->getTipoCuenta() == 'Administrador' && $personal->getCuenta() != '') {
            return view('/Administrador/Body');
        } else {
            if ($personal->getTipoCuenta() == 'Ventanilla' && $personal->getCuenta() != '') {

                return view('Ventanilla/Body');
            } else {
                if ($personal->getTipoCuenta() == 'Reportes' && $personal->getCuenta() != '') {
                    return view('Reportes/Body');
                } else {
                    if ($personal->getTipoCuenta() == 'Importador' && $personal->getCuenta() != '') {
                        return view('Importaciones/Body');
                    } else {
                        return back()->with('true', 'Cuenta ' . $personal->getCuenta() . ' no encontrada o contraseña incorrecta')->withInput();
                    }
                }
            }
        }
    }

    //Obtener los datos del personal
    public function cargarPersonal($idPersona)
    {
        $personal = new personalmodel();
        $pers = $personal->consultarPersonalid($idPersona);//SQL, obtener datos del personal por su id de persona
        return view('Administrador/Personal/edit')->with(['personal' => $pers]);
    }

    //Modificar los datos del persnal
    public function editarPersonal($idPersonal, Request $request)
    {
        $personal = new personalmodel();
        $personal->setDni($request->dni);
        $personal->setNombres($request->nombres);
        $personal->setApellidos($request->apellidos);
        $personal->setCuenta($request->cuentaAgregar);
        $personal->setPassword($request->contraseñaAgregar);
        $personal->setTipoCuenta($request->tipocuenta);
        $personal->setCodPersonal($request->codigoPersonal);
        $personal->setCorreo($request->correo);
        $idS = $personal->obtenerIdSede($request->sede);//SQL, obtener id de la sede por su nombre
        $personal->setIdSede($idS);
        $personal->editarPersonal($idPersonal);//SQL, actualizar los datos del personal
        return view('Administrador/Personal/Search')->with(['nombre' => $request->nombres]);
    }

    //Buscar personal
    public function listarPersonal(Request $request)
    {
        $valueA = Session::get('tipoCuentaA');
        $valueR = Session::get('tipoCuentaR');
        $pers = null;
        $personal = new personalmodel();

        if ($request->select == 'Dni') {
            $pers = $personal->consultarPersonalDNI($request->text);//SQL, buscar personal por dni
        } else {
            if ($request->select == 'Apellidos') {
                $pers = $personal->consultarPersonalApellidos($request->text);//SQL, buscar personal por apellidos
            } else {
                if ($request->select == 'Codigo personal') {
                    $pers = $personal->consultarPersonalCodigo($request->text);//SQL, buscar personal por codigo de personal
                } else {
                    if ($request->select == 'Cuenta') {
                        $pers = $personal->consultarPersonalCuenta($request->text);//SQL, buscar personal por cuenta
                    } else {
                        if ($request->select == 'Tipo de cuenta') {
                            $pers = $personal->consultaPersonalTipoCuenta($request->text);//SQL, buscar personal por tipo de cuenta
                        } else {
                            $pers = $personal->consultaPersonales();//SQL, buscar todos los personales
                        }
                    }
                }
            }
        }
        if ($valueA == 'Administrador')
            return view('Administrador/Personal/Search')->with(['personal' => $pers, 'buscar' => $request->text, 'select' => $request->select]);
        if ($valueR == 'Reportes')
            return view('Reportes/Personal/Search')->with(['personal' => $pers, 'buscar' => $request->text, 'select' => $request->select]);

    }


    //Eliminar (cambiar estado de 1 a 0) el registro del personal
    public function eliminarPersonal($codPersona, Request $request)
    {
        $personal = new personalmodel();
        $p = $personal->eliminarPersonal($codPersona);//SQL, eliminar registro del personal
        if ($p == true) {
            return back()->with('true', 'Personal ' . $request->nombres . ' se elimino con exito')->withInput();
        } else {
            return back()->with('false', 'Personal ' . $request->nombres . ' no elimino');
        }
    }
}