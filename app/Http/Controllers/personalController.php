<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class personalController extends Controller
{
    public function loguearPersonal(Request $request)
    {
        echo ($request->cuenta. ' ' .$request->contraseña);
    }
}
