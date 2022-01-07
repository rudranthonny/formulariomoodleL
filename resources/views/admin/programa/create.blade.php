@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Crear Programa</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <center><h3>Rellene Correctenemte el formulario</h3></center>
    </div>
    <div class="card-body">
        <form action="{{route('admin.programas.store')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nombre del Programa</label>
                <input type="text" class="form-control" id="name" name="name">
                @error('name')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="costo" class="form-label"> Costo del Programa</label>
                <input type="number" class="form-control" id="costo" name="costo">
                @error('costo')
                <span class="text-danger">{{$message}}</span>
             @enderror
            </div>
            <div class="mb-3">
                <label for="costo" class="form-label">Nombre del Cohorte</label>
                <select class="form-select" name="cohort" aria-label="Default select example">
                    @foreach (json_decode($cohortes) as $cohort)
                    <option value="{{$cohort->id}}">{{$cohort->name}}</option>
                    @endforeach
                  </select>
                @error('cohort')
                <span class="text-danger">{{$message}}</span>
             @enderror
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Crear Programa</button>
                <a class="btn btn-dark" href="{{route('admin.programas.index')}}" role="button">Cancelar</a>
            </div>
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