<?php

namespace App\Http\Livewire;

use App\Models\Inscripcion;
use App\Models\Matricula;
use App\Models\Programa;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;

class MostrarInscripciones extends Component
{
    use WithPagination;
    private $token = 'fc410318b59368f9245b394b209c644e';
    private $domainname = 'https://learclass.com';
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $bprograma;
    public $blista="30";
    public $sort = "id";
    public $direction = "desc";
    protected $listeners =['render'];
    
    public function matricularprograma($id_usuario){
        /*obtener datos*/
        $usuario = Inscripcion::find($id_usuario);
        dd($this->bprograma);
        $sprograma = Programa::find($this->bprograma);
        /*realizar matricula*/
        $matricula = new Matricula();
        $matricula->name = $usuario->name;
        $matricula->lastname = $usuario->lastname;
        $matricula->user_id = $usuario->user_id;
        $matricula->costo = $sprograma->costo;
        $matricula->programa_id = $sprograma->id;
        $matricula->save();
        /*agregar cohorte*/
        $functionname = 'core_cohort_add_cohort_members';
        $serverurl = $this->domainname . '/webservice/rest/server.php'
        . '?wstoken=' . $this->token 
        . '&wsfunction='.$functionname
        .'&moodlewsrestformat=json&members[0][cohorttype][type]=id&members[0][cohorttype][value]='.$sprograma->cohort.'&members[0][usertype][type]=id&members[0][usertype][value]='.$usuario->user_id;
        $usuario = Http::get($serverurl);
    }
    public function render()
    {
        $inscripciones = Inscripcion::where('name','like','%' . $this->search.'%')
        ->orwhere('lastname','like','%' . $this->search.'%')
        ->orwhere('email','like','%' . $this->search.'%')
        ->orwhere('dni','like','%' . $this->search.'%')
        ->orwhere('phone','like','%' . $this->search.'%')
        ->orderBy($this->sort, $this->direction)
        ->paginate($this->blista);
        $matriculas = Matricula::where('programa_id','like','%' . $this->bprograma.'%')->get();
        $programas = Programa::all();
        return view('livewire.mostrar-inscripciones',compact('inscripciones','matriculas','programas'));
    }
}
