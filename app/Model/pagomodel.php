<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pagomodel extends Model
{
    protected $fillable= array('codPago', 'lugar', 'detalle', 'fechaDevolucion','estado','codPersona','codPersonal','codSubtramite');

    public function persona() {
        return $this->belongsTo('personamodel');
    }

    public function personal() {
        return $this->belongsTo('personalmodel');
    }

    public function subtramite() {
        return $this->belongsTo('subtramitemodel');
    }
}
