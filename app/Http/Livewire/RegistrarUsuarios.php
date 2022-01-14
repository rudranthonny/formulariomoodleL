<?php

namespace App\Http\Livewire;

use App\Models\Inscripcion;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class RegistrarUsuarios extends Component
{   private $token = 'fc410318b59368f9245b394b209c644e';
    private $domainname = 'https://learclass.com';
    public $name,$lastname,$email,$phone,$dni,$country;
    protected $rules = [
        'name' => 'required',
        'lastname' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'dni' => 'required',
        'country' => 'required',
    ];
    public function updated($propertyName){
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
                'name' => $this->name,
                'lastname' => $this->lastname,
                'email' => $emaila,
                'phone' => $this->phone,
                'dni' => $this->dni,
                'user_id' => $user->id,
                'politicas' => '1',
                'country' => $this->country,
            ]);
        }
        else 
        {
            /*actualizar inscripcion*/
        $actualizar = Inscripcion::find($rinscripcion->id);
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
        $emaila = strtolower($this->email);
        $consulta = Inscripcion::where('email',$emaila)->first();
        if (isset($consulta)) {
            $this->name = $consulta->name;
            $this->lastname = $consulta->lastname;
        }
            return view('livewire.registrar-usuarios',compact('consulta'));
    }
}
