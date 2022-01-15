<?php

namespace App\Http\Livewire;

use App\Imports\MatriculasImport;
use Exception;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class SubirMatriculas extends Component
{
    use WithFileUploads;
    public $matriculas;
    public $resultado2;
    public $mensaje;
    public function subirmatriculas(){
        
        if (isset($this->matriculas)) {
            try{
                //realizar la importacioón
                Excel::import(new MatriculasImport,$this->matriculas);
                $this->resultado2 = "Importacion de Usuarios Completada";
                $success = "true";
            }
            catch (Exception $th){
                $this->resultado2 = "Error en importacion \n";
                if(isset($th->errorInfo[2])){
                    $this->resultado2 .= str_replace(["Undefined index", "Duplicate entry", "for key", "alumnos.alumnos_", "_unique"], ["Falta la columna", "Entrada duplicada", "para la clave", "", ""], $th->errorInfo[2]);
                }else{
                    $this->resultado2 .= str_replace(["Undefined index"], ["Falta la columna"], $th->getMessage());
                }
                $success = "false";
            }
        } else {
            $this->message = "Por favor ingrese un archivo csv, con la informacion requerida";
        }
    }
    public function render()
    {
        return view('livewire.subir-matriculas');
    }
}
