<?php

namespace App\Http\Livewire;

use App\Models\Matricula;
use Livewire\Component;

class ShowMatriculas2 extends Component
{
    public function render()
    {
        $matriculas = Matricula::where('cajero_id',auth()->user()->id);
        return view('livewire.show-matriculas2',compact('matriculas'));
    }
}
