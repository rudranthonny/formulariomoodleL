<?php

namespace App\Http\Livewire;

use App\Models\Inscripcion;
use Livewire\Component;

class ConsultarInscripcion extends Component
{
    public $search = '';
    public $inscripcion;
    public function render()
    {
        $consulta = Inscripcion::where('email',$this->search)->first();
        $this->inscripcion = isset($consulta) ? $consulta : $this->inscripcion;
        return view('livewire.consultar-inscripcion');
    }
}
