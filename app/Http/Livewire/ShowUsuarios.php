<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class ShowUsuarios extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $roles;
    public $sort = "id";
    public $direction = "asc";
    public function render()
    {
        $this->roles = Role::all();
        $usuarios = User::where('name','like','%' . $this->search.'%')
        ->orderBy($this->sort, $this->direction)
        ->paginate(6);
        return view('livewire.show-usuarios',compact('usuarios'));
    }
    public function order($sort){
        if ($this->sort == $sort)
        {
            if($this->direction == 'asc'){
                $this->direction ='desc';
            }

            else {
                $this->direction = 'asc';
            }
        }
        else{
            $this->sort = $sort;
            $this->direction ='desc';
        }
    }
    public function updatingSearch(){
        $this->resetPage();
    }
}