<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Plantilla;

class Inicio extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'estado',
        'inicio_imagen',
        'inicio_imagen_fondo',
    ];
    //rel inv 1 a n
    public function plantilla(){
        return $this->belongsTo(Plantilla::class);
    }
    //relacion de muchos a muchos
    public function inscripcions(){
        return $this->belongsToMany(Inscripcion::class);
    }
}
