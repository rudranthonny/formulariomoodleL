@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Modulo Programa</h1>
@stop

@section('content')
@if (session('info'))
<div class="alert alert-success">
 <strong>   {{session('info')}} </strong>
</div>
@endif
   <div class="card">
    <div class="card-header">
        <a class="btn btn-primary" href="{{route('admin.programas.create')}}" role="button">Crear Programa</a>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
              <tr class="bg-dark">
                <th scope="col">Nombre</th>
                <th scope="col">Costo</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($programas as $programa)
              <tr>
                <th scope="row">{{$programa->name}}</th>
                <td>{{$programa->costo}}</td>
                <td>
                <form action="{{route('admin.programas.destroy',$programa->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <a class="btn btn-info" href="{{route('admin.programas.edit',$programa->id)}}" role="button">Editar</a>
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