<?php

namespace App\Http\Livewire;

use App\Models\Inicio;
use App\Models\Inscripcion;
use Livewire\Component;

class ConsultarInscripcion extends Component
{
    public $search = '';
    public $inscripcion;
    public $inicio;
    public function render()
    {
        //consulta la existencia de un inicio en el caso de que no existe procede a crear uno
        $this->inicio = Inicio::where('estado',1)->first();
            //crear un inicio en caso se necesita
            if($this->inicio == false){
               $cinicio = new Inicio;
               $cinicio->name = "Programa 0";
               $cinicio->estado = "1";
               $cinicio->save();
            $this->inicio = Inicio::where('estado',1)->first();
        }
        
        $consulta = Inscripcion::where('email',$this->search)->first();
        $this->inscripcion = isset($consulta) ? $consulta : $this->inscripcion;
        return view('livewire.consultar-inscripcion');
    }
}
