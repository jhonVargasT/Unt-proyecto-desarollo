<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class personalController extends Controller
{
    public function loguearPersonal(Request $request)
    {
        $cuenta= ($request->cuenta);
        $pass= ($request->contraseña);

        $personal = DB::select('select codPersonal from personal where cuenta = :cuenta and password= :pass', ['cuenta' => $cuenta , 'pass'=>$pass]);

        if($personal!=null) {
            return view('home', ['personal' => $personal]);
        }
        else{
            return view('index');
        }

    }
}
