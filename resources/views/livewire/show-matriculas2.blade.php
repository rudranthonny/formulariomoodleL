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
                </tr>
            </thead>
            <tbody>
                @foreach ($matriculas as $matricula)
                <tr>
                    <td>{{$matricula->name}}</td>
                    <td>{{$matricula->lastname}}</td>
                    <td>{{$matricula->inscripcion->dni}}</td>
                    <td>{{$matricula->inscripcion->email}}</td>
                </tr>  
                @endforeach
            </tbody>
        </table>
    </div>
</div>
