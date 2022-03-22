<?php

namespace App\Http\Livewire;

use App\Models\Matricula;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ShowMatriculas2 extends Component
{
    public $iteration;
    
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
        $matriculas = Matricula::all()->where('cajero_id',auth()->user()->id);
        return view('livewire.show-matriculas2',compact('matriculas'));
    }
}
