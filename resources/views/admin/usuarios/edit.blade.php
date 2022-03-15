@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1><center></center></h1>
@stop

@section('content')
@if (session('info'))
<div class="alert alert-success">
    <strong>{{session('info')}}</strong>
</div>
@endif
<div class="m-3">
    <a class="btn btn-success" href="{{route('admin.usuario.listado')}}" role="button">Regresar</a>
</div>
<br>
<form action="{{route('admin.usuarios.update',$usuario->id)}}" method="POST">
@method('PUT')
@csrf

<!--Datos Personales && Contacto-->
<div class="container">
    <div class="row">
      <div class="col-12">
          <!--Datos Personales-->
        <div class="card">
            <center><div class="card-header"><h3><strong>Datos Personales</strong><h3></div></center>
            <div class="card-body row">
                        <div class="mb-3 col-12">
                        <label for="name" class="form-label">Nombre y Apellidos <strong style="color:red">(*)</strong></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{$usuario->name}}">
                        @error('name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-12">
                        <label for="email" class="form-label">Correo Electronico <strong style="color:red">(*)</strong></label>
                        <input type="text" class="form-control" id="email" name="email" value="{{$usuario->email}}">
                        @error('email')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <!--reiniciar contraseña-->
                    <div class="form-group">
                    <a href="{{route('admin.usuario.reiniciarpassword',$usuario->id)}}" class="btn btn-dark">Reiniciar Contraseña</a>
                    </div>
                    <div class="mb-3">
                        <h2>Listado de Roles</h2>
                        @foreach ($roles as $role)
                            <div>
                                <label>
                                    @php
                                        $pertence = false;
                                        foreach($usuario->roles as $arole)
                                        {
                                            if($arole->id == $role->id)
                                            {$pertence = true;}
                                            else {}
                                        }
                                    @endphp
                                    @if ($pertence)
                                        <input type="checkbox" class="mr-1" name="roles[]" value='{{$role->id}}' checked> 
                                        {{$role->name}}
                                        @else
                                        <input type="checkbox" class="mr-1" name="roles[]" value='{{$role->id}}'> 
                                        {{$role->name}}
                                        @endif
                                </label>
                            </div>
                        @endforeach
                    </div>
            </div>
        </div>
      </div>
    </div>
  </div>
<div class="my-12">
    <center><button type="submit" class="btn btn-primary">Actualizar Usuario</button></center><br>
</div>
</form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop