@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Cambiar Contraseña</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => 'admin.usuario.change','method' => 'post']) !!}
            <div class="form-group">
                {!! Form::label('passworda', 'Contraseña Actual',['class' => 'col-sm-2 col-form-label']) !!}
                {!! Form::password('passworda', ['class' =>'form-control']) !!}
                @error('password')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('password', 'Contraseña Nueva',['class' => 'col-sm-2 col-form-label']) !!}
                {!! Form::password('password', ['class' =>'form-control']) !!}
                @error('password')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('password_confirmation', 'Confirmar Contraseña Nueva') !!}
                {!! Form::password('password_confirmation', ['class' =>'form-control']) !!}
                @error('password_confirmation')
                <span class="text-danger">{{$message}}</span>
            @enderror
            </div>
            {!! Form::submit('Cambiar Contraseña', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop