@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Modulo Plantilla</h1>
@stop

@section('content')
@if (session('info'))
<div class="alert alert-success">
 <strong>   {{session('info')}} </strong>
</div>
@endif
   <div class="card">
    <div class="card-header">
        <a class="btn btn-primary" href="{{route('admin.plantillas.create')}}" role="button">Crear Plantilla</a>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
              <tr class="bg-dark">
                <th scope="col">Nombre Largo</th>
                <th scope="col">Nombre Corto</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($plantillas as $plantilla)
              <tr>
                <th scope="row">{{$plantilla->name}}</th>
                <td>{{$plantilla->shortname}}</td>
                <td>
                <form action="{{route('admin.plantillas.destroy',$plantilla->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <a class="btn btn-success" href="{{route('admin.plantillas.asignar',$plantilla->id)}}" role="button">Asignación</a>
                <a class="btn btn-info" href="{{route('admin.plantillas.edit',$plantilla->id)}}" role="button">Editar</a>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
    </div>
   </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop