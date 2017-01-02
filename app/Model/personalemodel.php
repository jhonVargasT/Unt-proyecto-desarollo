<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class personalemodel extends Model
{
    protected $fillable= array('codPersonal', 'cuenta', 'password', 'tipoCuenta','estadoCuenta','estadoCuenta', 'estado','codPersona');

    public function persona() {
        return $this->belongsTo('personamodel');
    }

    public function logunt()
    {
        return $this->hasMany('loguntmodel');
    }
}
