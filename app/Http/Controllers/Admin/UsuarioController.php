<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Matricula;
use App\Models\Programa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade as PDF;

class UsuarioController extends Controller
{
    private $token = 'fc410318b59368f9245b394b209c644e';
    private $domainname = 'https://learclass.com';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $username = "";
        $functionname = 'core_user_get_users';
        $serverurl = $this->domainname . '/webservice/rest/server.php'
        . '?wstoken=' . $this->token 
        . '&wsfunction='.$functionname
        .'&moodlewsrestformat=json&criteria[0][key]=lastname&criteria[0][value]=%'.$username;
        $usuario = Http::get($serverurl);
        //return $usuario;
        return view('admin.usuarios.index',compact('usuario'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function consulta(Request $request)
    {
        $username = $request->input('username');
        $functionname = 'core_user_get_users';
        $serverurl = $this->domainname . '/webservice/rest/server.php'
        . '?wstoken=' . $this->token 
        . '&wsfunction='.$functionname
        .'&moodlewsrestformat=json&criteria[0][key]=lastname&criteria[0][value]=%'.$username;
        $usuario = Http::get($serverurl);
        //return $usuario;
        return view('admin.usuarios.consulta',compact('usuario'));
    }

    public function consultapdf($username){
        $functionname = 'core_user_get_users';
        $serverurl = $this->domainname . '/webservice/rest/server.php'
        . '?wstoken=' . $this->token 
        . '&wsfunction='.$functionname
        .'&moodlewsrestformat=json&criteria[0][key]=username&criteria[0][value]='.$username;
        $usuario = Http::get($serverurl);
        $pdf = PDF::loadView('admin.usuarios.consultapdf',compact('usuario'));
        //return view('admin.usuarios.consultapdf',compact('usuario'));
        return $pdf->download('estudiante.pdf');
    }
    public function agregarprograma($id)
    {   
        //obtener información del estudiante
        $functionname = 'core_user_get_users';
        $serverurl = $this->domainname . '/webservice/rest/server.php'
        . '?wstoken=' . $this->token 
        . '&wsfunction='.$functionname
        .'&moodlewsrestformat=json&criteria[0][key]=id&criteria[0][value]='.$id;
        $usuario = Http::get($serverurl);
        //obtener información del programa
        $programas = Programa::all();
        //obtener información de las matriculas hechas
        $matriculas = Matricula::where('user_id',$id)->get();
        return view('admin.usuarios.agregarprograma',compact('usuario','programas','matriculas'));
    }
}