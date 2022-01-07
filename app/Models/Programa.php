<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'costo',
        'cohort',
    ];
    //rel 1 a n
    public function matriculas(){
        return $this->hasMany(Matricula::class);
    }
}
