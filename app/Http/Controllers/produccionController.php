<?php

namespace App\Http\Controllers;

use App\produccionmodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class produccionController extends Controller
{
    public function registrarProduccion(Request $request)
    {
        $produccion = new produccionmodel();
        $produccion->setNombre($request->nombre);
        $produccion->setDirecion($request->direccion);

        $pro = $produccion->saveProduccion();

        if ($pro == true) {
            return back()->with('true', 'Produccion ' . $request->nombre . ' guardada con exito')->withInput();
        } else {
            return back()->with('false', 'Produccion ' . $request->nombre . ' no se guardado');
        }
    }

    public function cargarProduccion($codProduccion)
    {
        $produccion = new produccionmodel();
        $pro = $produccion->consultarProduccionid($codProduccion);//Obtiene los datos del alumno por su codigo de persona

        return view('Administrador/Produccion/Edit')->with(['produccion' => $pro]);
    }

    public function editarProduccion($codProduccion, Request $request)
    {
        $produccion = new produccionmodel();
        $produccion->setNombre($request->nombre);
        $produccion->setDirecion($request->direccion);
        $produccion->editarProduccion($codProduccion);//Ejecuta la consulta de actualizar los datos del alumno
        return view('Administrador/Produccion/Search')->with(['nombre' => $request->nombres]);
    }

    public function eliminarProduccion($codProduccion, Request $request)
    {
        $produccion = new produccionmodel();
        $val = $produccion->eliminarProduccion($codProduccion);//SQL que cambia de estado al registro
        if ($val == true) {
            return back()->with('true', 'Banco ' . $request->nombre . ' eliminado con exito')->withInput();
        } else {
            return back()->with('false', 'Sede ' . $request->nombre . ' no eliminada');
        }
    }

    public function listarProduccion(Request $request)
    {
        $prod = null;
        $produccion = new produccionmodel();

        if ($request->select == 'Todo') {
            $prod = $produccion->consultarProduccion();//Sql que busca al banco por su nombre
        } else {
            if ($request->select == 'Nombre') {
                $prod = $produccion->consultarProduccionxNombre($request->text);//Sql que busca al banco por el numero de cuenta
            } else {
                if ($request->select == 'Direccion') {
                    $prod = $produccion->consultarProduccionxDireccion($request->text);//Sql que busca a todos los bancos
                }
            }
        }
        return view('Administrador/Produccion/Search')->with(['produccion' => $prod, 'txt' => $request->text, 'select' => $request->select]);
    }

    public function autocompleteprod(Request $request)
    {
        $data = DB::table('produccion')->select("nombre as name")->where("nombre", "LIKE", "%{$request->input('query')}%")->get();
        return response()->json($data);
    }

    /*public function autocompleteprod(Request $request)
    {
        $products = DB::select('select ');
        $data = array();
        foreach ($products as $product) {
            $data[] = array('value' => $product->nombre);
        }
        if (count($data))
            return $data;
        else
            return ['value' => 'No se encuentra'];
    }*/
}
