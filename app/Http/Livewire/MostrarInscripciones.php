<?php

namespace App\Http\Livewire;

use App\Models\Inscripcion;
use Livewire\Component;

class MostrarInscripciones extends Component
{
    protected $listeners =['render' => 'render'];
    public function render()
    {
        $inscripciones = Inscripcion::all();
        return view('livewire.mostrar-inscripciones',compact('inscripciones'));
    }
}
