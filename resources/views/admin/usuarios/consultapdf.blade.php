<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table{
            width: 100%;
            border-spacing: 0px;
            border-collapse: collapse;
        }
        td, th {
        border-style: groove;
        text-align: center;
        padding: 8px;   
        }
        
        .mb-3 {
        margin-bottom: 1rem !important;
        }


        </style>
</head>
<body>
    <div class="card">
        @php
        foreach(json_decode($usuario)->users as $user){

        }
  
    @endphp
        <div class="mb-3">
            <center><h2>{{$user->fullname}} </h2><hr>
            <img src="{{$user->profileimageurl}}" class="img-thumbnail" alt=""></center>
        </div>
        <div class="card-body">
            <div class="mb-3">
            <table>
                  <tr>
                    <th scope="col">firstname</th>
                    <th scope="col">lastname</th>
                    <th scope="col">username</th>
                  </tr>
                  <tr>
                    <td>{{$user->firstname}}</td>
                    <td>{{$user->lastname}}</td>
                    <td>{{$user->username}}</td>
                  </tr>
              </table>
            </div>
            <div class="mb-3">
                <table class="table table-bordered">
                      <tr>
                        <th scope="col">email</th>
                        <th scope="col">phone1</th>
                        <th scope="col">phone2</th>
                      </tr>
                      <tr>
                        <td>{{$user->email}}</td>
                        <td>{{$user->phone1}}</td>
                        <td>{{$user->phone2}}</td>
                      </tr>
                  </table>
                </div>
                <div class="mb-3">
                    <table class="table table-bordered">
                          <tr>
                            <th scope="col">Pais</th>
                            <th scope="col">Departamento</th>
                            <th scope="col">Ciudad</th>
                            <th scope="col">Dirección</th>
                          </tr>
                          <tr>
                            <td>{{$user->country}}</td>
                            <td>{{$user->department}}</td>
                            <td>{{$user->city}}</td>
                            <td>{{$user->address}}</td>
                          </tr>
                      </table>
                    </div>
                    <div class="mb-3">
                        <table class="table table-bordered">
                              <tr>
                                <th scope="col">Centro de Estudio</th>
                              </tr>
                              <tr>
                                <td>{{$user->institution}}</td>
                              </tr>
                          </table>
                        </div>
                        @foreach ($user->customfields as $user2)
                                    <div class="mb-3">
                                        <table class="table table-bordered">
                                        <tr>
                                          <th scope="col">{{$user2->name}}</th>
                                        </tr>
                                        <tr>
                                          <td>{{$user2->value}}</td>
                                        </tr>
                                    </table>
                                </div>
                                    @endforeach
        </div>
    </div>
</body>
</html>

        