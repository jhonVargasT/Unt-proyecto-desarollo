<?php

namespace App\Http\Controllers;

use App\personalemodel;
use App\personalmodel;
use App\personamodel;
use Illuminate\Http\Request;

class personalController extends Controller
{
    public function registrarPersonal(Request $request)
    {
        $persona = new personamodel();
        $persona->setDni($request->dni);
        $persona->setNombres($request->nombres);
        $persona->setApellidos($request->apellidos);
        $per = $persona->save('personal',$request->cuenta);

        $personal = new personalmodel();
        $personal->setCuenta($request->cuenta);
        $personal->setPassword($request->contraseña);
        $personal->setTipoCuenta($request->tipocuenta);
        $co= $personal->bdPersona($request->dni);
        $personal->setIdPersona($co);
        $p = $personal->savepersonal();

        if ($per && $p == true) {
            return view('/Administrador/Personal/add');
        } else {
            return view('/Administrador/Personal/add');
        }
    }

    public function loguearPersonal(Request $request)
    {
        $personal = new personalmodel();
        $personal->setCuenta($request->cuenta);
        $personal->setPassword($request->contraseña);
        $persona = $personal->logear();


        if ($persona != null) {
            return view('Administrador/Tramite/add', ['persona' => $persona]);
        } else {
            return view('nope');
        }

    }
}
