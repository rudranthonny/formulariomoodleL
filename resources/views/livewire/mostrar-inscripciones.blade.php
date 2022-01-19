<div class="card-body">
  @php
      $tsoles = 0;
      $tdolares = 0;
  @endphp
  <div class="container p-4">
    <div class="row">
      <div class="col-3">
        <input class="form-control" id="exampleDataList" placeholder="Buscar usuario" wire:model="search">
      </div>
      <div class="col-3">
        <select class="form-select" aria-label="Default select example" wire:model="binicio">
          <option>Elegir Inicio</option>
          @foreach ($inicios as $inicio)
          <option value="{{$inicio->id}}">{{$inicio->name}}</option>
          @endforeach    
        </select>
      </div>
      <div class="col-2">
        <select class="form-select" aria-label="Default select example" wire:model="bprograma">
          <option value="0">Elegir programa</option>
          @foreach ($programas as $programa)
          <option value="{{$programa->id}}">{{$programa->name}}</option>
          @endforeach    
        </select>
      </div>
      <div class="col-2"> 
        <select class="form-select" aria-label="Default select example" wire:model="bmatriculado">
          <option value="todos">Todos</option>
          <option value="matriculados">matriculados</option>
          <option value="nomatriculados">no matriculados</option>
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
    @if ($inscripciones->count() && ($bprograma))
    <table class="table" id="tabla-m" class="table table-striped">
        <thead>
            <tr class="bg-dark">
              <th scope="col">ESTUDIANTE</th>
              <th scope="col">EMAIL</th>
              <th scope="col">DNI</th>
              <th scope="col">PHONE</th>
              <th scope="col">DEL</th>
              <th scope="col">M</th>
              <th scope="col">C</th>
              <th scope="col">s/.</th>
              <th scope="col">$/.</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inscripciones as $inscripcion)
            <tr>
              <td>{{$inscripcion->name." ".$inscripcion->lastname}}</td>
              <td>{{$inscripcion->email}}</td>
              <td>{{$inscripcion->dni}}</td>
              <td>{{$inscripcion->phone}}</td>
              <td>
                    <button  class="btn btn-danger" wire:click="$emit('deleteInscripcion',{{$inscripcion->id}})"><i class="fas fa-user-minus"></i></button>
              </td>
              @php
              if($matriculas->count()){
              foreach($matriculas as $matricula){
                if ($inscripcion->user_id == $matricula->user_id) {
                 $matriculado = true;
                 break;
                } else {
                $matriculado = false;
                }   
              }
              }
              else{
                $matriculado = false;
              }
               @endphp
              <td>
              @if ($matriculado)
              <a class="btn btn-success" data-toggle="modal" data-target="#ventanaModal3" wire:click="editarmatricula({{$matricula->id}})"><i class="fas fa-edit"></i></a>
              @else
              <a class="btn btn-dark" role="button" wire:click="matricularprograma({{$inscripcion->id}})"><i class="fas fa-plus-circle"></i></a>
              @endif
              </td>
              <td>
                @if ($matriculado)
                @if ($matricula->comprobante_imagen)
                <a href="{{asset($matricula->comprobante_imagen)}}" target="_blank">ver</a>   
                @else
                no
                @endif
                @else
                no
                @endif
              </td>
              @if ($matriculado) 
              @if ($matricula->comprobante_imagen)
                  @if ($matricula->tipo == "Soles")
                  <td>{{"s/. ".$matricula->costo}}</td>
                  @php $tsoles = $tsoles + $matricula->costo;@endphp  
                  @else
                  <td>-</td>
                  @endif
                  @if ($matricula->tipo == "Dolares")
                  <td>{{"$/. ".$matricula->costo}}</td>  
                  @php $tdolares = $tdolares + $matricula->costo;@endphp 
                  @else
                  <td>-</td>
                  @endif  
              @else
                  <td>....</td>
                  <td>....</td>
              @endif
              @else
                  <td>....</td>
                  <td>....</td>
              @endif
            </tr>   
            @endforeach
            <tr>
              <td>{{"Nº : ".$inscripciones->count() }}</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td>{{"s/. ".$tsoles}}</td>
              <td>{{"$/. ".$tdolares}}</td>
            </tr>
        </tbody>
    </table>
    @else
        <div class="px-6 py-4">
                No existe ningun registro coincidente
        </div>
    @endif
    <div class="d-flex justify-content-between">
      {{ $inscripciones->links() }}
    </div>

  @push('js')
  <script>
    livewire.on('deleteInscripcion', iscID =>{
      Swal.fire({
      title: '¿Esta seguro?',
      text: "Se eliminaran esta inscripcion",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Confirmar'
      }).then((result) => {
      if (result.isConfirmed) {
            livewire.emitTo('mostrar-inscripciones','eliminar_inscripcion',iscID)
            Swal.fire(
            '!Eliminación Completada¡',
          'Se elimino el usuario seleccionado',
            )
          }
      })
    });
  </script>
  @endpush
   <!--ventana editar-->
   <div wire:ignore.self class="modal face" id="ventanaModal3" tabindex="-2" role="dialog" aria-labelledby="tituloVentana3" aria-hidden="true" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">    
                <div class="modal-header">
                    <h5 id="tituloVentana3">Modificar Matricula</h5>
                    <button class="close" data-dismiss="modal" arial-label="cerrar">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <!--Agencia-->
                  <div class="mb-3">
                    <label for="agente" class="form-label">Agente</label>
                    <select class="form-select" name="agente" aria-label="Default select example" wire:model.defer="eagente">
                    <option value="BancoNacion">Banco de la Nación</option> 
                    <option value="BBVA">BBVA</option>
                    <option value="BCP">BCP</option>  
                    <option value="DirectoPago">Directo Pago</option>  
                    <option value="Interbank">Interbank</option>  
                    <option value="MoneyGram">MoneyGram</option>  
                    <option value="Paypal">Paypal</option>   
                    <option value="Plim">Plim</option>  
                    <option value="Scotiabank">Scotiabank</option>  
                    <option value="WesterUnion">Wester Unión</option>   
                    <option value="Yape">Yape</option>       
                    </select>
                    @error('agente')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                  <!--tipo de soles-->
                  <div class="mb-3">
                  <label for="tipo" class="form-label">Tipo</label>
                  <select class="form-select" name="tipo" aria-label="Default select example" wire:model.defer="etipo">
                  <option value="Soles" selected>Soles</option>    
                  <option value="Dolares">Dolares</option>
                  </select>  
                  @error('tipo')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                  </div>
                  <!--monto-->
                  <div class="mb-3">
                  <label for="costo" class="form-label">Costo</label>
                  <input type="text" class="form-control" id="costo" name="costo" wire:model.defer="ecosto">
                    @error('costo')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                  <!--fecha-->
                  <div class="mb-3">
                  <label for="fechapago" class="form-label">Fecha</label>
                  <input type="date" class="form-control" id="fechapago" name="fechapago" wire:model.defer="efechapago">
                  @error('fechapago')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                  </div>
           <!--numero de comprobante-->
           <div class="mb-3">
              <label for="comprobante" class="form-label">Numero de Comprobante</label>
              <input type="text" class="form-control" id="ncomprobante" name="comprobante" wire:model.defer="ecomprobante">
              @error('comprobante')
              <span class="text-danger">{{$message}}</span>
              @enderror
          </div>
          <!--mostrar imagen-->
              @if ($ecomprobante_imagen != "")
              <div class="mb-3"> 
                  <center><img src="{{asset($ecomprobante_imagen) }}" alt="" width="300px"></center>
              </div>
              @endif
          <!--comprobante imagen-->
          <div class="mb-3">
              <input type="file" name="comprobante_imagen" accept="image/*" wire:model="ecomprobante_imagen_file">
              @error('ecomprobante_imagen_file')
                  <span class="text-danger">{{$message}}</span>
              @enderror
          </div>
          <!---->
          </div>
          <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal">
                        Cerrar
                    </button>
                    <button class="btn btn-success" wire:loading.attr="disable" wire:target="save, matriculas" type="button" wire:click="actualizarmatriculas">
                        Modificar Matricula
                    </button>
          </div>
        </div>
    </div>
</div>
</div>