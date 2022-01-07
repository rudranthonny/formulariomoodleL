<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Curso;
use App\Models\Inicio;

class Plantilla extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'shortname',
    ];

    //rel n a n
    public function cursos(){
        return $this->belongsToMany(Curso::class);
    }
    //rel 1 a n
    public function inicios(){
        return $this->hasMany(Inicio::class);
    }
}
