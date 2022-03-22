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
                </tr>
            </thead>
            <tbody>
                @foreach ($matriculas as $matricula)
                <tr>
                    <td>{{$matricula->name}}</td>
                    <td>{{$matricula->lastname}}</td>
                </tr>  
                @endforeach
            </tbody>
        </table>
    </div>
</div>
