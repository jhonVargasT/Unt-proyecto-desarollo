<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class PersonaRepository
{
    public function consultarPersonas( $dni, $nombres)
    {
        DB::table('persona')
            ->where('dni', '=', $dni)
            ->orWhere('nombres', '=', $nombres)
            ->get();
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
}
