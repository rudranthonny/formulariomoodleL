<?php

namespace App\Http\Livewire;

use App\Mail\TestMail;
use App\Models\Inicio;
use App\Models\Inscripcion;
use App\Models\Matricula;
use App\Models\Programa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
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
    public $bprograma="no";
    public $bmatriculado="todos";
    public $inscripciones;
    public $inscripciones2;
    public $binicio="no";
    public $bestado="";
    public $bagente="";
    public $iteration;
    public $blista="30";
    public $sort = "id";
    public $direction = "desc";
    /**editar**/
    public $eid,$ename,$elastname,$euser_id,$ecosto,$eagente,$efechapago,$ecomprobante,$ecomprobante_imagen,$ecomprobante_imagen_file,$eprograma_id;
    public $etipo = "Soles";
    /**end**/
    protected $listeners =['render','eliminar_inscripcion'];
    
    public function enviarmensaje($estudiante_id)
    {
        $inscripcion = Inscripcion::find($estudiante_id);
        $details =[
            'name' => $inscripcion->name." ".$inscripcion->lastname,
            'usuario' => $inscripcion->email,
        ];
        Mail::to($inscripcion->email)->send(new TestMail($details));
    }
    
    public function editarmatricula($id_matricula){
       $ematricula = Matricula::find($id_matricula);
       $this->eid = $ematricula->id;
       $this->ename = $ematricula->name;
       $this->elastname = $ematricula->lastname;
       $this->euser_id = $ematricula->user_id;
       $this->ecosto = $ematricula->costo;
       $this->eagente = $ematricula->agente;
       if ($ematricula->tipo == null) {
        $this->etipo = "Soles";
       }
       else{
        $this->etipo = $ematricula->tipo;
       }
       $this->efechapago = $ematricula->fechapago;
       $this->ecomprobante  = $ematricula->comprobante;
       $this->ecomprobante_imagen = $ematricula->comprobante_imagen;
       $this->eprograma_id = $ematricula->programa_id;
       //clean up
       $this->ecomprobante_imagen_file = null;
       $this->iteration++;
    }
    public function actualizarmatriculas(){
        $mmatricula = Matricula::find($this->eid);
        $mmatricula->costo = $this->ecosto;
        $mmatricula->agente = $this->eagente;
        $mmatricula->tipo =$this->etipo;
        $mmatricula->fechapago = $this->efechapago;
        $mmatricula->comprobante = $this->ecomprobante;
        $mmatricula->cajero_id = auth()->user()->id;
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
                $this->ecomprobante_imagen_file = null;
                $this->iteration++;
        }
    }

    public function eliminar_inscripcion($id_inscripcion)
    {
        $e_inscripcion = Inscripcion::find($id_inscripcion);
        $e_inscripcion->inicios()->detach($this->binicio);
    }
    public function matricularprograma($id_usuario)
    {
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
        $matricula->tipo = 'Soles';
        $matricula->inscripcion_id = $id_usuario;
        $matricula->cajero_id = auth()->user()->id;
        $matricula->save();
        /*agregar cohorte*/
        $functionname = 'core_cohort_add_cohort_members';
        $serverurl = $this->domainname . '/webservice/rest/server.php'
        . '?wstoken=' . $this->token 
        . '&wsfunction='.$functionname
        .'&moodlewsrestformat=json&members[0][cohorttype][type]=id&members[0][cohorttype][value]='.$sprograma->cohort.'&members[0][usertype][type]=id&members[0][usertype][value]='.$usuario->user_id;
        $usuario = Http::get($serverurl);
        $this->bprograma = $this->bprograma;
    }
    public function render()    
    {  /* 
        if ($this->bmatriculado == "nomatriculados") {
            $inscripciones = DB::table('inscripcions')
            ->where('inicio_id',$this->binicio)
            ->whereNotExists(function ($query) {
                $query->select(DB::raw('NULL'))
                      ->from('matriculas')
                      ->whereColumn('inscripcions.user_id', 'matriculas.user_id')
                      ->where('matriculas.programa_id',$this->bprograma);
            })->paginate($this->blista);
        }
        elseif($this->bestado == "pagante" && $this->bmatriculado == "matriculados"){
          
            $inscripciones = DB::table('inscripcions')
            ->where('inicio_id',$this->binicio)
            ->whereExists(function ($query) {
                $query->select(DB::raw('*'))
                      ->from('matriculas')
                      ->whereColumn('inscripcions.user_id', 'matriculas.user_id')
                      ->wherenotnull('matriculas.comprobante_imagen')
                      ->where('matriculas.programa_id',$this->bprograma)
                      ->where('agente','like','%'.$this->bagente.'%');
            })->paginate($this->blista);
        }
        elseif($this->bestado == "deudor" && $this->bmatriculado == "matriculados"){
            $inscripciones = DB::table('inscripcions')
            ->where('inicio_id',$this->binicio)
            ->whereExists(function ($query) {
                $query->select(DB::raw('*'))
                      ->from('matriculas')
                      ->whereColumn('inscripcions.user_id', 'matriculas.user_id')
                      ->wherenull('matriculas.comprobante_imagen')
                      ->where('matriculas.programa_id',$this->bprograma);
            })->paginate($this->blista);
        }
        elseif ($this->bmatriculado == "matriculados" && $this->bestado == "") {
            $inscripciones = DB::table('inscripcions')
            ->where('inicio_id',$this->binicio)
            ->whereExists(function ($query) {
                $query->select(DB::raw('*'))
                      ->from('matriculas')
                      ->whereColumn('inscripcions.user_id', 'matriculas.user_id')
                      ->where('matriculas.programa_id',$this->bprograma);
            })->paginate($this->blista);
        }
       
        else{
            $inscripciones = Inscripcion::where('name','like','%' . $this->search.'%')
            ->where('inicio_id',$this->binicio)
            ->paginate($this->blista);
        }
       
       */
      if($this->binicio == "no"){
        $this->inscripciones = "";
       }
       /*-------------------------*/
       if(($this->binicio != "no") && ($this->bmatriculado == "todos")){
        $inicio = Inicio::find($this->binicio);
        $this->inscripciones = $inicio->inscripcions;
       }
       /*-------------------------*/
       if ($this->bmatriculado == "matriculados"  && $this->binicio != null && $this->bprograma != "no" && $this->bestado=="") 
        {   //aca solo los matriculados
            //$this->inscripciones = Matricula::all()->where('programa_id',$this->bprograma);
            $inicio = Inicio::find($this->binicio);
            $this->inscripciones = $inicio->inscripcions;
        }
        /*-------------------------*/
       if ($this->bmatriculado == "matriculados"  && $this->binicio != null && $this->bprograma != "no" && $this->bestado=="pagante" && $this->bagente == "") {
        $this->inscripciones = Matricula::all()->where('programa_id',$this->bprograma)->where('comprobante',"<>",null);  
        }

       if ($this->bmatriculado == "matriculados"  && $this->binicio != null && $this->bprograma != "no" && $this->bestado=="pagante" && $this->bagente != "" ) {
            $this->inscripciones = Matricula::all()->where('programa_id',$this->bprograma)->where('comprobante',"<>",null)->where('agente',$this->bagente);
       }
       
       if ($this->bmatriculado == "matriculados"  && $this->binicio != null && $this->bprograma != "no" && $this->bestado=="deudor") 
       {
        $this->inscripciones = Matricula::all()->where('programa_id',$this->bprograma)->where('comprobante',null);           
        }

       if ($this->bmatriculado == "nomatriculados" && $this->binicio != null && $this->bprograma != "no") {
        $this->inscripciones = DB::table('inscripcions')
        ->join('inicio_inscripcion', 'inicio_inscripcion.inscripcion_id', '=', 'inscripcions.id')
        ->where('inicio_inscripcion.inicio_id',$this->binicio)
        ->whereNotExists(function ($query) {
            $query->select(DB::raw('*'))
                  ->from('matriculas')
                  ->whereColumn('inscripcions.id', 'matriculas.inscripcion_id')
                  ->where('matriculas.programa_id',$this->bprograma);
        })->get();
       }
        $matriculas = Matricula::where('programa_id',$this->bprograma)->get();
        $programas = Programa::all();
        $inicios = Inicio::all();
        return view('livewire.mostrar-inscripciones',compact('matriculas','programas','inicios'));
    }
}
