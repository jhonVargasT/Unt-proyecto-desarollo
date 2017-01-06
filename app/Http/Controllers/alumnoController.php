<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class alumnoController extends Controller
{
    public function registrarPersonal(Request $request)
    {
        $dni= ($request->dni);
        $nombres= ($request->nombres);
        $apellidos=($request->apellidos);
        $cuenta=($request->cuenta);
        $password=($request->contraseña);
        $tipocuenta=($request->tipocuenta);

        DB::table('persona')->insert(
            ['dni' => $dni, 'nombres' => $nombres, 'apellidos'=>$apellidos]
        );

        $idPersona = DB::select('select codPersona from persona where dni=:dni',['dni'=>$dni]);

        foreach ($idPersona as $ip) {
            $rg = $ip->codPersona;
        }

        DB::table('alumno')->insert(
            ['cuenta' => $cuenta, 'password' => $password, 'tipocuenta'=>$tipocuenta,'idPersona'=>$rg]
        );

        $personal = DB::select('select nombres, apellidos from persona right join personal on persona.codPersona=personal.idPersona where personal.cuenta=:cuenta and personal.password=:pass',
            ['cuenta' => $cuenta , 'pass'=>$password]);

        if($personal!=null) {
            return view('index');
        }
        else{
            return view('personal');
        }
    }
}
