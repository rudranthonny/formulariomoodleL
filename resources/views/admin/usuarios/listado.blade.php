@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<div class="text-center h1" id="titulo">Bienvenido a la lista de Usuarios</div>
@stop

@section('content')
<div>
    @livewire('show-usuarios')
  @livewireScripts
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        #titulo {
      background: cornflowerblue;
      border-radius: 20px;
      padding: 10px;
      color: white;
  }
      </style>
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('eliminar'))
    <script>Swal.fire(
   'Eliminado!',
'Tu registro ha sido eliminado.',
    'success'
    )</script>
    @endif
    
     @if (session('tienepagos'))
    <script>Swal.fire(
    'No se puede realizar esta función',
    'el usuario tiene registros de vital importancia para la academia',
    'success'
    )</script>
    @endif


    <script>
      function eliminar(a){
        Swal.fire({
  title: 'Estas Seguro de Eliminar',
  text: "Una vez se elimine ya no se podra restaurar el registro",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Si, !Eliminar Esto!'
}).then((result) => {
  if (result.isConfirmed) {
    document.getElementById(a).submit()
  }
})
      }
    </script>
@stop