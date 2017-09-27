<?php

namespace App;

class listasAlumno
{
    public function listaAlumno()
    {
        $persona = array(
           array('DNI'=>'555','NOMBRES'=>'HERNANDO DAVID','APELLIDOS'=>'CORTEZ LUNA VICTORIA','CODIGO'=>'000131400','CORREO'=>'','FECHA'=>'2000','ESCUELA'=>'Escuela de Ingenieria Industrial','FACULTAD'=>'Facultad de Ingenieria','SEDE'=>'Trujillo'),
        );
        return $persona;
    }
}