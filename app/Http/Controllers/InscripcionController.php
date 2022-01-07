<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InscripcionController extends Controller
{
    private $token = 'ff63b816357ee3098eb0504de43be96c';
    private $domainname = 'https://jademlearning.com/aula5';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('inscripcion');
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
        $request->validate([
            'name' => 'required',
            'lastname'=> 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);
        //crear usuario
        $functionname = 'core_user_create_users';
        $serverurl = $this->domainname . '/webservice/rest/server.php'
        . '?wstoken=' . $this->token 
        . '&wsfunction='.$functionname
        .'&moodlewsrestformat=json
        &users[0][username]='.$request->input('email').'&users[0][password]=123456789&users[0][firstname]='.$request->input('name').'&users[0][lastname]='.$request->input('lastname').'&users[0][email]='.$request->input('email').'&users[0][phone1]='.$request->input('phone').'&users[0][country]='.$request->input('country');
        return $serverurl;
        $usuario = Http::get($serverurl);
        //registrar la inscripcion del usuario
        $programa = Inscripcion::create($request->all());
        return redirect()->route('registrar.index');
        /*este es un comentario haber si gitgu funciona*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inscripcion  $inscripcion
     * @return \Illuminate\Http\Response
     */
    public function show(Inscripcion $inscripcion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inscripcion  $inscripcion
     * @return \Illuminate\Http\Response
     */
    public function edit(Inscripcion $inscripcion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inscripcion  $inscripcion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inscripcion $inscripcion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inscripcion  $inscripcion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inscripcion $inscripcion)
    {
        //
    }
}
