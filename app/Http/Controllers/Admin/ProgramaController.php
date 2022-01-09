<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Matricula;
use App\Models\Programa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProgramaController extends Controller
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
        
       $programas = Programa::all();
        return view('admin.programa.index',compact('programas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $functionname = 'core_cohort_get_cohorts';
        $serverurl = $this->domainname . '/webservice/rest/server.php'. '?wstoken=' . $this->token . '&wsfunction='.$functionname.'&moodlewsrestformat=json';
        //return $serverurl;
        $cohortes = Http::get($serverurl);
        return view('admin.programa.create',compact('cohortes'));

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
            'costo'=> 'required',
            'cohort' => 'required',
        ]);
        $programa = Programa::create($request->all());
        return redirect()->route('admin.programas.index')->with('info','el programa se creo correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Programa  $curso
     * @return \Illuminate\Http\Response
     */
    public function show(Programa $curso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Programa  $curso
     * @return \Illuminate\Http\Response
     */
    public function edit(Programa $programa)
    {
        return view('admin.programa.edit',compact('programa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Programa  $programa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Programa $programa)
    {
        $request->validate([
            'name' => 'required',
            'costo'=> 'required', 
        ]);
        $programa->update($request->all());
        return redirect()->route('admin.programas.index')->with('info','el programas se actualizo correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Programa  $curso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Programa $programa)
    {
        /*verificar que no haya matriculas*/
        $matriculas = Matricula::where('programa_id',$programa->id)->count();
        /*eliminar porgrama*/
        if($matriculas == 0){
        $programa->delete();
        return redirect()->route('admin.programas.index')->with('info','el programa se elimino correctamente');
        }
        else{
        return redirect()->route('admin.programas.index')->with('info','el programa tiene matriculas no se puede eliminar');
        }
    }
}
