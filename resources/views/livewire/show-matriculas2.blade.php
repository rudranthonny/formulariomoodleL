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
                    <th>Estado</th>
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
                    <td><a class="btn btn-success" data-toggle="modal" data-target="#ventanaModal3" wire:click="editarmatricula({{$matricula->id}})"><i class="fas fa-edit"></i></a></td>
                </tr>  
                @endforeach
            </tbody>
        </table>
    </div>
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
              <input type="file" name="comprobante_imagen" accept="image/*" wire:model="ecomprobante_imagen_file" id="upload{{$iteration}}">
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
                    <button class="btn btn-success" wire:loading.attr="disabled" wire:target="save, matriculas" type="button" wire:click="actualizarmatriculas">
                        Modificar Matricula
                    </button>
          </div>
        </div>
    </div>
  </div>
</div>
