<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'lastname',
        'email',
        'phone',
        'dni',
        'user_id',
        'politicas',
        'country',
        'inicio_id'
    ];

    //rel 1 a n inverso
    public function inicio(){
        return $this->belongsTo(Inicio::class);
    }
}
