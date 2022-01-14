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
    ];

    //rel 1 a n
    //rel 1 a n
    public function matriculas(){
        return $this->hasMany(Matricula::class);
    }
}
