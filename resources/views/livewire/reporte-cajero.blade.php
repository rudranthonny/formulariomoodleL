<div>
    <table class="table" id="tabla-m" class="table table-striped">
        <thead>
            <tr class="bg-dark">
              <th scope="col">ESTUDIANTE</th>
              <th scope="col">COSTO</th>
              <th scope="col">AGENTE</th>
              <th scope="col">TIPO</th>
              <th scope="col">FECHA DE PAGO</th>
              <th scope="col">COMPROBANTE</th>
              <th scope="col">REFERENCIA</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($matriculas as $matricula)
            <tr>
                <td>{{$matricula->name." ".$matricula->lastname}}</td>
                <td>{{$matricula->costo}}</td>
                <td>{{$matricula->agente}}</td>
                <td>{{$matricula->tipo}}</td>
                <td>{{$matricula->fechapago}}</td>
                <td>{{$matricula->comprobante}}</td>
                @if ($matricula->comprobante_imagen)
                <td>
                  <a href="{{asset($matricula->comprobante_imagen)}}" target="_blank">ver</a>   
                </td>
                @else
                <td>
                    no tiene  
                </td>
                @endif
            <tr> 
            @endforeach
        </tbody>
    </table>
</div>
