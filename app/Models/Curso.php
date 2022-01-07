<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Plantilla;

class Curso extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'shortname',
    ];
    public function plantillas(){
        return $this->belongsToMany(Plantilla::class);
    }
}
