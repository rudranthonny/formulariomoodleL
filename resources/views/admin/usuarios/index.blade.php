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
        <table class="table" id="tabla-m" class="table table-striped">
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
                <th>{{$usuario}}</th>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
    $('#tabla-m').DataTable({
        "lengthMenu": [[5,10,50,-1],[5,10,50,"All"]],
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por páginas",
            "zeroRecords": "No se encontro el registro",
            "info": "Mostrando la página _PAGE_ de _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtrado de  _MAX_ registros totales)",
            'search': 'Buscar:',
            'paginate' : 
            {
            'previous': 'Atras',
            'next': 'Siguiente',
            }
        }
    });
} );
    </script>
@stop