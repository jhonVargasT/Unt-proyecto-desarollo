<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class emailController extends Controller
{
    public function sendEmail(Request $request)
    {
        Mail::send('Ventanilla/Pagos/reporte', ['pago'=>$request->pago], function($message) use ($request)
        {
            $message->
            $message->from('UntTesoreria@unitru.com', 'Universidad Nacional de Trujillo - Tesoreria');
            $message->to('theoithy@gmail.com', 'Arthur Alfaro')->subject('Boleta Virtual - Universidad Nacional de Trujillo - Tesoreria');
        });
    }
}
