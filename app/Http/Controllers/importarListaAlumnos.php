<?php

namespace App\Http\Controllers;

use app;
use App\alumnomodel;
use App\listasAlumno;
use Exception;
use Illuminate\Support\Facades\DB;

class importarListaAlumnos extends Controller
{
    public function importExcelAlumno()
    {
        $alumno = new alumnomodel();
        $lista = new listasAlumno();
        $persona = $lista->listaAlumno();

        if (!empty($persona)) {
            foreach ($persona as $value) {
                $coP = null;
                $coS = null;
                $coF = null;
                try {
                    $coS = DB::table('sede')->select('codSede')->where('nombresede', '' . $value['SEDE'] . ' ')->count();
                    if ($coS != 0) {

                        $coS = DB::table('sede')->select('codSede')->where('nombresede', '' . $value['SEDE'] . ' ')->get();
                        foreach ($coS as $co) {
                            $coS = $co->codSede;
                        }
                        $coF = DB::table('facultad')->select('idFacultad')
                            ->where([
                                ['coSede', '=', $coS],
                                ['nombre', '=', '' . $value['FACULTAD'] . ' '],
                                ['estado', '=', 1]
                            ])->count();

                        if ($coF != 0) {
                            $coF = DB::table('facultad')->select('idFacultad')
                                ->where([
                                    ['coSede', '=', $coS],
                                    ['nombre', '=', '' . $value['FACULTAD'] . ' '],
                                    ['estado', '=', 1]
                                ])->get();
                            foreach ($coF as $co) {
                                $coF = $co->idFacultad;
                            }

                            $coE = DB::table('escuela')->select('idEscuela')->where(
                                [
                                    ['nombre', '=', $value['ESCUELA']],
                                    ['codigoFacultad', '=', $coF]
                                ]
                            )->count();
                            if ($coE != 0) {
                                $coE = DB::table('escuela')->select('idEscuela')->where(
                                    [
                                        ['nombre', '=', $value['ESCUELA']],
                                        ['codigoFacultad', '=', $coF]
                                    ]
                                )->get();
                                foreach ($coE as $co) {
                                    $coE = $co->idEscuela;
                                }
                                $cantAl = 0;
                                $coP = DB::table('persona')->select('idPersona')->where('dni', '=', $value['DNI'])->count();
                                if ($coP != 0) {
                                    $coP = DB::table('persona')->select('codPersona')->where('dni', '=', $value['DNI'])->get();
                                    foreach ($coP as $co) {
                                        $coP = $co->codPersona;
                                    }
                                    $cantAl = DB::table('alumno')->select('idAlumno')->where('idPersona', '=', $coP)->count();
                                }
                                if ($cantAl == 0) {
                                    $alumno->setTipoAlummno(1);
                                    $alumno->setDni($value['DNI']);
                                    $alumno->setNombres($value['NOMBRES']);
                                    $alumno->setApellidos($value['APELLIDOS']);
                                    $alumno->setCodAlumno($value['CODIGO']);
                                    $alumno->setCorreo($value['CORREO']);
                                    $alumno->setFecha($value['FECHA']);
                                    $alumno->setIdEscuela($coE);
                                    $alumno->savealumno($value['DNI']);
                                }
                            }
                        }
                    }
                } catch (Exception $e) {
                    return back()->with('false', 'No subieron los alumnos');
                }
            }
        }
        else{
            return back()->with('false', 'No subieron los alumnos');
        }
        return back()->with('true', 'Exito');
    }
}


