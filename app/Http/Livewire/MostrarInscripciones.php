<?php

namespace App\Http\Livewire;

use App\Models\Inicio;
use App\Models\Inscripcion;
use App\Models\Matricula;
use App\Models\Programa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class MostrarInscripciones extends Component
{
    use WithFileUploads;
    use WithPagination;
    private $token = 'fc410318b59368f9245b394b209c644e';
    private $domainname = 'https://learclass.com';
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $bprograma;
    public $bmatriculado;
    public $binicio;
    public $blista="30";
    public $sort = "id";
    public $direction = "desc";
    /**editar**/
    public $eid,$ename,$elastname,$euser_id,$ecosto,$eagente,$etipo,$efechapago,$ecomprobante,$ecomprobante_imagen,$ecomprobante_imagen_file,$eprograma_id;
    /**end**/
    protected $listeners =['render','eliminar_inscripcion'];
    
    public function editarmatricula($id_matricula){
       $ematricula = Matricula::find($id_matricula);
       $this->eid = $ematricula->id;
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
    public function actualizarmatriculas(){
        $mmatricula = Matricula::find($this->eid);
        $mmatricula->costo = $this->ecosto;
        $mmatricula->agente = $this->eagente;
        $mmatricula->tipo =$this->etipo;
        $mmatricula->fechapago = $this->efechapago;
        $mmatricula->comprobante = $this->ecomprobante;
        $mmatricula->save();
        //actualizar el comprobante_imagen de la tabla matricula
        $mmatricula = Matricula::find($this->eid);
        if($this->ecomprobante_imagen_file != null)
        {
                $extension = $this->ecomprobante_imagen_file->extension();
                $eliminar = str_replace('storage','public',$mmatricula->comprobante_imagen);
                Storage::delete([$eliminar]);
                $imagenenu = $this->ecomprobante_imagen_file->storeAs('public/comprobantes',$mmatricula->user_id."-".rand(1,2000).str_replace(' ', '', $mmatricula->comprobante).".".$extension);
                $url = Storage::url($imagenenu);
                $mmatricula->update(['comprobante_imagen' => $url]);
                $this->ecomprobante_imagen = $mmatricula->comprobante_imagen;
        }
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
        if ($this->bmatriculado == "nomatriculados") {
            $inscripciones = DB::table('inscripcions')
            ->where('inicio_id',$this->binicio)
            ->whereNotExists(function ($query) {
                $query->select(DB::raw('NULL'))
                      ->from('matriculas')
                      ->whereColumn('inscripcions.user_id', 'matriculas.user_id');
            })->paginate($this->blista);
        }
        else{
            $inscripciones = Inscripcion::where('name','like','%' . $this->search.'%')
            ->where('inicio_id',$this->binicio)
            ->paginate($this->blista);
        }
       
       
        
       
       
        $matriculas = Matricula::where('programa_id',$this->bprograma)->get();
        $programas = Programa::all();
        $inicios = Inicio::all();
        return view('livewire.mostrar-inscripciones',compact('inscripciones','matriculas','programas','inicios'));
    }
}
