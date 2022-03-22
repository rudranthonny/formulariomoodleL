<?php

namespace App\Http\Livewire;

use App\Models\Inicio;
use App\Models\Inscripcion;
use App\Models\Matricula;
use App\Models\Programa;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class RegistrarUsuario2 extends Component
{
    private $token = 'fc410318b59368f9245b394b209c644e';
    private $domainname = 'https://learclass.com';
    public $usuario;
    public $name,$lastname,$email,$phone,$dni,$country = "AR";
    public $programa_id;
    public $inicio_id;
    protected $rules = [
        'name' => 'required',
        'lastname' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'dni' => 'required',
        'country' => 'required',
    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function registrarinscripcion(){
        $this->validate();
        //convertir en minusculas
        $emaila = strtolower($this->email);
        /*verificar si ya se realizo la inscripción*/
        $rinscripcion = Inscripcion::where('email',$emaila)->first();
        if($rinscripcion == false){
            /*crear usuario en moodle*/
            $functionname = 'core_user_create_users';
            $serverurl = $this->domainname. '/webservice/rest/server.php'
            . '?wstoken=' . $this->token 
            . '&wsfunction='.$functionname
            .'&moodlewsrestformat=json&users[0][username]='.$emaila.'&users[0][password]=123456789&users[0][firstname]='.$this->name.'&users[0][lastname]='.$this->lastname.'&users[0][email]='.$emaila.'&users[0][phone1]='.$this->phone.'&users[0][country]='.$this->country;
            Http::get($serverurl);
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
            
            if (isset($user->id)) {
                /*agregar cohorte*/
                $functionname = 'core_cohort_add_cohort_members';
                $serverurl2 = $this->domainname . '/webservice/rest/server.php'
                . '?wstoken=' . $this->token 
                . '&wsfunction='.$functionname
                .'&moodlewsrestformat=json&members[0][cohorttype][type]=id&members[0][cohorttype][value]=2&members[0][usertype][type]=id&members[0][usertype][value]='.$user->id;
                 Http::get($serverurl2);
            }
            else{
            /*registrar el estudiante en laravel*/
            //obtener el id del usuario
            $functionname2 = 'core_user_get_users';
            $serverurl2 = $this->domainname. '/webservice/rest/server.php'
            . '?wstoken=' . $this->token 
            . '&wsfunction='.$functionname2
            .'&moodlewsrestformat=json&criteria[0][key]=username&criteria[0][value]='.$emaila;
            $consulta = Http::get($serverurl2);
            foreach (json_decode($consulta)->users as $user) {
            }
             /*agregar cohorte*/
             $functionname = 'core_cohort_add_cohort_members';
             $serverurl2 = $this->domainname . '/webservice/rest/server.php'
             . '?wstoken=' . $this->token 
             . '&wsfunction='.$functionname
             .'&moodlewsrestformat=json&members[0][cohorttype][type]=id&members[0][cohorttype][value]=2&members[0][usertype][type]=id&members[0][usertype][value]='.$user->id;
              Http::get($serverurl2);
            }
            //realizar la instancia
            $n_inscripcion = new Inscripcion();
            $n_inscripcion->name = $this->name;
            $n_inscripcion->lastname =$this->lastname;
            $n_inscripcion->email = $emaila;
            $n_inscripcion->phone = $this->phone;
            $n_inscripcion->dni = $this->dni;
            $n_inscripcion->user_id = $user->id;
            $n_inscripcion->politicas = '1';
            $n_inscripcion->country = $this->country;
            $n_inscripcion->cajero_id = auth()->user()->id;
            $n_inscripcion->save();
            $n_inscripcion->inicios()->attach($this->inicio_id);
            /*realizar matricula*/
            /*obtener datos*/
            $sprograma = Programa::find($this->programa_id);
            /*realizar matricula*/
            $matricula = new Matricula();
            $matricula->name = $n_inscripcion->name;
            $matricula->lastname = $n_inscripcion->lastname;
            $matricula->user_id = $n_inscripcion->user_id;
            //falta matricula
            $matricula->costo = $sprograma->costo;
            $matricula->programa_id = $sprograma->id;
            $matricula->tipo = 'Soles';
            $matricula->inscripcion_id = $n_inscripcion->id;
            $matricula->cajero_id = auth()->user()->id;
            $matricula->save();
            /*agregar cohorte*/
            $functionname = 'core_cohort_add_cohort_members';
            $serverurl = $this->domainname . '/webservice/rest/server.php'
            . '?wstoken=' . $this->token 
            . '&wsfunction='.$functionname
            .'&moodlewsrestformat=json&members[0][cohorttype][type]=id&members[0][cohorttype][value]='.$sprograma->cohort.'&members[0][usertype][type]=id&members[0][usertype][value]='.$user->id;
            $usuario = Http::get($serverurl);
            $this->bprograma = $this->bprograma;
        }
        else 
        {
            /*actualizar inscripcion*/
        $actualizar = Inscripcion::find($rinscripcion->id);
        $inscrito = false;
        foreach ($actualizar->inicios as $minicio) {
            if ($minicio->id == $this->inicio_id) {
                $inscrito = true;
            }
        }
        if($inscrito == false){
            $actualizar->inicios()->attach($this->inicio_id);
        }
        $actualizar->update([
            'name' => $this->name,
            'lastname' => $this->lastname,
            'email' => $emaila,
            'phone' => $this->phone,
            'dni' => $this->dni,
            'country' => $this->country,
        ]);
        /*actualizar en el moodle*/
        $functionname = 'core_user_update_users';
        $serverurl = $this->domainname. '/webservice/rest/server.php'
        . '?wstoken=' . $this->token 
        . '&wsfunction='.$functionname
        .'&moodlewsrestformat=json&users[0][id]='.$actualizar->user_id.'&users[0][firstname]='.$this->name.'&users[0][lastname]='.$this->lastname.'&users[0][phone1]='.$this->phone.'&users[0][country]='.$this->country;
        Http::get($serverurl);
        }
        
        $this->reset('name','lastname','email','phone','dni','country');
        $this->emitTo('mostrar-inscripciones','render');
        $this->emit('crearinscripcion');
    }

    public function render()
    {
        if($this->programa_id == null){
            $sprograma = Inicio::where('estado',1)->first();
            $this->programa_id = $sprograma->id;
        }

        if($this->inicio_id == null){
            $sinicio = Inicio::where('estado',1)->first();
            $this->inicio_id = $sinicio->id;
        }
        $emaila = strtolower($this->email);
        $programas = Programa::all();
        $inicios = Inicio::all();
        $consulta = Inscripcion::where('email',$emaila)->first();
        if (isset($consulta)) {
            $this->name = $consulta->name;
            $this->lastname = $consulta->lastname;
            $this->dni = $consulta->dni;
            $this->phone = $consulta->phone;
            $this->country = $consulta->country;
        }
        return view('livewire.registrar-usuario2',compact('inicios','programas'));
    }
}
