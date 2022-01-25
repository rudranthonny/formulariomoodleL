<?php

namespace App\Http\Controllers;

use App\Exports\InscripcionesExport;
use App\Models\Inicio;
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
        return view('admin.inscripcion.index');
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
            $inicio = Inicio::where('estado',1)->first();
            //crear un inicio en caso se necesita
            if($inicio == false){
               $cinicio = new Inicio;
               $cinicio->name = "Programa 0";
               $cinicio->estado = "1";
               $cinicio->save();
            $inicio = Inicio::where('estado',1)->first();
            }
            $emaila = strtolower($request->input('email'));
            //verificar si ya se realizo la inscripción
            $rinscripcion = Inscripcion::where('email',$emaila)->first();
            if($rinscripcion == false){
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
             /*agregar cohorte*/
            $functionname = 'core_cohort_add_cohort_members';
            $serverurl = $this->domainname . '/webservice/rest/server.php'
            . '?wstoken=' . $this->token 
            . '&wsfunction='.$functionname
            .'&moodlewsrestformat=json&members[0][cohorttype][type]=id&members[0][cohorttype][value]=2&members[0][usertype][type]=id&members[0][usertype][value]='.$user->id;
            $usuario = Http::get($serverurl);
            //realizar la instancia
            $inscripcion= new Inscripcion();
            $inscripcion->create($request->all()+['user_id' => $user->id])->inicios()->attach($inicio->id);
            /************/

        return redirect()->route('registrar.inicio')->with('crear','Se Inscribio Correctamente');
        }
        else{
            /*actualizar inscripcion*/
            $actualizar = Inscripcion::find($rinscripcion->id);
            /*agregar cohorte*/
            $functionname = 'core_cohort_add_cohort_members';
          $serverurl = $this->domainname . '/webservice/rest/server.php'
          . '?wstoken=' . $this->token 
          . '&wsfunction='.$functionname
          .'&moodlewsrestformat=json&members[0][cohorttype][type]=id&members[0][cohorttype][value]=2&members[0][usertype][type]=id&members[0][usertype][value]='.$actualizar->user_id;
          $usuario = Http::get($serverurl);
          $actualizar->inicios()->attach($inicio->id);
          return redirect()->route('registrar.inicio')->with('crear','actualización');
        }
    }

    public function inscripcionesexport($variable) 
    {   //return 'estoy aca';
        return Excel::download(new InscripcionesExport, 'inscripciones.xlsx');
    }
}
