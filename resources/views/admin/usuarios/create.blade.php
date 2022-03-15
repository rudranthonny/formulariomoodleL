@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1><center></center></h1>
@stop

@section('content')
<div class="m-3">
    <a class="btn btn-success" href="{{route('admin.usuario.listado')}}" role="button">Regresar</a>
</div>
<br>
<form action="{{route('admin.usuarios.store')}}" method="POST" enctype="multipart/form-data">
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
                        <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
                        @error('name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-12">
                        <label for="email" class="form-label">Correo Electronico <strong style="color:red">(*)</strong></label>
                        <input type="text" class="form-control" id="email" name="email" value="{{old('email')}}">
                        @error('email')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-12">
                        <label for="password" class="form-label">Contraseña <strong style="color:red">(*)</strong></label>
                        <input type="password" class="form-control" id="password" name="password" value="{{old('password')}}">
                        @error('password')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-12">
                        <label for="r_password" class="form-label">Repetir Contraseña <strong style="color:red">(*)</strong></label>
                        <input type="text" class="form-control" id="r_password" name="r_password" value={{old('r_password')}}>
                        @error('r_password')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Roles</strong></label><br>
                        @foreach ($roles as $role)
                        {{$role->name}} : <input type="checkbox"  class="mr-1" name="roles[]" value='{{$role->id}}'> 
                        @endforeach
                    </div>
            </div>
        </div>
      </div>
    </div>
  </div>
<div class="my-12">
    <center><button type="submit" class="btn btn-primary">Crear Usuario</button></center><br>
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