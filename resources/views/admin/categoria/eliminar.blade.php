@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Eliminar Categoria de Moodle</h1>
@stop

@section('content')
@php
    foreach(json_decode($ecategoria) as $cat){
    }
@endphp
<div class="card">
<div class="card-header">
Eliminar tu categoria
</div>
<div class="card-body">
<form action="{{route('admin.categorias.eliminar',$cat->id)}}" method="POST">
@csrf
@if ($contador != 1 or $contador2 != 0)  
<h3>Esta categoria : tiene sub categorias o cursos</h3>
<div class="mb-3">
  <label for="scategoria" class="form-label">Elegir opcion</label>
<select class="form-select" aria-label="Default select example" id="recursive" name="recursive">
    <option value="1" >Eliminar todo el contenido</option>
    <option value="0" >Trasladar el contenido a otra categoria</option>
</select>
</div>
<div class="mb-3">
  <label for="scategoria" class="form-label">Elegir Categoria donde se va a trasladar</label>
<select class="form-select" aria-label="Default select example" id="newparent" name="newparent">
 
  @foreach (json_decode($categorias) as $item)
  @php $valor = false; @endphp
  @foreach (json_decode($scategoria) as $item2)
  @if ($item->id == $item2->id)
      @php
           $valor = true;
      @endphp
  @endif      
  @endforeach
        @if ($valor == false)
        <option value="{{$item->id}}">{{$item->name}} </option> 
        @endif
  @endforeach
</select>
</div>

@else
<input  name="recursive" type="hidden" value="1">
<input  name="newparent" type="hidden" value="0">
<h3>Esta categoria : no tiene contenido</h3>
@endif
<button type="submit" class="btn btn-primary">Eliminar Categoria</button>
<a class="btn btn-dark" href="{{route('admin.categorias.index')}}" role="button">Cancelar</a>
</form>
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