<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class PersonaRepository
{

    public function consultarPersonas( $dni, $nombres)
    {
        $cPersonas = DB::table('persona')
            ->where('dni', '=', $dni)
            ->orWhere('nombres', '=', $nombres)
            ->get();

        return $cPersonas;
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
