@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Lista de Usuarios</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
      <div class="card-header">
        <a class="btn btn-primary" href="{{route('admin.usuarios.create')}}" role="button">Crear estudiante</a>
    </div>
        <hr>
        <table class="table">
            <thead>
              <tr class="bg-dark">
                <th scope="col">id</th>
                <th scope="col">Nombres</th>
                <th scope="col">Apellidos</th>
                <th scope="col">email</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach (json_decode($usuario)->users as $user)
              <tr>
                <th scope="row">{{$user->id}}</th>
                <th scope="row">{{$user->fullname}}</th>
                <td>{{$user->lastname}}</td>
                <td>{{$user->email}}</td>
                <td>
                  <a class="btn btn-dark" href="{{route('admin.usuarios.agregarprograma',$user->id)}}" role="button">Agregar Programa</a>
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