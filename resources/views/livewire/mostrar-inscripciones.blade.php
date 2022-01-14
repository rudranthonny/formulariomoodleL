<div class="card-body">
  <div class="container p-4">
    <div class="row">
      <div class="col-6">
        <input class="form-control" id="exampleDataList" placeholder="Buscar usuario" wire:model="search">
      </div>
      <div class="col-3">
        Programa :
        <select class="form-select" aria-label="Default select example" wire:model="bprograma" style="width: 50%">
          @foreach ($programas as $programa)
          <option value="{{$programa->id}}">{{$programa->name}}</option>
          @endforeach    
        </select>
      </div>
      <div class="col-3">
        Pag : 
        <select class="form-select" aria-label="Default select example" wire:model="blista" style="width: 30%">
          <option value="30">30</option>
          <option value="60">60</option>
          <option value="90">90</option>
          <option value="1000">all</option>   
        </select>
      </div>
    </div>
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
              <th scope="col">Matriculado</th>
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
                    <a class="btn btn-dark" href="{{route('admin.usuarios.agregarprograma',$inscripcion->user_id)}}" role="button"><i class="fas fa-plus-circle"></i> Programa</a>
                    <button type="submit"  class="btn btn-danger">Eliminar</button>
                </form>
              </td>
              <td>
                @php
                    foreach($matriculas as $matricula){
                      if ($inscripcion->user_id == $matricula->user_id) {
                       $matriculado = true;
                       break;
                      } else {
                      $matriculado = false;
                      }   
                    }
                @endphp
                
              @if ($matriculado)
              <div class="alert alert-success p-1 text-center" role="alert" style="color:white">
                si
              </div>  
              @else
              <div class="alert alert-danger p-1 text-center" role="alert" style="color:white">
                no
              </div> 
              @endif
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