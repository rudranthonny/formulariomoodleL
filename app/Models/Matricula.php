<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'lastname',
        'user_id',
        'costo',
        'agente',
        'tipo',
        'fechapago',
        'comprobante',
        'comprobante_imagen',
        'programa_id',
        'cajero_id',
    ];

    //rel 1 a n
    public function programa(){
        return $this->belongsTo(Programa::class);
    }

    public function inscripcion(){
        return $this->belongsTo(Inscripcion::class);
    }
}
