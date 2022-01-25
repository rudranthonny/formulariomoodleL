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

   //relacion de muchos a muchos
   public function inicios(){
    return $this->belongsToMany(Inicio::class);
    }

    public function matriculas(){
    return $this->hasMany(Matricula::class);
    }
}

