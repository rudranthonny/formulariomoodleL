<div>
    <div class="row m-4 ">
        @livewire('registrar-usuario2')
    </div>
    <div class="m-4">
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>DNI</th>
                    <th>PHONE</th>
                    <th>C</th>
                    <th>s/.</th>
                    <th>$/.</th>
                    <th>Forma de Pago</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($matriculas as $matricula)
                <tr>
                    <td>{{$matricula->name}}</td>
                    <td>{{$matricula->lastname}}</td>
                    <td>{{$matricula->inscripcion->dni}}</td>
                    <td>{{$matricula->inscripcion->phone}}</td>
                    <td>
                        @if ($matricula->comprobante_imagen)
                        <a href="{{asset($matricula->comprobante_imagen)}}" target="_blank">ver</a>
                        @else
                        no tiene
                        @endif
                    </td>
                    <td>
                        @if ($matricula->tipo == "Soles")
                        {{"s/. ".$matricula->costo}}
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        @if ($matricula->tipo == "Dolares")
                        {{"$/. ".$matricula->costo}}
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        {{$matricula->agente}}
                    </td>
                </tr>  
                @endforeach
            </tbody>
        </table>
    </div>
</div>
