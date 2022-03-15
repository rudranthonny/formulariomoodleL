<div>
    <table class="table" id="tabla-m" class="table table-striped">
        <thead>
            <tr class="bg-dark">
              <th scope="col">ESTUDIANTE</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($matriculas as $matricula)
            <tr>
                <td>
                    {{$matricula->name." ".$matricula->lastname}}
                </td>
            <tr> 
            @endforeach
        </tbody>
    </table>
</div>
