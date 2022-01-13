<?php

namespace App\Http\Controllers;

use App\Exports\InscripcionesExport;
use App\Models\Inscripcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;

class InscripcionController extends Controller
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
        $inscripciones = Inscripcion::all();
        return view('admin.inscripcion.index',compact('inscripciones'));
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inscripcion  $inscripcion
     * @return \Illuminate\Http\Response
     */
    public function show($inscripcion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inscripcion  $inscripcion
     * @return \Illuminate\Http\Response
     */
    public function edit($inscripcion)
    {
        return "estoy en edit";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inscripcion  $inscripcion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$inscripcion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inscripcion  $inscripcion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inscripcion = Inscripcion::find($id);
        $inscripcion->delete();
        return redirect()->route('admin.inscripciones.index')->with('eliminado','individual');
    }

    public function eliminarall($eliminar)
    {
        Inscripcion::truncate();
        return redirect()->route('admin.inscripciones.index')->with('eliminado','eliminado');
    }

    public function registrar(Request $request)
    {   
        //validación
        $request->validate([
            'name' => 'required',
            'lastname'=> 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'politicas' => 'required',
            'country' => 'required',
        ]);
        $emaila = strtolower($request->input('email'));
        //verificar si ya se realizo la inscripción
        $rinscripcion = Inscripcion::where('email',$emaila)->first();
        if($rinscripcion == false){
        //return $request->input('politicas');
        //crear usuario en moodle
        $functionname = 'core_user_create_users';
        $serverurl = $this->domainname. '/webservice/rest/server.php'
        . '?wstoken=' . $this->token 
        . '&wsfunction='.$functionname
        .'&moodlewsrestformat=json&users[0][username]='.$emaila.'&users[0][password]=123456789&users[0][firstname]='.$request->input('name').'&users[0][lastname]='.$request->input('lastname').'&users[0][email]='.$emaila.'&users[0][phone1]='.$request->input('phone').'&users[0][country]='.$request->input('country');
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
        $inscripcion= new Inscripcion();
        $inscripcion->create($request->all()+['user_id' => $user->id]);

        return redirect()->route('registrar.inicio')->with('crear','Se Inscribio Correctamente');
        }
        else{
        /*actualizar inscripcion*/
        $actualizar = Inscripcion::find($rinscripcion->id);
        $actualizar->update($request->all());
        /*actualizar en el moodle*/
        $functionname = 'core_user_update_users';
        $serverurl = $this->domainname. '/webservice/rest/server.php'
        . '?wstoken=' . $this->token 
        . '&wsfunction='.$functionname
        .'&moodlewsrestformat=json&users[0][id]='.$actualizar->user_id.'&users[0][password]=123456789&users[0][firstname]='.$request->input('name').'&users[0][lastname]='.$request->input('lastname').'&users[0][email]='.$emaila.'&users[0][phone1]='.$request->input('phone').'&users[0][country]='.$request->input('country');
        Http::get($serverurl);
        /*mandar mensaje*/
        return redirect()->route('registrar.inicio')->with('crear','actualización');
        }
    }

    public function inscripcionesexport() 
    {
        return Excel::download(new InscripcionesExport, 'inscripciones.xlsx');
    }
}
