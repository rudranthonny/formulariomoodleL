<div class="card-body">
  <div>
    <input class="form-control" id="exampleDataList" placeholder="Buscar usuario" wire:model="search">
  </div>
    @if ($inscripciones->count())
    <table class="table" id="tabla-m" class="table table-striped">
        <thead>
            <tr class="bg-dark">
              <th scope="col">Nombres</th>
              <th scope="col">Apellidos</th>
              <th scope="col">email</th>
              <th scope="col">dni</th>
              <th scope="col">phone</th>
              <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inscripciones as $inscripcion)
            <tr>
              <td>{{$inscripcion->name}}</td>
              <td>{{$inscripcion->lastname}}</td>
              <td>{{$inscripcion->email}}</td>
              <td>{{$inscripcion->dni}}</td>
              <td>{{$inscripcion->phone}}</td>
              <td>
                
                <form action="{{route('admin.inscripciones.destroy',$inscripcion->id)}}" method="POST" id="eliminar-inscripcion" class="eliminar-inscripcion">
                    @csrf
                    @method('DELETE')
                    <a class="btn btn-dark" href="{{route('admin.usuarios.agregarprograma',$inscripcion->user_id)}}" role="button">Agregar Programa</a>
                    <button type="submit"  class="btn btn-danger">Eliminar</button>
                </form>
              </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <div class="px-6 py-4">
                No existe ningun registro coincidente
        </div>
    @endif
    <div class="d-flex justify-content-end">
      {{ $inscripciones->links() }}
  </div>
</div>