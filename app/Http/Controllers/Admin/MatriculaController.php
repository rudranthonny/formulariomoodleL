<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Matricula;
use App\Models\Programa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MatriculaController extends Controller
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
        //
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
     * @param  \App\Models\Matricula  $matricula
     * @return \Illuminate\Http\Response
     */
    public function show(Matricula $matricula)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Matricula  $matricula
     * @return \Illuminate\Http\Response
     */
    public function edit(Matricula $matricula)
    {
        return view('admin.matricula.edit',compact('matricula'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Matricula  $matricula
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Matricula $matricula)
    {
        //return $matricula;
        $request->validate([
            'costo' => 'required',
            'agente'=> 'required',
            'tipo' => 'required',
            'fechapago' => 'required',
            'comprobante' => 'required',
        ]);
        //return $request->input('comprobante');
        $matricula->update($request->all());
        //return 'se actualizo correctamente';
        return redirect()->route('admin.usuarios.agregarprograma',$matricula->user_id)->with('info','se modifico correctamente el pago');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Matricula  $matricula
     * @return \Illuminate\Http\Response
     */
    public function destroy(Matricula $matricula)
    {
        //
    }

    public function agregarmatricula(Request $request,$id)
    {   //obtener información del programa en base id enviado por el formulario
        $programa = Programa::find($request->input('programa_id'));        
        // realizar matricula
        $matricula = new Matricula();
        $matricula->name = $request->input('firstname');
        $matricula->lastname = $request->input('lastname');
        $matricula->user_id = $id;
        $matricula->costo = $programa->costo;
        $matricula->programa_id = $programa->id;
        $matricula->save();
        // realizar agregación del Cohorte
        $functionname = 'core_cohort_add_cohort_members';
        $serverurl = $this->domainname . '/webservice/rest/server.php'
        . '?wstoken=' . $this->token 
        . '&wsfunction='.$functionname
        .'&moodlewsrestformat=json&members[0][cohorttype][type]=id&members[0][cohorttype][value]='.$programa->cohort.'&members[0][usertype][type]=id&members[0][usertype][value]='.$id;
        $usuario = Http::get($serverurl);
        //redireccionamiento
        return redirect()->route('admin.usuarios.agregarprograma',$id)->with('info','se matriculo correctamente');
    }

    public function eliminarprograma(Request $request, $id)
    {
        //eliminar la matriculación del cohorte
        $functionname = 'core_cohort_delete_cohort_members';
        $serverurl = $this->domainname . '/webservice/rest/server.php'
        . '?wstoken=' . $this->token 
        . '&wsfunction='.$functionname
        .'&moodlewsrestformat=json&members[0][cohortid]='.$request->input('cohorte_id').'&members[0][userid]='.$request->input('estudiante_id');
        $usuario = Http::get($serverurl);
        //eliminar matricula
        $matricula = Matricula::find($id);
        $matricula->delete();
        //redireccionamiento
        return redirect()->route('admin.usuarios.agregarprograma',$request->input('estudiante_id'))->with('info','se elimino correctamente la matricula');
    }
}
