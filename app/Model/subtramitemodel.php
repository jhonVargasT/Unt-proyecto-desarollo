<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class subtramitemodel extends Model
{
    protected $fillable= array('codSubtramite', 'cuenta', 'nombre', 'precio','estado','codTramite');

    public function tramite() {
        return $this->belongsTo('tramitemodel');
    }

    public function pago(){
        return $this->hasMany('pagomodel');
    }
}
