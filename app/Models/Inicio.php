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
        'shortname',
        'plantilla_id',
    ];
    //rel inv 1 a n
    public function plantilla(){
        return $this->belongsTo(Plantilla::class);
    }
}
