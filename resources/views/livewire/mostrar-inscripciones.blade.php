<div class="card-body">
  <div class="container p-4">
    <div class="row">
      <div class="col-6">
        <input class="form-control" id="exampleDataList" placeholder="Buscar usuario" wire:model="search">
      </div>
      <div class="col-4">
        <select class="form-select" aria-label="Default select example" wire:model="bprograma">
          @foreach ($programas as $programa)
          @if ($loop->first)
          <option value="{{$programa->id}}" selected>{{$programa->name}}</option>
          @else
          <option value="{{$programa->id}}">{{$programa->name}}</option>
          @endif
          @endforeach    
        </select>
      </div>
      <div class="col-2"> 
        <select class="form-select" aria-label="Default select example" wire:model="blista">
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
              <th scope="col">NOMBRES</th>
              <th scope="col">APELLIDOS</th>
              <th scope="col">EMAIL</th>
              <th scope="col">DNI</th>
              <th scope="col">PHONE</th>
              <th scope="col">ACCIONES</th>
              <th scope="col">MAT</th>
              <th scope="col">COM</th>
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
              <td>
              @if ($matriculado)
              <a class="btn btn-success" href="{{route('admin.matriculas.edit',$matricula->id)}}" role="button"><i class="fas fa-edit"> Si</i></a>  
              @else
              <a class="btn btn-danger" role="button"><i class="fas fa-edit" wire:click="matricularprograma({{$inscripcion->id}})"> No</i></a>
              @endif
              </td>
              <td>
                @if ($matricula->comprobante_imagen)
                <a href="{{asset($matricula->comprobante_imagen)}}" target="_blank">si</a> 
                @else
                no
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