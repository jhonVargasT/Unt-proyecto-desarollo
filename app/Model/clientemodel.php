<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class clientemodel extends Model
{
    protected $fillable= array('codCliente', 'ruc', 'razonSocial', 'estado','codPersona');

    public function persona() {
        return $this->belongsTo('personamodel');
    }
}
