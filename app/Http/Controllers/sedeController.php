<?php

namespace App\Http\Controllers;

use App\sedemodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class sedeController extends Controller
{
    public function registrarSede(Request $request)
    {
        $sede = new sedemodel();
        $sede->setCodigoSede($request->codigoSede);
        $sede->setNombreSede($request->nombreSede);
        $sede->setDireccion($request->direccion);

        $sed = $sede->save();
        if ($sed == true) {
            return back()->with('true', 'Sede ' . $request->nombreSede . ' guardada con exito')->withInput();
        } else {
            return back()->with('false', 'Sede ' . $request->nombreSede . ' no guardada, puede que ya exista');
        }
    }

    public function cargarSede($codSede)
    {
        $sede = new sedemodel();
        $sed = $sede->consultarSedeid($codSede);

        return view('Administrador/Sede/Edit')->with(['sede' => $sed]);
    }

    public function editarSede($codSede, Request $request)
    {
        $sede = new sedemodel();
        $sede->setCodigoSede($request->codigoSede);
        $sede->setNombreSede($request->nombreSede);
        $sede->setDireccion($request->direccion);
        $sede->editarSede($codSede);
        return view('Administrador/Sede/Search')->with(['nombre' => $request->NombreFacultad]);
    }

    public function listarSede(Request $request)
    {
        $sed = null;
        $sede = new sedemodel();

        if ($request->select == 'Nombre Sede') {
            $sed = $sede->consultarSedeNombre($request->text);
        } else {
            if ($request->select == 'Codigo Sede') {
                $sed = $sede->consultarSedeCodigo($request->text);
            } else {
                if ($request->select == 'Direccion') {
                    $sed = $sede->consultarSedeDireccion($request->text);
                } else {
                    $sed = $sede->consultarSedes();
                }
            }
        }
        return view('Administrador/Sede/Search')->with(['sede' => $sed, 'txt' => $request->text, 'select' => $request->select]);
    }

    public function eliminarSede($codSede, Request $request)
    {
        $sede = new sedemodel();
        $sede->eliminarSede($codSede);
        return view('Administrador/Sede/Search')->with(['nombre' => $request->NombreFacultad]);
    }

    public function autocompletesede(Request $request)
    {
        $data = DB::table('sede')->select("nombresede as name")->where("nombresede", "LIKE", "%{$request->input('query')}%")->get();

        return response()->json($data);
    }
}