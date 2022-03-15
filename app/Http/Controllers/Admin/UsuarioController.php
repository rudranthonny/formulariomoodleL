<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Matricula;
use App\Models\Programa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

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
        $roles = Role::all();
        return view('admin.usuarios.create',compact('roles'));
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
            /*DatosPersonales*/
            'name' => 'required|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'r_password' => 'required|same:password',
        ]);

        $usuario = new User();
        $usuario->name = $request->input('name');
        $usuario->email = $request->input('email');
        $usuario->password = bcrypt($request->input('password'));
        $usuario->save();
        $usuario->roles()->sync($request->roles);
        return redirect()->route('admin.usuario.listado')->with('info','se creo el estudiante correctamente');
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
        $usuario = User::find($id);
        $roles = Role::all();
        return view('admin.usuarios.edit',compact('usuario','roles'));
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
        $usuario = User::find($id);
        //validación
        $request->validate([
            /*DatosPersonales*/
            'name' => 'required|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)',
            'email' => 'required|email|unique:users,email,'.$usuario->id,
        ]);

         /*Actualizar datos del usuario*/
         $usuario->update($request
         ->only(
         'name',
         'email',
         ));
         /*actualizar roles*/
         if ($id != 1) {
            $usuario->roles()->sync($request->roles);
         }
        /*redireccionar*/
        return redirect()->route('admin.usuarios.edit',$usuario->id)->with('info','se actualizo correctamente el usuario');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   //return $id;
        $usuario = User::find($id);
        $matriculas = Matricula::all()->where('cajero_id',$id);
        if($matriculas->first() == null and $id != 1){ 
        $usuario->delete();
        return redirect()->route('admin.usuario.listado')->with('eliminar','eliminar');
        }
        else
        {
        return redirect()->route('admin.usuario.listado')->with('tienepagos','el usuario tiene registro de vital importancia para learclass');
        }
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

    public function cambiarpassword()
    {  
        $user = User::find(auth()->user()->id);
        return view('admin.usuarios.cambiar',compact('user'));
    }

    public function change(Request $request)
    {
        if (Hash::check($request->input('passworda'),auth()->user()->password)) {
        }
        else{
            return redirect()->route('admin.usuario.cambiarpassword')->with('info','la contraseña actual no es la correcta');
        }
        $request->validate([
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);
        $usuario = User::find(auth()->user()->id);
        $usuario->update([
            'password' => bcrypt($request->input('password')),
        ]);
        //direccionamiento
        return redirect()->route('admin.usuario.cambiarpassword')->with('info','la contraseña se cambio');
    }

    public function listado(){
        return view('admin.usuarios.listado');
    }
    public function reiniciarpassword($usuario){
        $usuario = User::find($usuario);
        $usuario->update([
            'password' => bcrypt($usuario->email),
        ]);
        return redirect()->route('admin.usuario.listado')->with('info','se reinicio la contraseña del usuario');;
    }
}