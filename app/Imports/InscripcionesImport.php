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
                $emaila = strtolower($row[2]);
                //verificar si ya se realizo la inscripción
                $rinscripcion = Inscripcion::where('email',$emaila)->first();
                if($rinscripcion == false){
                //return $request->input('politicas');
                //crear usuario en moodle
                $functionname = 'core_user_create_users';
                $serverurl = $this->domainname. '/webservice/rest/server.php'
                . '?wstoken=' . $this->token 
                . '&wsfunction='.$functionname
                .'&moodlewsrestformat=json&users[0][username]='.$emaila.'&users[0][password]=123456789&users[0][firstname]='.$row[0].'&users[0][lastname]='.$row[1].'&users[0][email]='.$emaila.'&users[0][phone1]='.$row[3].'&users[0][country]='.$row[6];
                $usuario = Http::get($serverurl);
                /*registrar el estudiante en laravel*/
                //obtener el id del usuario
                $functionname2 = 'core_user_get_users';
                $serverurl2 = $this->domainname. '/webservice/rest/server.php'
                . '?wstoken=' . $this->token 
                . '&wsfunction='.$functionname2
                .'&moodlewsrestformat=json&criteria[0][key]=email&criteria[0][value]='.$emaila;
                
                $consulta = Http::get($serverurl2);
                foreach (json_decode($consulta)->users as $user) {
                }
                //realizar la instancia
                Inscripcion::create([
                    'name' => $row[0],
                    'lastname'=> $row[1],
                    'email'=> $emaila,
                    'phone'=> $row[3],
                    'dni'=> $row[4],
                    'user_id'=> $user->id,
                    'politicas'=> $row[6],
                    'country'=> $row[5],
                    'inicio_id' => $row[7],
                ]);
                }
                else{
                /*actualizar inscripcion*/
                $actualizar = Inscripcion::find($rinscripcion->id);
                $actualizar->update([
                'name' => $row[0],
                'lastname'=> $row[1],
                'phone'=> $row[3],
                'dni'=> $row[4],
                'politicas'=> $row[6],
                'country'=> $row[5],
                'inicio_id' => $row[7],
                'user_id'=> $row[8],
                ]);
                /*actualizar en el moodle*/
                $functionname = 'core_user_update_users';
                $serverurl = $this->domainname. '/webservice/rest/server.php'
                . '?wstoken=' . $this->token 
                . '&wsfunction='.$functionname
                .'&moodlewsrestformat=json&users[0][id]='.$actualizar->user_id.'&users[0][password]=123456789&users[0][firstname]='.$row[0].'&users[0][lastname]='.$row[1].'&users[0][phone1]='.$row[3].'&users[0][country]='.$row[6];
                Http::get($serverurl);
                }
            }
        }
    }
}
