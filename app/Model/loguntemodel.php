<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class loguntemodel extends Model
{
    protected $fillable= array('codLog', 'descripcion', 'estado', 'codPersonal', 'estado','codPersonal');

    public function personal() {
        return $this->belongsTo('personalmodel');
    }
}
