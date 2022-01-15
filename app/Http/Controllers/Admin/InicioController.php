<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inicio;
use App\Models\Plantilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InicioController extends Controller
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
        return view('admin.inicio.create');
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
        ]);
        $inicios = Inicio::all();
        if ($request->input('estado') != null) {
            foreach ($inicios as $inicio) {
                $inicio->estado = "0";
                $inicio->update();
            }
            $inicio = Inicio::create($request->all());
        } else {
            if ($inicios == "[]") {
                $inicio = Inicio::create(
                    [
                        'name' => $request->input('name'),
                        'estado' => '1',
                    ]
                );
            }
            else{
                $inicio = Inicio::create(
                    [
                        'name' => $request->input('name'),
                        'estado' => '0',
                    ]
                );
            }
        }
        //crear inicio en moodle - categoria
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
        if ($inicio->estado == "1") {$est = true;}else{$est=false;}
        $inicio->delete();
        $uinicio = Inicio::all()->first();
        if ($est && ($uinicio != "[]")) {
            $uinicio->estado = 1;
            $uinicio->save();
        }
        elseif($est && ($uinicio == "[]")){
            $cinicio = new Inicio;
            $cinicio->name = "Programa 0";
            $cinicio->estado = "1";
            $cinicio->save();
        }    
        return redirect()->route('admin.inicios.index')->with('info','el Inicio se elimino correctamente');
    }

    public function activar($inicio)
    {   $inicio = Inicio::find($inicio);
        $uinicios = Inicio::all();
        foreach ($uinicios as $uinicio) {
            $uinicio->estado = 0;
            $uinicio->save();
        }
        $inicio->estado = 1;
        $inicio->save();
        //crear inicio en moodle - categoria
        return redirect()->route('admin.inicios.index')->with('info','se cambio el programa');
    }
}
