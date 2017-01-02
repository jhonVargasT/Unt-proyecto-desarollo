<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class personamodel extends Model
{
    protected $fillable = array('codPersona', 'dni', 'nombres', 'apellidos', 'estado',);

    public function personal()
    {
        return $this->hasOne('personalmodel');
    }

    public function cliente()
    {
        return $this->hasOne('clientemodel');
    }

    public function alumno()
    {
        return $this->hasOne('alumnomodel');
    }
}
