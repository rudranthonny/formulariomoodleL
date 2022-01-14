<?php

namespace App\Http\Livewire;

use App\Models\Inscripcion;
use App\Models\Matricula;
use Livewire\Component;
use Livewire\WithPagination;

class MostrarInscripciones extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $sort = "id";
    public $direction = "desc";
    protected $listeners =['render'];
    
    public function render()
    {
        $inscripciones = Inscripcion::where('name','like','%' . $this->search.'%')
        ->orwhere('lastname','like','%' . $this->search.'%')
        ->orwhere('email','like','%' . $this->search.'%')
        ->orwhere('dni','like','%' . $this->search.'%')
        ->orwhere('phone','like','%' . $this->search.'%')
        ->orderBy($this->sort, $this->direction)
        ->paginate(10);
        $matriculas = Matricula::all();
        return view('livewire.mostrar-inscripciones',compact('inscripciones','matriculas'));
    }
}
