<?php

namespace App\Http\Controllers;

use App\facultadmodel;
use App\loguntemodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Validator;

class facultadController extends Controller
{
    //Registar facultad
    public function registrarFacultad(Request $request)
    {
        try {
            $facultad = new facultadmodel();
            $facultad->setCodFacultad($request->CodigoFacultad);
            $facultad->setNombre($request->NombreFacultad);
            $facultad->setNroCuenta($request->CuentaInterna);
            $codsede = $facultad->bscSedeId($request->nombreSede);//SQL, buscar id de la sede por su nombre
            $facultad->setCodSede($codsede);

            $fac = $facultad->save();
        }catch (Exception $e)
        {
            $e->getMessage();
        }
      /*  if ($fac == true) {
            return back()->with('true', 'Facultad ' . $request->NombreFacultad . ' guardada con exito')->withInput();
        } else {
            return back()->with('false', 'Facultad ' . $request->NombreFacultad . ' no guardada, puede que ya exista');
        }*/
    }

    //Cargar los datos de la facultad para la modificacion
    public function cargarFacultad($idFacultad)
    {
        $facultad = new facultadmodel();
        $fac = $facultad->consultarFacultadid($idFacultad);//SQL, busca la facultad por su id

        return view('Administrador/Facultad/Edit')->with(['facultad' => $fac]);
    }

    //Edita los datos de la facultad
    public function editarFacultad($idFacultad, Request $request)
    {
        $facultad = new facultadmodel();
        $facultad->setCodFacultad($request->CodigoFacultad);
        $facultad->setNombre($request->NombreFacultad);
        $facultad->setNroCuenta($request->CuentaInterna);
        $codsede = $facultad->bscSedeId($request->nombreSede);//SQL, buscar id de la sede por su nombre
        $facultad->setCodSede($codsede);
        $facultad->editarFacultad($idFacultad);

        return view('Administrador/Facultad/search')->with(['nombre' => $request->NombreFacultad]);
    }

    //Busca facultades
    public function listarFacultad(Request $request)
    {
        $valueA = Session::get('tipoCuentaA');
        $valueR = Session::get('tipoCuentaR');
        $fac = null;
        $facultad = new facultadmodel();
        $opciones = ['Todo', 'Codigo facultad', 'Codigo facultad', 'Nombre Facultad'];
        if ($request->select == 'Codigo Facultad') {
            $fac = $facultad->consultarFacultadesCodigo($request->text);//SQL, Buscar facultad por su codigo
        } else {
            if ($request->select == 'Nombre Facultad') {
                $fac = $facultad->consultarFacultadesNombre($request->text);//SQL, Buscar facultad por su nombre
            } else {
                if ($request->select == 'Cuenta Interna') {
                    $fac = $facultad->consultarFacultadesCuentaInterna($request->text);//SQL, Buscar facultad por su cuenta interna
                } else {
                    if ($request->select == 'Sede') {
                        $fac = $facultad->consultarFacultadesSede($request->text);//SQL, Buscar facultades por sede
                    } else {
                        $fac = $facultad->consultarFacultades();//SQL, Buscar facultades
                    }
                }
            }
        }
        if ($valueA == 'Administrador')
            return view('Administrador/Facultad/Search')->with(['facultad' => $fac, 'txt' => $request->text, 'select' => $request->select, 'opciones' => $opciones]);
        if ($valueR == 'Reportes')
            return view('Reportes/Facultad/Search')->with(['facultad' => $fac, 'txt' => $request->text, 'select' => $request->select, 'opciones' => $opciones]);
    }

    //Elimina (cambia de estado de 1 a 0) al registro de la facultad
    public function eliminarFacultad($idFacultad, Request $request)
    {
        $facultad = new facultadmodel();
        $val = $facultad->eliminarFacultad($idFacultad);//SQL, elimina el registro de la facultad
        if ($val == true) {
            return back()->with('true', 'Facultad ' . $request->NombreFacultad . ' eliminada con exito')->withInput();
        } else {
            return back()->with('false', 'Facultad ' . $request->NombreFacultad . ' no se elimino')->withInput();
        }
    }

    //Typeahead autollenado, buscar nombre de facultad
    public function autocomplete(Request $request)
    {
        $facultad = new facultadmodel();
        $data = $facultad->llenarFacultadReporte($request->input('query'));
        return response()->json($data);
    }

    //Typeahead autollenado, buscar nombre de sede
    public function autocompletesede(Request $request)
    {
        $data = DB::table('sede')->select("nombresede as name")->where("nombresede", "LIKE", "%{$request->input('query')}%")->get();
        return response()->json($data);
    }

    //Ajax autolleando, buscar facultad a la sede que pertenece
    public function searchF(Request $request)
    {
        $products = DB::select('select facultad.nombre as nombre from facultad
        left join sede on facultad.coSede=sede.codSede 
        where  facultad.coSede=sede.codSede and sede.estado=1
        and facultad.estado=1 and sede.nombresede = "' . $request->sede . '"   and facultad.nombre like "%' . $request->term . '%" ');

        $data = array();
        foreach ($products as $product) {
            $data[] = array('value' => $product->nombre);
        }
        if (count($data))
            return $data;
        else
            return ['value' => 'No se encuentra'];
    }
}
