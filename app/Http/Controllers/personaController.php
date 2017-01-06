<?php

namespace App\Http\Controllers;

use App\PersonaRepository;
use Illuminate\Http\Request;

class personaController extends Controller
{
    private $personRepo;

    public function __construct (PersonaRepository $personaRepo)
    {
        $this->personRepo = $personaRepo;
    }
}