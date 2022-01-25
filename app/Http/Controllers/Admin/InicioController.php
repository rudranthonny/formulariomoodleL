<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inicio;
use App\Models\Plantilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

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
        if($request->file('inicio_imagen') != null)
                {
                    $extension = $request->inicio_imagen->extension();
                    $imagenenu = $request->file('inicio_imagen')->storeAs('public/inicios',str_replace(' ','',$request->input('name'))."-".rand(1,2000).".".$extension);
                    $url = Storage::url($imagenenu);
        }
        $inicios = Inicio::all();
        if ($request->input('estado') != null) {
            foreach ($inicios as $inicio) {
                $inicio->estado = "0";
                $inicio->update();
            }
            $inicio = Inicio::create($request->only(['name','estado'])+['inicio_imagen' => $url]);
        } else {
            if ($inicios == "[]") {
                $inicio = Inicio::create(
                    [
                        'name' => $request->input('name'),
                        'inicio_imagen' => $url,
                        'estado' => '1',
                    ]
                );
            }
            else{

                
                $inicio = Inicio::create(
                    [
                        'name' => $request->input('name'),
                        'inicio_imagen' => $url,
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
        ]);
        $inicio->name = $request->input('name');
        $inicio->save();
        if($request->file('inicio_imagen') != null)
        {
            
                $extension = $request->file('inicio_imagen')->extension();
                $eliminar = str_replace('storage','public',$inicio->inicio_imagen);
                Storage::delete([$eliminar]);
                $imagenenu = $request->file('inicio_imagen')->storeAs('public/inicios',str_replace(' ','',$request->input('name'))."-".rand(1,2000).".".$extension);
                $url = Storage::url($imagenenu);
                $inicio->update(['inicio_imagen' => $url]);
        }

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
