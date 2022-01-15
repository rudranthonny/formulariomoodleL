<?php

namespace App\Imports;

use App\Models\Inicio;
use App\Models\Inscripcion;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class InscripcionesImport implements ToCollection
{
    private $token = 'fc410318b59368f9245b394b209c644e';
    private $domainname = 'https://learclass.com';
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {   
        $contador = 0;
         //instaciar inicio
         $inicio = Inicio::where('estado',1)->first();
        foreach ($rows as $row) 
        {   
            $contador = $contador +1;
            if ($contador == 1) {} 
            else 
            {
                Inscripcion::create([
                    'name' => $row[0],
                    'lastname'=> $row[1],
                    'email'=> $row[2],
                    'phone'=> $row[3],
                    'dni'=> $row[4],
                    'user_id'=>$row[8],
                    'politicas'=> $row[6],
                    'country'=> $row[5],
                    'inicio_id' => $row[7],
                ]);
            }
        }
    }
}
