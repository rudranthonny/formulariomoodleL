<?php

namespace App\Imports;

use App\Models\Matricula;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class MatriculasImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {   $contador = 0;
        foreach ($rows as $row) 
        {  
            $contador = $contador +1;
            if ($contador == 1) {} 
            else 
            {
        Matricula::create([
            'name' => $row[0],
            'lastname'=> $row[1],
            'user_id'=> $row[2],
            'costo'=> $row[3],
            'agente'=> $row[4],
            'tipo'=> $row[5],
            'fechapago'=> $row[6],
            'comprobante'=> $row[7],
            'comprobante_imagen' => $row[8],
            'Programa_id' => $row[9],
        ]);
            }
        }
    }
}
