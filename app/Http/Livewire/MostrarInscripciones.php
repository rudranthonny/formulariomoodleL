<?php

namespace App\Http\Livewire;

use App\Models\Inscripcion;
use App\Models\Matricula;
use App\Models\Programa;
use Livewire\Component;
use Livewire\WithPagination;

class MostrarInscripciones extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $bprograma;
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
        ->paginate(300);
        $matriculas = Matricula::where('programa_id','like','%' . $this->bprograma.'%')->get();
        $programas = Programa::all();
        return view('livewire.mostrar-inscripciones',compact('inscripciones','matriculas','programas'));
    }
}
