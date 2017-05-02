<?php

namespace App\Http\Controllers;

use App\sedemodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class sedeController extends Controller
{
    //Registrar Sede
    public function registrarSede(Request $request)
    {
        $sede = new sedemodel();
        $sede->setCodigoSede($request->codigoSede);
        $sede->setNombreSede($request->nombreSede);
        $sede->setDireccion($request->direccion);

        $sed = $sede->save();//SQL, insertar registro de la sede
        if ($sed == true) {
            return back()->with('true', 'Sede ' . $request->nombreSede . ' guardada con exito')->withInput();
        } else {
            return back()->with('false', 'Sede ' . $request->nombreSede . ' no guardada, puede que ya exista');
        }
    }

    //Cargar datos de la sede a modifciar
    public function cargarSede($codSede)
    {
        $sede = new sedemodel();
        $sed = $sede->consultarSedeid($codSede);//SQL, obtener datos de la sede

        return view('Administrador/Sede/Edit')->with(['sede' => $sed]);
    }

    //Editar datos de la sede
    public function editarSede($codSede, Request $request)
    {
        $sede = new sedemodel();
        $sede->setCodigoSede($request->codigoSede);
        $sede->setNombreSede($request->nombreSede);
        $sede->setDireccion($request->direccion);
        $sede->editarSede($codSede);//SQL, actualizar datos de la sede
        return view('Administrador/Sede/search')->with(['nombre' => $request->nombreSede]);
    }

    //Buscar sedes
    public function listarSede(Request $request)
    {
        $valueA = Session::get('tipoCuentaA');
        $valueR = Session::get('tipoCuentaR');
        $sed = null;
        $sede = new sedemodel();

        if ($request->select == 'Nombre Sede') {
            $sed = $sede->consultarSedeNombre($request->text);//SQL, obtener datos de la sede por nombre
        } else {
            if ($request->select == 'Codigo Sede') {
                $sed = $sede->consultarSedeCodigo($request->text);//SQL, obtener datos de la sede por codigo de sede
            } else {
                if ($request->select == 'Direccion') {
                    $sed = $sede->consultarSedeDireccion($request->text);//SQL, obtener datos de la sede por direccion
                } else {
                    $sed = $sede->consultarSedes();//SQL, buscar todos los personales
                }
            }
        }
        if ($valueA == 'Administrador')
            return view('Administrador/Sede/Search')->with(['sede' => $sed, 'txt' => $request->text, 'select' => $request->select]);
        if ($valueR == 'Reportes')
            return view('Reportes/Sede/Search')->with(['sede' => $sed, 'txt' => $request->text, 'select' => $request->select]);
    }

    //Eliminar sede
    public function eliminarSede($codSede, Request $request)
    {
        $sede = new sedemodel();
        $val = $sede->eliminarSede($codSede);//SQL, eliminar(cambira de 1 a 0) el registro de la sede
        if ($val == true) {
            return back()->with('true', 'Sede ' . $request->nombreSede . ' eliminado con exito')->withInput();
        } else {
            return back()->with('false', 'Sede ' . $request->nombreSede . ' no eliminada');
        }
    }

    //Typeahead autollenado, buscar sedes por nombre
    public function autocompletesede(Request $request)
    {
        $data = DB::table('sede')->select("nombresede as name")->where("nombresede", "LIKE", "%{$request->input('query')}%")->get();

        return response()->json($data);
    }
}