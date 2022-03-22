<?php

namespace App\Http\Livewire;

use App\Mail\TestMail;
use App\Models\Inscripcion;
use App\Models\Matricula;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowMatriculas2 extends Component
{   use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search2;
    public $iteration;
    public $fecha_inicio;
    public $fecha_final;
    /**editar**/
    public $eid,$ename,$elastname,$euser_id,$ecosto,$eagente,$efechapago,$ecomprobante,$ecomprobante_imagen,$ecomprobante_imagen_file,$eprograma_id;
    public $etipo = "Soles";
    /**end**/
    protected $listeners =['render'];

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
    
    public function render()
    {
        if($this->fecha_inicio != null and $this->fecha_final != null){
            $matriculas = Matricula::where('cajero_id',auth()->user()->id)->where('name','like','%' .$this->search2.'%')->where('fechapago','>=',$this->fecha_inicio)->where('fechapago','<=',$this->fecha_final)
            ->orwhere('cajero_id',auth()->user()->id)->where('lastname','like','%' .$this->search2.'%')->where('fechapago','>=',$this->fecha_inicio)->where('fechapago','<=',$this->fecha_final)
            ->paginate(10);
        }
        else{
            $matriculas = Matricula::where('cajero_id',auth()->user()->id)->where('name','like','%' .$this->search2.'%')
            ->orwhere('cajero_id',auth()->user()->id)->where('lastname','like','%' .$this->search2.'%')
            ->paginate(10);
        }
        return view('livewire.show-matriculas2',compact('matriculas'));
    }
}
