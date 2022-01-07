@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Asignar Cursos a la Plantilla</h1>
@stop

@section('content')
@if (session('info'))
<div class="alert alert-success">
 <strong>   {{session('info')}} </strong>
</div>
@endif
<div class="card">
    <div class="card-header">
        <center><h3>Rellene Correctenemte el formulario</h3></center>
        <center><h5>Nombre de la plantilla : {{$plantilla->name}}</h5></center>
            <center><h5>Nombre corto de la plantilla : {{$plantilla->shortname}}</h5></center>
    </div>
    @if ($cursos->count() != $plantilla->cursos->count())
    <div class="card-body">
        <form action="{{route('admin.plantillas.agregarcurso')}}" method="POST">
            @csrf
            <input  name="plantilla_id" type="hidden" value="{{$plantilla->id}}">
            <div class="mb-3">
            <select class="form-select" aria-label="Default select example" name="curso_id">
                @foreach ($cursos as $curso)
                @php $serepite = false; @endphp
                
                @foreach ($plantilla->cursos as $acursos)
                    @php
                        if($acursos->id == $curso->id){
                            $serepite = true;
                        }
                    @endphp
                @endforeach
                @if ($serepite == false)
                <option value="{{$curso->id}}">{{$curso->name}}</option>
                @endif
                @endforeach
              </select>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Agregar Curso</button>
                <a class="btn btn-dark" href="{{route('admin.plantillas.index')}}" role="button">Cancelar</a>
            </div>
        </form>
    </div> 
    @else
    <div class="mb-3">
    <strong>No hay cursos que agregar</strong>
    </div> 
    @endif
    
</div>
<hr>
<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
              <tr class="bg-dark">
                <th scope="col">Nombre Largo</th>
                <th scope="col">Nombre Corto</th>
                <th>Acción</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($plantilla->cursos as $curso)
              <tr>
                <th scope="row">{{$curso->name}}</th>
                <td>{{$curso->shortname}}</td>
                <td>
                    <a class="btn btn-danger" href="#" onclick="document.getElementById('form2-{{$curso->id}}').submit()" role="button">Eliminar</a>
                </td>
                <form action="{{route('admin.plantillas.eliminarcurso')}}" method="POST" id="form2-{{$curso->id}}">
                    @csrf
                    <input  name="plantilla_id" type="hidden" value="{{$plantilla->id}}">
                    <input  name="curso_id" type="hidden" value="{{$curso->id}}">
                </form>
              </tr>
              @endforeach
            </tbody>
          </table>
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