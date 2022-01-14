<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class ConsultaUsuario extends Component
{
    private $token = 'ff63b816357ee3098eb0504de43be96c';
    private $domainname = 'https://jademlearning.com/aula5';
    public $username="";
    public $usuario;
    protected $listeners =['render' => 'render'];
    
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
