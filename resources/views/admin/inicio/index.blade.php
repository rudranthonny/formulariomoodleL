@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Modulo Inicio</h1>
@stop

@section('content')
@if (session('info'))
<div class="alert alert-success">
 <strong>   {{session('info')}} </strong>
</div>
@endif
   <div class="card">
    <div class="card-header">
        <a class="btn btn-primary" href="{{route('admin.inicios.create')}}" role="button">Crear Inicio</a>
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
              @foreach ($inicios as $inicio)
              <tr>
                <th scope="row">{{$inicio->name}}</th>
                <td>{{$inicio->shortname}}</td>
                <td>
                <form action="{{route('admin.inicios.destroy',$inicio->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <a class="btn btn-info" href="{{route('admin.inicios.edit',$inicio->id)}}" role="button">Editar</a>
                <a class="btn btn-success" href="#" role="button">Agregar Usuario</a>
    
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