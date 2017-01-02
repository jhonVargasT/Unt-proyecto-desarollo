<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class PersonalRepository
{

    public function consultarPersonal( $dni)
    {
        $cPersonal = DB::table('personal')
            ->where('dni', '=', $dni)
            ->get();

        return $cPersonal;
    }

    public function  consultarPersona($dni)
    {
        DB::table('persona')
            ->where('dni', '=', $dni)
            ->get();
    }

    public function  consultarPersonaID($codPersona)
    {
        DB::table('persona')
            ->where('codPersona', '=', $codPersona)
            ->get();
    }

    public function  insertarPersona($dni, $nombres, $apellidos)
    {
        DB::table('persona')->insert(
            ['dni' => $dni, 'nombres' => $nombres, 'apellidos' => $apellidos]
        );
    }

    public function  editarPersona($dni, $nombres,$apellidos)
    {
        DB::table('persona')
            ->where('dni', $dni)
            ->update(['nombres' => $nombres, 'apellidos'=>$apellidos]);
    }

    public function  eliminarPersona($dni,$estado)
    {
        DB::table('persona')
            ->where('dni', $dni)
            ->update(['estado' => 0]);
    }
}