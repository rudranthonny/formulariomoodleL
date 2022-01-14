@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Inscripciones</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
        <div class="col-sm-3">
            <button type="button"  class="btn btn-danger" onclick="eliminartodo()"><i class="fas fa-trash-alt"></i> Eliminar Inscritos</button>
        </div>
        <div class="col-sm-3">
        <a class="btn btn-success" href="{{route('admin.inscripciones.export',"variable")}}" role="button" ><i class="fas fa-download"></i> Exportar</a>
        </div>   
        <div class="col-sm-3">
                @livewire('subir-inscripciones')
        </div>
        <div class="col-sm-3">
            @livewire('registrar-usuarios')
        </div>
    </div>
        
    </div>
    @livewire('mostrar-inscripciones')
</div>
@livewireScripts
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">

@stop

@section('js')
    <script> console.log('Hi!')</script>
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

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>  
    function eliminartodo()
    {
        Swal.fire({
        title: '¿Esta seguro?',
        text: "Se eliminaran todas las inscripciones",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirmar'
        }).then((result) => {
        if (result.isConfirmed) {
        $(location).attr('href','inscripciones/eliminar/eliminarall');
        }
        })
    } 

    $('.eliminar-inscripcion').submit(function(e){
            e.preventDefault();
            Swal.fire({
        title: '¿Esta seguro?',
        text: "Se eliminara el registro seleccionado",
        icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Confirmar'
}).then((result) => {
  if (result.isConfirmed) {
    this.submit();
  }
})
       });
    </script>
    @if (session('eliminado') == 'eliminado')
    <script>
    Swal.fire(
    '!Eliminación Completada¡',
    'Se elimino todos los registros satisfactoriamente',
    )
    </script>
    @endif
    @if (session('eliminado') == 'individual')
    <script>
    Swal.fire(
    '!Eliminación Completada¡',
    'Se elimino el usuario seleccionado',
    )
    </script>
    @endif
@stop