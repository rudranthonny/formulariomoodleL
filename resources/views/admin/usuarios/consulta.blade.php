@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Consulta el usuario</h1>
@stop

@section('content')
        <div class="card">
            <div class="card-header">
                <center><h2>Consultar Datos del Estudiante</h2></center>
            </div>
            <div class="card-body">
                <form action="{{route('admin.usuarios.consulta')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">Escribe el nombre del usuario</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Consultar Usuario</button>
                    </div>
                      
                </form>
            </div>
        </div>
        @isset($usuario)
        {{$usuario}}
        <div class="card">
            @php
            foreach(json_decode($usuario)->users as $user){
            }
      
        @endphp
            <div class="card-header">
                <center><h2>{{$user->fullname}} </h2><hr>
                <img src="{{$user->profileimageurl}}" class="img-thumbnail" alt=""></center>
            </div>
            <div class="card-body">
                <div class="mb-3">
                <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">firstname</th>
                        <th scope="col">lastname</th>
                        <th scope="col">username</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>{{$user->firstname}}</td>
                        <td>{{$user->lastname}}</td>
                        <td>{{$user->username}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="mb-3">
                    <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th scope="col">email</th>
                            <th scope="col">phone1</th>
                            <th scope="col">phone2</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>{{$user->email}}</td>
                            <td>{{$user->phone1}}</td>
                            <td>{{$user->phone2}}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="mb-3">
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th scope="col">Pais</th>
                                <th scope="col">Departamento</th>
                                <th scope="col">Ciudad</th>
                                <th scope="col">Dirección</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>{{$user->country}}</td>
                                <td>{{$user->department}}</td>
                                <td>{{$user->city}}</td>
                                <td>{{$user->address}}</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="mb-3">
                            <table class="table table-bordered">
                                <thead>
                                  <tr>
                                    <th scope="col">Centro de Estudio</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>{{$user->institution}}</td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            @foreach ($user->customfields as $user2)
                                        <div class="mb-3">
                                            <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                              <th scope="col">{{$user2->name}}</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                              <td>{{$user2->value}}</td>
                                            </tr>
                                          </tbody>
                                        </table>
                                    </div>
                                        @endforeach
                                      
                                    <div class="mb-3">
                                      <a class="btn btn-danger" href="{{route('admin.usuarios.consultapdf',$user->username)}}" role="button">Generar Pdf</a>
                                    </div>
            </div>
        </div>
        @endisset
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop