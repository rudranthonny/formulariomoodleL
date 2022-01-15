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
                <th scope="col">Name</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($inicios as $inicio)
              <tr>
                <th scope="row">{{$inicio->name}}</th>
                <td>
                <form action="{{route('admin.inicios.destroy',$inicio->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <a class="btn btn-info" href="{{route('admin.inicios.edit',$inicio->id)}}" role="button"><i class="fas fa-edit"></i></a>
                <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                @if ($inicio->estado == "1")
                <button  class="btn btn-success" disabled><i class="fas fa-eye"></i></button>
                @else
                <a class="btn btn-secondary" href="{{route('admin.inicios.activar',$inicio->id)}}" role="button"><i class="fas fa-eye-slash"></i></a>   
                @endif
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