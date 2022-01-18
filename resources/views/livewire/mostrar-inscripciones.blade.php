<div class="card-body">
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
      <div class="col-4">
        <select class="form-select" aria-label="Default select example" wire:model="bprograma">
          <option value="0">Elegir programa</option>
          @foreach ($programas as $programa)
          <option value="{{$programa->id}}">{{$programa->name}}</option>
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
    @if ($inscripciones->count() && ($bprograma))
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
                    <a class="btn btn-info" href="{{route('admin.usuarios.agregarprograma',$inscripcion->user_id)}}" role="button" style="color: white"><i class="fas fa-book"></i></a>
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
              <a class="btn btn-success" data-toggle="modal" data-target="#ventanaModal3" wire:click="editarmatricula({{$matricula->id}})"><i class="fas fa-book"></i></a>
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
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <div class="px-6 py-4">
                No existe ningun registro coincidente
        </div>
    @endif
    <div class="d-flex justify-content-between">
      {{"Nº : ".$inscripciones->count() }}
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
                    <select class="form-select" name="agente" aria-label="Default select example">
                    <option>Banco/Agencia</option>
                    @if ($ematricula->agente == 'BancoNacion')
                    <option value="BancoNacion" selected>Banco de la Nación</option> 
                    @else
                    <option value="BancoNacion">Banco de la Nación</option>
                    @endif
                    @if ($ematricula->agente == 'BBVA')
                    <option value="BBVA" selected>BBVA</option>
                    @else
                    <option value="BBVA">BBVA</option> 
                    @endif
                    @if ($ematricula->agente == 'BCP')
                    <option value="BCP" selected>BCP</option>  
                    @else
                    <option value="BCP">BCP</option>
                    @endif
                    @if ($ematricula->agente == 'DirectoPago')
                    <option value="DirectoPago" selected>Directo Pago</option>  
                    @else
                    <option value="DirectoPago">Directo Pago</option>
                    @endif
                    @if ($ematricula->agente == 'Interbank')
                    <option value="Interbank" selected>Interbank</option>  
                    @else
                    <option value="Interbank">Interbank</option>  
                    @endif
                    @if ($ematricula->agente == 'MoneyGram')
                    <option value="MoneyGram" selected>MoneyGram</option>  
                    @else
                    <option value="MoneyGram">MoneyGram</option> 
                    @endif
                    @if ($ematricula->agente == 'Paypal')
                    <option value="Paypal" selected>Paypal</option>   
                    @else
                    <option value="Paypal">Paypal</option>  
                    @endif
                    @if ($ematricula->agente == 'Plim')
                    <option value="Plim" selected>Plim</option>  
                    @else
                    <option value="Plim">Plim</option> 
                    @endif
                    @if ($ematricula->agente == 'Scotiabank')
                    <option value="Scotiabank" selected>Scotiabank</option>  
                    @else
                    <option value="Scotiabank">Scotiabank</option> 
                    @endif
                    @if ($ematricula->agente == 'WesterUnion')
                    <option value="WesterUnion" selected>Wester Unión</option>   
                    @else
                    <option value="WesterUnion">Wester Unión</option>  
                    @endif
                    @if ($ematricula->agente == 'Yape')
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
                  @if ($ematricula->tipo == 'Soles')
                  <option value="Soles" selected>Soles</option>    
                  @else
                  <option value="Soles">Soles</option>
                  @endif
                  <!--dolares-->
                  @if ($ematricula->tipo == 'Dolares')
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
              <input type="text" class="form-control" id="costo" name="costo" value="{{$ematricula->costo}}">
              @error('costo')
              <span class="text-danger">{{$message}}</span>
              @enderror
          </div>
          <!--fecha-->
          <div class="mb-3">
              <label for="fechapago" class="form-label">Fecha</label>
              <input type="date" class="form-control" id="fechapago" name="fechapago" value="{{$ematricula->fechapago}}">
              @error('fechapago')
              <span class="text-danger">{{$message}}</span>
           @enderror
          </div>
           <!--numero de comprobante-->
           <div class="mb-3">
              <label for="comprobante" class="form-label">Numero de Comprobante</label>
              <input type="text" class="form-control" id="ncomprobante" name="comprobante" value="{{$ematricula->comprobante}}">
              @error('comprobante')
              <span class="text-danger">{{$message}}</span>
           @enderror
          </div>
          <!--mostrar imagen-->
              @if ($ematricula->comprobante_imagen != "")
              <div class="mb-3"> 
                  <center><img src="{{asset($ematricula->comprobante_imagen) }}" alt="" width="300px"></center>
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
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal">
                        Cerrar
                    </button>
                    <button class="btn btn-success" wire:loading.attr="disable" wire:target="save, gastos" type="button" wire:click="actualizargasto">
                        Modificar Gasto
                    </button>
                </div>
        </div>
    </div>
</div>
</div>