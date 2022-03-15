<?php

namespace App\Http\Livewire;

use App\Models\Matricula;
use App\Models\User;
use Livewire\Component;

class ReporteCajero extends Component
{
    public  $fecha_inicio,$fecha_final;

    public function render()
    {
        $usuarioadmin = new User();
        $usuarioadmin->name = 'cajera1';
        $usuarioadmin->email = 'cajera1@learclass.com';
        $usuarioadmin->password = bcrypt('cajera1@learclass.com');
        $usuarioadmin->save();
        if($this->fecha_inicio != null and $this->fecha_final != null)
        {
            $matriculas = Matricula::all()
            ->where('cajero_id',auth()->user()->id)
            ->where('fechapago','>=',$this->fecha_inicio)
            ->where('fechapago','<=',$this->fecha_final);
        }
        else
        {
            $matriculas = Matricula::all()
            ->where('cajero_id',auth()->user()->id);
        }
        return view('livewire.reporte-cajero',compact('matriculas'));
    }
}
