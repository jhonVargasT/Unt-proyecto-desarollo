<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tramitemodel extends Model
{
    protected $fillable= array('codTramite', 'clasificador', 'nombre', 'fuentefinanc','tipoRecurso','estado');

    public function subtramite()
    {
        return $this->hasMany('subtramitemodel');
    }

    public function donacion()
    {
        return $this->hasMany('donaciomodel');
    }
}
