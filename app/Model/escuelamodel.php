<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class escuelamodel extends Model
{
    protected $fillable= array('codEscuela', 'nombre', 'nroCuenta', 'estado','idFacultad');

    public function facultad() {
        return $this->belongsTo('facultadmodel');
    }

    public function alumno()
    {
        return $this->hasMany('alumnomodel');
    }

}
