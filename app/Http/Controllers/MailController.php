<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use App\Models\Inscripcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendEmail($estudiante_id){
        $inscripcion = Inscripcion::find($estudiante_id);
        $details =[
            'name' => $inscripcion->name." ".$inscripcion->lastname,
            'usuario' => $inscripcion->email,
        ];
        Mail::to($inscripcion->email)->send(new TestMail($details));
        return "Correo Electronico Enviado";
    }
}
