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
      <!---->
      <div class="col-3">
        <select class="form-select" aria-label="Default select example" wire:model="binicio">
          <option value="no">Elegir Inicio</option>
          @foreach ($inicios as $inicio)
          <option value="{{$inicio->id}}">{{$inicio->name}}</option>
          @endforeach    
        </select>
      <!---->
      </div>
      <div class="col-3">
        <select class="form-select" aria-label="Default select example" wire:model="bprograma">
          <option value="no">Elegir programa</option>
          @foreach ($programas as $programa)
          <option value="{{$programa->id}}">{{$programa->name}}</option>
          @endforeach    
        </select>
      </div>
      @if ($bprograma != "no")
      <div class="col-3"> 
        <select class="form-select" aria-label="Default select example" wire:model="bmatriculado">
          <option value="todos">Todos</option>
          <option value="matriculados">matriculados</option>
          <option value="nomatriculados">no matriculados</option>
        </select>
      </div>
      @endif
      <!--<div class="col-2"> 
        <select class="form-select" aria-label="Default select example" wire:model="blista">
          <option value="30">30</option>
          <option value="60">60</option>
          <option value="90">90</option>
          <option value="1000">all</option>   
        </select>
      </div>-->
    </div>
    @if ($bmatriculado == "matriculados")
    <div class="row pt-1">
      <div class="col-3">   
        <select class="form-select" aria-label="Default select example" wire:model="bestado">
          <option value=''>todos</option>
          <option value="pagante">Pagante</option>
          <option value="deudor">Deudor</option>
        </select>
      </div>
      @if ($bestado == 'pagante')
      <div class="col-3">   
        <select class="form-select"  aria-label="Default select example" wire:model="bagente">
          <option value="">Elegir Agente</option> 
          <option value="Banco/Agencia">Banco/Agencia</option> 
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
      </div>
      @endif
    </div>
    @endif
  </div>
    @if ($inscripciones)
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
              <th scope="col">Forma de Pago</th>
            </tr>
        </thead>
        @if ($bmatriculado == "todos")
        <tbody>
          @foreach ($inscripciones as $interesado)
            <tr>
              <td>{{$interesado->name." ".$interesado->lastname}}</td>
              <td>{{$interesado->email}}</td>
              <td>{{$interesado->dni}}</td>
              <td>{{$interesado->phone}}</td>
               @php
                $telefono=str_replace('+','',$interesado->phone);
                $telefono2 = str_replace(' ','',$telefono);
              @endphp
              <td>
              @can('admin.usuarios.administrador')
                <button  class="btn btn-danger" wire:click="$emit('deleteInscripcion',{{$interesado->id}})"><i class="fas fa-user-minus"></i></button>
              @endcan
              </td>
              @php
              $existematricula = false;
              $pertenece = false;
              foreach($interesado->matriculas as $matricula){
                if ($matricula->programa_id == $bprograma) {
                  $existematricula = true;
                  if($matricula->cajero_id == auth()->user()->id)
                  {
                    $pertenece = true;
                  }
                  $id_matricula = $matricula->id;
                  break;
                }
              }
              @endphp
              @if ($bprograma != "no")
              @if ($interesado->matriculas != "[]")
              @if($existematricula == true)
              <td>
                @if ($pertenece == true or auth()->user()->id == 1)
                <a class="btn btn-success" data-toggle="modal" data-target="#ventanaModal3" wire:click="editarmatricula({{$id_matricula}})"><i class="fas fa-edit"></i></a>
                <a href="https://api.whatsapp.com/send?phone={{$telefono2}}&text=Bienvenido%20a%20Learclass.com%20'Estudia%20sin%20límites'%0AAquí%20te%20brindo%20los%20accesos%20a%20la%20plataforma%20de%3A%0A%0Ahttps%3A%2F%2Flearclass.com%0A{{$interesado->name." ".$interesado->lastname}}%0A👤Usuario%3A%20{{$interesado->email}}%0A👁%E2%80%8D🗨Contraseña%3A%20123456789%0A%0ARecuerda%20cambiar%20tu%20contraseña%0A%0APara%20consultas%20agréganos%20en%20tus%20contactos%3A%20%0A📞💬%20%2B51%20986%20682%20565%0A📧%20hola%40learclass.com%0A%0ATutorial%20como%20acceder%20a%20la%20plataforma%0Ahttps%3A%2F%2Fwww.youtube.com%2Fwatch%3Fv%3DNOzThM7FtiI" class="btn btn-success" target="_blank"><i class="fab fa-whatsapp"></i></a>
                <button class="btn btn-danger" role="button" wire:click="enviarmensaje({{$interesado->id}})" wire:loading.attr="disabled" wire:target="enviarmensaje"><i class="fas fa-envelope"></i></button>
                @endif
              </td>
              @else
              <td>
                <button class="btn btn-dark" role="button" wire:click="matricularprograma({{$interesado->id}})" wire:loading.attr="disabled" wire:target="matricularprograma"><i class="fas fa-plus-circle"></i></button>
                <a href="https://api.whatsapp.com/send?phone={{$telefono2}}&text=Bienvenido%20a%20Learclass.com%20'Estudia%20sin%20límites'%0AAquí%20te%20brindo%20los%20accesos%20a%20la%20plataforma%20de%3A%0A%0Ahttps%3A%2F%2Flearclass.com%0A{{$interesado->name." ".$interesado->lastname}}%0A👤Usuario%3A%20{{$interesado->email}}%0A👁%E2%80%8D🗨Contraseña%3A%20123456789%0A%0ARecuerda%20cambiar%20tu%20contraseña%0A%0APara%20consultas%20agréganos%20en%20tus%20contactos%3A%20%0A📞💬%20%2B51%20986%20682%20565%0A📧%20hola%40learclass.com%0A%0ATutorial%20como%20acceder%20a%20la%20plataforma%0Ahttps%3A%2F%2Fwww.youtube.com%2Fwatch%3Fv%3DNOzThM7FtiI" class="btn btn-success" target="_blank"><i class="fab fa-whatsapp"></i></a>
                <button class="btn btn-danger" role="button" wire:click="enviarmensaje({{$interesado->id}})" wire:loading.attr="disabled" wire:target="enviarmensaje"><i class="fas fa-envelope"></i></button>
              </td>
              @endif
              @if ($matricula->comprobante_imagen)
              <td><a href="{{asset($matricula->comprobante_imagen)}}" target="_blank">ver</a></td>
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
                 <td>{{$matricula->agente}}</td>
                @else
                <td>no</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                @endif
                @else
                <td>
                  <button class="btn btn-dark" role="button" wire:click="matricularprograma({{$interesado->id}})" wire:loading.attr="disabled" wire:target="matricularprograma"><i class="fas fa-plus-circle"></i></button>
                  <a href="https://api.whatsapp.com/send?phone={{$telefono2}}&text=Bienvenido%20a%20Learclass.com%20'Estudia%20sin%20límites'%0AAquí%20te%20brindo%20los%20accesos%20a%20la%20plataforma%20de%3A%0A%0Ahttps%3A%2F%2Flearclass.com%0A{{$interesado->name." ".$interesado->lastname}}%0A👤Usuario%3A%20{{$interesado->email}}%0A👁%E2%80%8D🗨Contraseña%3A%20123456789%0A%0ARecuerda%20cambiar%20tu%20contraseña%0A%0APara%20consultas%20agréganos%20en%20tus%20contactos%3A%20%0A📞💬%20%2B51%20986%20682%20565%0A📧%20hola%40learclass.com%0A%0ATutorial%20como%20acceder%20a%20la%20plataforma%0Ahttps%3A%2F%2Fwww.youtube.com%2Fwatch%3Fv%3DNOzThM7FtiI" class="btn btn-success" target="_blank"><i class="fab fa-whatsapp"></i></a>
                  <button class="btn btn-danger" role="button" wire:click="enviarmensaje({{$interesado->id}})" wire:loading.attr="disabled" wire:target="enviarmensaje"><i class="fas fa-envelope"></i></button>
                </td>
                <td>no</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                @endif
                @else
                <td>-</td>
                @endif
          </tr>
          @endforeach
          @if ($bprograma != "no")
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>Total</td>
            <td>{{"s/. ".$tsoles}}</td>
            <td>{{"$/. ".$tdolares}}</td>
          </tr>
          @endif
        </tbody>
        @elseif($bmatriculado == "matriculados")
        <tbody>
          @foreach ($inscripciones as $interesado)
            <tr>
            <td>{{$interesado->inscripcion->name." ".$interesado->inscripcion->lastname}}</td>
            <td>{{$interesado->inscripcion->email}}</td>
            <td>{{$interesado->inscripcion->dni}}</td>
            <td>{{$interesado->inscripcion->phone}}</td>
            @php
                $telefono  = str_replace('+','',$interesado->inscripcion->phone);
                $telefono2 = str_replace(' ','',$telefono);
            @endphp
            <td>
              @can('admin.usuarios.administrador')
              <button  class="btn btn-danger" wire:click="$emit('deleteInscripcion',{{$interesado->inscripcion->id}})"><i class="fas fa-user-minus"></i></button></td>
              @endcan
              <td>
              <a class="btn btn-success" data-toggle="modal" data-target="#ventanaModal3" wire:click="editarmatricula({{$interesado->id}})"><i class="fas fa-edit"></i></a>
              <a href="https://api.whatsapp.com/send?phone={{$telefono2}}&text=Bienvenido%20a%20Learclass.com%20'Estudia%20sin%20límites'%0AAquí%20te%20brindo%20los%20accesos%20a%20la%20plataforma%20de%3A%0A%0Ahttps%3A%2F%2Flearclass.com%0A{{$interesado->inscripcion->name." ".$interesado->inscripcion->lastname}}%0A👤Usuario%3A%20{{$interesado->inscripcion->email}}%0A👁%E2%80%8D🗨Contraseña%3A%20123456789%0A%0ARecuerda%20cambiar%20tu%20contraseña%0A%0APara%20consultas%20agréganos%20en%20tus%20contactos%3A%20%0A📞💬%20%2B51%20986%20682%20565%0A📧%20hola%40learclass.com%0A%0ATutorial%20como%20acceder%20a%20la%20plataforma%0Ahttps%3A%2F%2Fwww.youtube.com%2Fwatch%3Fv%3DNOzThM7FtiI" class="btn btn-success" target="_blank"><i class="fab fa-whatsapp"></i></a>
              <button class="btn btn-danger" role="button" wire:click="enviarmensaje({{$interesado->inscripcion->id}})" wire:loading.attr="disabled" wire:target="enviarmensaje"><i class="fas fa-envelope"></i></button>
            </td>
            @if ($interesado->comprobante_imagen)
            <td>
              <a href="{{asset($interesado->comprobante_imagen)}}" target="_blank">ver</a>   
            </td>
            @if ($interesado->tipo == "Soles")
                  <td>{{"s/. ".$interesado->costo}}</td>
                  @php $tsoles = $tsoles + $interesado->costo;@endphp  
                  @else
                  <td>-</td>
                  @endif
                  @if ($interesado->tipo == "Dolares")
                  <td>{{"$/. ".$interesado->costo}}</td>  
                  @php $tdolares = $tdolares + $interesado->costo;@endphp 
                  @else
                  <td>-</td>
                  @endif
                  <td>{{$interesado->agente}}</td>
            @else
            <td>no</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            @endif
          </tr>
          @endforeach
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>Total</td>
            <td>{{"s/. ".$tsoles}}</td>
            <td>{{"$/. ".$tdolares}}</td>
          </tr>
        </tbody>
        @elseif($bmatriculado == "nomatriculados")
        <tbody>
          @foreach ($inscripciones as $interesado)
            <tr>
            <td>{{$interesado->name." ".$interesado->lastname}}</td>
            <td>{{$interesado->email}}</td>
            <td>{{$interesado->dni}}</td>
            <td>{{$interesado->phone}}</td>
            @php
                $telefono=str_replace('+','',$interesado->phone);
                $telefono2 = str_replace(' ','',$telefono);
            @endphp
            @can('admin.usuarios.administrador')
            <td><button  class="btn btn-danger" wire:click="$emit('deleteInscripcion',{{$interesado->inscripcion_id}})"><i class="fas fa-user-minus"></i></button></td>
            @endcan
            <td>
              <button class="btn btn-dark" role="button" wire:click="matricularprograma({{$interesado->inscripcion_id}})" wire:loading.attr="disabled" wire:target="matricularprograma"><i class="fas fa-plus-circle"></i></button>
              <a href="https://api.whatsapp.com/send?phone={{$telefono2}}&text=Bienvenido%20a%20Learclass.com%20'Estudia%20sin%20límites'%0AAquí%20te%20brindo%20los%20accesos%20a%20la%20plataforma%20de%3A%0A%0Ahttps%3A%2F%2Flearclass.com%0A{{$interesado->name." ".$interesado->lastname}}%0A👤Usuario%3A%20{{$interesado->email}}%0A👁%E2%80%8D🗨Contraseña%3A%20123456789%0A%0ARecuerda%20cambiar%20tu%20contraseña%0A%0APara%20consultas%20agréganos%20en%20tus%20contactos%3A%20%0A📞💬%20%2B51%20986%20682%20565%0A📧%20hola%40learclass.com%0A%0ATutorial%20como%20acceder%20a%20la%20plataforma%0Ahttps%3A%2F%2Fwww.youtube.com%2Fwatch%3Fv%3DNOzThM7FtiI" class="btn btn-success" target="_blank"><i class="fab fa-whatsapp"></i></a>
              <button class="btn btn-danger" role="button" wire:click="enviarmensaje({{$interesado->inscripcion_id}})" wire:loading.attr="disabled" wire:target="enviarmensaje"><i class="fas fa-envelope"></i></button>
            </td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
          </tr>
          @endforeach
        </tbody>
        @endif
        nº : {{$inscripciones->count()}}
      </table>
      
    @else
        <div class="px-6 py-4">
                No existe ningun registro coincidente
        </div>
    @endif
    

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