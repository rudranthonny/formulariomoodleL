<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\Plantilla;
use Illuminate\Http\Request;

class PlantillaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plantillas = Plantilla::all();
        return view('admin.plantilla.index',compact('plantillas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.plantilla.create');

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
            'shortname'=> 'required|unique:plantillas|alpha_dash', 
        ]);
        $plantilla = Plantilla::create($request->all());
        return redirect()->route('admin.plantillas.index')->with('info','la plantilla se creo correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plantilla  $plantilla
     * @return \Illuminate\Http\Response
     */
    public function show(Plantilla $plantilla)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plantilla  $plantilla
     * @return \Illuminate\Http\Response
     */
    public function edit(Plantilla $plantilla)
    {
        return view('admin.plantilla.edit',compact('plantilla'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plantilla  $plantilla
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plantilla $plantilla)
    {
        $request->validate([
            'name' => 'required',
            'shortname'=> 'required|unique:plantillas,shortname,'.$plantilla->id.'|alpha_dash', 
        ]);
        $plantilla->update($request->all());
        return redirect()->route('admin.plantillas.index')->with('info','la plantilla se actualizo correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plantilla  $plantilla
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plantilla $plantilla)
    {
        $plantilla->delete();
        return redirect()->route('admin.plantillas.index')->with('info','la plantilla se elimino correctamente');
    }

    public function asignar(Plantilla $id){
        $plantilla = $id;
        $cursos = Curso::all();
        return view('admin.plantilla.asignar',compact('plantilla','cursos'));

    }

    public function agregarcurso(Request $request){
        $plantilla = $request->input('plantilla_id');
        $curso = $request->input('curso_id');
        $oplantilla = Plantilla::find($plantilla);
        $oplantilla->cursos()->attach($curso);
        return redirect()->route('admin.plantillas.asignar',$plantilla)->with('info','el curso se agrego correctamente a la plantilla');
    }
    public function eliminarcurso(Request $request){
        $plantilla = $request->input('plantilla_id');
        $curso = $request->input('curso_id');
        $oplantilla = Plantilla::find($plantilla);
        $oplantilla->cursos()->detach($curso);
        return redirect()->route('admin.plantillas.asignar',$plantilla)->with('info','el curso se elimino correctamente de la plantilla');
    }
}
