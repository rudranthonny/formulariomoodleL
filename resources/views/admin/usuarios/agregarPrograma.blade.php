@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Matricula del estudiante</h1>
@stop

@section('content')
@if (session('info'))
<div class="alert alert-success">
 <strong>   {{session('info')}} </strong>
</div>
@endif
@php
foreach(json_decode($usuario)->users as $estudiante){
}  
@endphp
<div class="card">
<div class="card-body">
    <center><h3>Estudiante : {{$estudiante->fullname}} </h3></center>
</div>
</div>
@if ($programas->count() != $matriculas->count())
    <div class="card-body">
        <form action="{{route('admin.matriculas.agregarmatricula',$estudiante->id)}}" method="POST">
            @csrf
            <input  name="firstname" type="hidden" value="{{$estudiante->firstname}}">
            <input  name="lastname" type="hidden" value="{{$estudiante->lastname}}">
            <div class="mb-3">
            <select class="form-select" aria-label="Default select example" name="programa_id">
                @foreach ($programas as $programa)
                @php $serepite = false; @endphp
                
                @foreach ($matriculas as $matricula)
                    @php
                        if($programa->id == $matricula->programa_id){
                            $serepite = true;
                        }
                    @endphp
                @endforeach
                @if ($serepite == false)
                <option value="{{$programa->id}}">{{$programa->name}}</option>
                @endif
                @endforeach
              </select>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Agregar Programa</button>
            </div>
        </form>
    </div> 
    @else
    <div class="mb-3">
    <strong>No hay programas  que agregar</strong>
    </div> 
    @endif
</div>
<hr>
<!--programas matriculados-->
<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
              <tr class="bg-dark">
                <th scope="col">Nombre</th>
                <th scope="col">Lastname</th>
                <th scope="col">programa</th>
                <th scope="col">costo</th>
                <th>Acción</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($matriculas as $matricula)
              <tr>
                <th scope="row">{{$matricula->name}}</th>
                <td>{{$matricula->lastname}}</td>
                <td>{{$matricula->programa->name}}</td>
                <td>{{$matricula->costo}}</td>
                <td>
                    <a class="btn btn-danger" href="#" onclick="document.getElementById('form2-{{$matricula->id}}').submit()" role="button">Eliminar</a>
                </td>
                <form action="{{route('admin.matriculas.eliminarprograma',$matricula->id)}}" method="POST" id="form2-{{$matricula->id}}">
                    @csrf
                    @method('DELETE')
                    <input  name="estudiante_id" type="hidden" value="{{$estudiante->id}}">
                    <input  name="cohorte_id" type="hidden" value="{{$matricula->programa->cohort}}">
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