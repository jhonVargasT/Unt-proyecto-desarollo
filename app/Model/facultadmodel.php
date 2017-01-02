<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class facultadmodel extends Model
{
    protected $fillable = array('codFacultad', 'nombre', 'nroCuenta', 'estado',);

    public function escuela()
    {
        return $this->hasMany('escuelamodel');
    }

}
