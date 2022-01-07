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
        'programa_id',
        'agente',
        'comprobante',
        'tipo',
        'fechapago',
    ];

    //rel 1 a n
    public function programa(){
        return $this->belongsTo(Programa::class);
    }
}
