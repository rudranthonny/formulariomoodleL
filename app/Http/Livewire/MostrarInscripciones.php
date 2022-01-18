<?php

namespace App\Http\Livewire;

use App\Models\Inicio;
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
    public $binicio;
    public $blista="30";
    public $sort = "id";
    public $direction = "desc";
    /**editar**/
    public $ename,$elastname,$euser_id,$ecosto,$eagente,$etipo,$efechapago,$ecomprobante,$ecomprobante_imagen,$eprograma_id;
    /**end**/
    protected $listeners =['render','eliminar_inscripcion'];
    
    public function editarmatricula($id_matricula){
       $ematricula = Matricula::find($id_matricula);
       $this->ename = $ematricula->name;
       $this->elastname = $ematricula->lastname;
       $this->euser_id = $ematricula->user_id;
       $this->ecosto = $ematricula->costo;
       $this->eagente = $ematricula->agente;
       $this->etipo = $ematricula->tipo;
       $this->efechapago = $ematricula->fechapago;
       $this->ecomprobante  = $ematricula->comprobante;
       $this->ecomprobante_imagen = $ematricula->comprobante_imagen;
       $this->eprograma_id = $ematricula->programa_id;
    }

    public function eliminar_inscripcion($id_inscripcion){
        $e_inscripcion = Inscripcion::find($id_inscripcion);
        $e_inscripcion->delete();
    }
    public function matricularprograma($id_usuario){
        /*obtener datos*/
        $usuario = Inscripcion::find($id_usuario);
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
        ->where('inicio_id',$this->binicio)
        ->paginate($this->blista);
        $matriculas = Matricula::where('programa_id',$this->bprograma)->get();
        $programas = Programa::all();
        $inicios = Inicio::all();
        return view('livewire.mostrar-inscripciones',compact('inscripciones','matriculas','programas','inicios'));
    }
}
