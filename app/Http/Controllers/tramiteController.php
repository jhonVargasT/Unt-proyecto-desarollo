<?php

namespace App\Http\Controllers;

use App\facultadmodel;
use App\loguntemodel;
use App\tramitemodel;
use App\utilmodel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Stmt\TryCatch;

class tramiteController extends Controller
{

    //Registrar Clasificador
    public function registrarTramite(Request $request)
    {
        Try {

            $tramite = new tramitemodel();
            $tramite->setClasificador($request->clasificador);
            $tramite->setNombre($request->nombre);
            $tramite->setFuentefinanc($request->fuentefinanc);
            $tramite->setTipoRecurso($request->tipoRecurso);
            $tramite->setAux($request->aux);

            $tram = $tramite->save();//SQL, insertar registro del clasificador
            if ($tram == true) {
                return back()->with('true', 'Tramite ' . $request->nombre . ' guardada con exito')->withInput();
            } else {
                return back()->with('false', 'Tramite ' . $request->nombre . ' no guardada, puede que ya exista ');
            }
        }catch (Exception $e)
        {
           
            return back()->with('false', 'Tramite ' . $request->nombre . ' no guardada, puede que ya exista ');
        }

    }

    //Cargar datos del clasificador a modficar
    public function cargarTramite($codTramite)
    {
        $tramite = new tramitemodel();
        $tra = $tramite->consultarTramiteid($codTramite);//SQL, obtener datos del clasificador por id del clasificador
        return view('Administrador/Tramite/edit')->with(['tramite' => $tra]);
    }

    //Editar clasificador
    public function editarTramite($codTramite, Request $request)
    {
        $tramite = new tramitemodel();
        $tramite->setClasificador($request->clasificador);
        $tramite->setNombre($request->nombre);
        $tramite->setFuentefinanc($request->fuentefinanc);
        $tramite->setTipoRecurso($request->tipoRecurso);
        $tramite->setAux($request->aux);
        $tramite->editarTramite($codTramite);//SQL, actualizar registro del clasificador
        return view('Administrador/Tramite/search')->with(['nombre' => $request->nombreTramite]);
    }

    //Buscar clasificadores
    public function listarTramite(Request $request)
    {
        $valueA = Session::get('tipoCuentaA');//obtener sesion del tipo de cuenta (administrador)
        $valueR = Session::get('tipoCuentaR');//obtener sesion del tipo de cuenta (reportes)
        $tra = null;
        $tramite = new tramitemodel();

        if ($request->select == 'Codigo clasificador') {
            $tra = $tramite->consultarTramiteCS($request->text);//SQL, obtener datos del clasificador por clasificador siaf
        } else {
            if ($request->select == 'Tipo de recurso') {
                $tra = $tramite->consultarTramiteTR($request->text);//SQL, obtener datos del clasificador por tipo de recurso
            } else {
                if ($request->select == 'Nombre de clasificador') {
                    $tra = $tramite->consultarTramiteN($request->text);//SQL, obtener datos del clasificador por nombre
                } else {
                    if ($request->select == 'Fuente de financiamiento') {
                        $tra = $tramite->consultarTramiteFF($request->text);//SQL, obtener datos del clasificador por fuente de financiamiento
                    } else {
                        $tra = $tramite->consultarTramites();//SQL, obtener todos los clasificadores
                    }
                }
            }
        }
        if ($valueA == 'Administrador')
            return view('Administrador/Tramite/search')->with(['tramite' => $tra, 'txt' => $request->text, 'select' => $request->select]);
        if ($valueR == 'Reportes')
            return view('Reportes/Tramite/search')->with(['tramite' => $tra, 'txt' => $request->text, 'select' => $request->select]);
    }

    //Eliminar clasificadores
    public function eliminarTramite($codTramite, Request $request)
    {
        $tramite = new tramitemodel();
        $tram = $tramite->eliminarTramite($codTramite);//SQL, eliminar (cambiar estado de 1 a 0) el registro del clasificador por codigo de clasificador
        if ($tram == true) {
            return back()->with('true', 'Tramite ' . $request->nombre . ' se eliminado con exito')->withInput();
        } else {
            return back()->with('false', 'Tramite ' . $request->nombre . ' no se elimino');
        }
    }

    //AJAX autollenado
    /*public function autocompletar(Request $request)
    {
        $tramite = new tramitemodel();
        $term = $request->term;
        $data = $tramite->consultarTramiteNombre($term)//SQL, obtener datos del claificador por nombre
            ->take(10)
            ->get();
        $result = array();
        foreach ($data as $dat) {
            $result[] = $dat;
        }
        return response()->json($result);
    }*/

}
