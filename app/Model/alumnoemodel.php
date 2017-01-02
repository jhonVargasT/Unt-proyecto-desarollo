<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class alumnoemodel extends Model
{
    protected $fillable = array('codAlumno', 'codMatricula', 'fecha','estado','codPersona, idEscuela');

    public function persona()
    {
        return $this->belongsTo('personamodel');
    }

    public function  escuela()
    {
        return $this->belongsTo('escuelamodel');
    }
}
