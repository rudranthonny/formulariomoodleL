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
<script>
    Livewire.on('crearinscripcion',function(){
        Swal.fire(
            'Registro Correctamente',
            'Felicidades',
            'success',
        )
    })
</script>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        td a.btn.btn-dark {
    font-size: 11px;
}

td button.btn.btn-danger {
    font-size: 11px;
}

td {
    font-size: 11px;
}
    </style>
    @stop

@section('js')
    <script> console.log('Hi!')</script>
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