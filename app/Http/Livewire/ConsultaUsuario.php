<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class ConsultaUsuario extends Component
{
    private $token = 'fc410318b59368f9245b394b209c644e';
    private $domainname = 'https://learclass.com';
    public $username="";
    public $usuario;
    
    public function render()
    {
        $functionname = 'core_user_get_users';
        $serverurl = $this->domainname . '/webservice/rest/server.php'
        . '?wstoken=' . $this->token 
        . '&wsfunction='.$functionname
        .'&moodlewsrestformat=json&criteria[0][key]=lastname&criteria[0][value]=%'.$this->username;
        
        $this->usuario = json_decode(Http::get($serverurl))->users;
        return view('livewire.consulta-usuario');
    }
}
