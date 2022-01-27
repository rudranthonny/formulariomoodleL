@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Crear Inicio</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <center><h3>Rellene Correctenemte el formulario</h3></center>
    </div>
    <div class="card-body">
        <form action="{{route('admin.inicios.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nombre del Inicio</label>
                <input type="text" class="form-control" id="name" name="name">
                @error('name')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inicio_imagen" class="form-label">Logotipo del Inicio</label><br>
                <strong class="alert-danger">(*) la medida del logotipo no debe pasar el 100px ya sea largo o ancho</strong><br>
                <input type="file" name="inicio_imagen" accept="image/*">
                @error('inicio_imagen')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inicio_imagen_fondo" class="form-label">Fondo del Inicio</label><br>
                <strong class="alert-danger">(*) la medida del fondo de la imagen tiene que ser de 853px - 1280px</strong><br>
                <input type="file" name="inicio_imagen_fondo" accept="image/*">
                @error('inicio_imagen_fondo')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="mb-3">
                Activar Inicio <input type="checkbox" class="mr-1" name="estado" value='1'>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Crear Inicio</button>
                <a class="btn btn-dark" href="{{route('admin.inicios.index')}}" role="button">Cancelar</a>
            </div>
             
        </form>
    </div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop