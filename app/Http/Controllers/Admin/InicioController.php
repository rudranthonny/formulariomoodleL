<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inicio;
use App\Models\Plantilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InicioController extends Controller
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
        $inicios = Inicio::all();
        return view('admin.inicio.index',compact('inicios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plantillas = Plantilla::all();
        return view('admin.inicio.create',compact('plantillas'));
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
            'shortname'=> 'required|unique:inicios|alpha_dash', 
        ]);
        $inicio = Inicio::create($request->all());
        //crear inicio en moodle - categoria
        $name =$request->input('shortname');
        $plantilla_id = $request->input('plantilla_id');
        $parent = 0;
        $idnumber = null;
        $description ='Esto es una categoria del sistema laravel';
        $descriptionformat = 1;
        //declarar funcion
        $functionname = 'core_course_create_categories';
        $serverurl = $this->domainname . '/webservice/rest/server.php'. '?wstoken=' . $this->token 
        . '&wsfunction='.$functionname.'&moodlewsrestformat=json&categories[0][name]='.$name
        .'&categories[0][parent]='.$parent
        .'&categories[0][idnumber]='.$idnumber
        .'&categories[0][description]='.$description
        .'&categories[0][descriptionformat]='.$descriptionformat;
        Http::get($serverurl);
         //obtener información de la categoria creada
        $functionname = 'core_course_get_categories';
        $serverurl2 = $this->domainname . '/webservice/rest/server.php'
        . '?wstoken=' . $this->token 
        . '&wsfunction='.$functionname
        .'&moodlewsrestformat=json&addsubcategories=0&criteria[0][key]=name&criteria[0][value]='.$name;
        $categoria = Http::get($serverurl2);
        foreach (json_decode($categoria) as $cat){   
        }
        //crear los cursos en base a la plantilla solicitada
        $functionname = 'core_course_create_courses';
        $plantilla = Plantilla::find($plantilla_id);
        foreach ($plantilla->cursos as $curso) {
            $serverurl3 = $this->domainname . '/webservice/rest/server.php'
            . '?wstoken=' . $this->token 
            . '&wsfunction='.$functionname
            .'&moodlewsrestformat=json&courses[0][fullname]='.$curso->name
            .'&courses[0][shortname]='.$name.'-'.$curso->name
            .'&courses[0][categoryid]='.$cat->id;
            $crearcurso = Http::get($serverurl3);
        }
        return redirect()->route('admin.inicios.index')->with('info','el Inicio se creo correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inicio  $inicio
     * @return \Illuminate\Http\Response
     */
    public function show(Inicio $inicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inicio  $inicio
     * @return \Illuminate\Http\Response
     */
    public function edit(Inicio $inicio)
    {
        $plantillas = Plantilla::all();
        return view('admin.inicio.edit',compact('inicio','plantillas'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inicio  $inicio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inicio $inicio)
    {
        $request->validate([
            'name' => 'required',
            'shortname'=> 'required|unique:inicios,shortname,'.$inicio->id.'|alpha_dash', 
        ]);
         //obtener información de la categoria seleccionado
         $functionname = 'core_course_get_categories';
         $serverurl2 = $this->domainname . '/webservice/rest/server.php'
         . '?wstoken=' . $this->token 
         . '&wsfunction='.$functionname
         .'&moodlewsrestformat=json&addsubcategories=0&criteria[0][key]=name&criteria[0][value]='.$inicio->shortname;
         $categoria = Http::get($serverurl2);
         foreach (json_decode($categoria) as $cat){   
         }
         //actualizar la categoria seleccionado
         $functionname = 'core_course_update_categories';
         $serverurl = $this->domainname . '/webservice/rest/server.php'. '?wstoken=' 
         . $this->token . '&wsfunction='
         .$functionname.'&moodlewsrestformat=json&categories[0][id]='.$cat->id.'&categories[0][name]='.$request->input('shortname');
        $categoria = Http::get($serverurl);
        $inicio->update($request->all());
        return redirect()->route('admin.inicios.index')->with('info','el Inicio se actualizo correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inicio  $inicio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inicio $inicio)
    {
        //obtenar información de la categoria que se va a eliminar
        $functionname = 'core_course_get_categories';
         $serverurl2 = $this->domainname . '/webservice/rest/server.php'
         . '?wstoken=' . $this->token 
         . '&wsfunction='.$functionname
         .'&moodlewsrestformat=json&addsubcategories=0&criteria[0][key]=name&criteria[0][value]='.$inicio->shortname;
         $categoria = Http::get($serverurl2);
         foreach (json_decode($categoria) as $cat){   
         }
         //eliminar la categoria obtenida
         $functionname = 'core_course_delete_categories';
         $serverurl3 = $this->domainname . '/webservice/rest/server.php'
         . '?wstoken=' . $this->token 
         . '&wsfunction='.$functionname.'&moodlewsrestformat=json&categories[0][id]='.$cat->id
         .'&categories[0][newparent]=0&categories[0][recursive]=1';
         $categoria = Http::get($serverurl3);
        $inicio->delete();
        return redirect()->route('admin.inicios.index')->with('info','el Inicio se elimino correctamente');
    }
}
