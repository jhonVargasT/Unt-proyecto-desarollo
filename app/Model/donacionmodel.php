<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class donacionmodel extends Model
{
    protected $fillable= array('codDonacion', 'numResolucion', 'fechaIngreso', 'decripcion','estado','codTramite');

    public function tramite() {
        return $this->belongsTo('tramitemodel');
    }
}
