@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Modificar Pago</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <center><h3>Rellene Correctenemte el formulario</h3></center>
    </div>
    <div class="card-body">
        <form action="{{route('admin.matriculas.update',$matricula->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!--Agencia-->
            <div class="mb-3">
                <select class="form-select" name="agente" aria-label="Default select example">
                    <option>Banco/Agencia</option>
                    @if ($matricula->agente == 'BancoNacion')
                    <option value="BancoNacion">Banco de la Nación</option> 
                    @else
                    <option value="BancoNacion">Banco de la Nación</option>
                    @endif
                    @if ($matricula->agente == 'BBVA')
                    <option value="BBVA" selected>BBVA</option>
                    @else
                    <option value="BBVA">BBVA</option> 
                    @endif
                    @if ($matricula->agente == 'BCP')
                    <option value="BCP" selected>BCP</option>  
                    @else
                    <option value="BCP">BCP</option>
                    @endif
                    @if ($matricula->agente == 'DirectoPago')
                    <option value="DirectoPago" selected>Directo Pago</option>  
                    @else
                    <option value="DirectoPago">Directo Pago</option>
                    @endif
                    @if ($matricula->agente == 'Interbank')
                    <option value="Interbank" selected>Interbank</option>  
                    @else
                    <option value="Interbank">Interbank</option>  
                    @endif
                    @if ($matricula->agente == 'MoneyGram')
                    <option value="MoneyGram" selected>MoneyGram</option>  
                    @else
                    <option value="MoneyGram">MoneyGram</option> 
                    @endif
                    @if ($matricula->agente == 'Paypal')
                    <option value="Paypal" selected>Paypal</option>   
                    @else
                    <option value="Paypal">Paypal</option>  
                    @endif
                    @if ($matricula->agente == 'Plim')
                    <option value="Plim" selected>Plim</option>  
                    @else
                    <option value="Plim">Plim</option> 
                    @endif
                    @if ($matricula->agente == 'Scotiabank')
                    <option value="Scotiabank" selected>Scotiabank</option>  
                    @else
                    <option value="Scotiabank">Scotiabank</option> 
                    @endif
                    @if ($matricula->agente == 'WesterUnion')
                    <option value="WesterUnion" selected>Wester Unión</option>   
                    @else
                    <option value="WesterUnion">Wester Unión</option>  
                    @endif
                    @if ($matricula->agente == 'Yape')
                    <option value="Yape" selected>Yape</option>   
                    @else
                    <option value="Yape">Yape</option> 
                    @endif
                    
                </select>
                @error('agente')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <!--tipo de soles-->
            <div class="mb-3">
                <select class="form-select" name="tipo" aria-label="Default select example">
                    <option value="soles">Elegir Moneda</option>    
                    <!--soles-->
                    @if ($matricula->tipo == 'Soles')
                    <option value="Soles" selected>Soles</option>    
                    @else
                    <option value="Soles">Soles</option>
                    @endif
                    <!--dolares-->
                    @if ($matricula->tipo == 'Dolares')
                    <option value="Dolares" selected>Dolares</option>    
                    @else
                    <option value="Dolares" >Dolares</option>    
                    @endif
                </select>
                @error('tipo')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <!--monto-->
            <div class="mb-3">
                <label for="costo" class="form-label">Costo</label>
                <input type="text" class="form-control" id="costo" name="costo" value="{{$matricula->costo}}">
                @error('costo')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <!--fecha-->
            <div class="mb-3">
                <label for="fechapago" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="fechapago" name="fechapago" value="{{$matricula->fechapago}}">
                @error('fechapago')
                <span class="text-danger">{{$message}}</span>
             @enderror
            </div>
             <!--numero de comprobante-->
             <div class="mb-3">
                <label for="comprobante" class="form-label">Numero de Comprobante</label>
                <input type="text" class="form-control" id="ncomprobante" name="comprobante" value="{{$matricula->comprobante}}">
                @error('comprobante')
                <span class="text-danger">{{$message}}</span>
             @enderror
            </div>
            <!--mostrar imagen-->
                @if ($matricula->comprobante_imagen != "")
                <div class="mb-3"> 
                    ssss
                    {{$matricula->comprobante_imagen}}
                    <img src="{{asset($matricula->comprobante_imagen) }}" alt="">
                </div>
                @endif
            <!--comprobante imagen-->
            <div class="mb-3">
                <input type="file" name="comprobante_imagen" accept="image/*">
                @error('comprobante_imagen')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <!---->
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Modificar Pago</button>
                <a class="btn btn-dark" href="#" role="button">Cancelar</a>
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