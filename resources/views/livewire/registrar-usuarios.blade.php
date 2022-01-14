<div>
    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#ventanaModal">
        <i class="fas fa-plus-circle"></i> Nuevo Alumno
    </button>
<div wire:ignore.self class="modal face" id="ventanaModal" tabindex="-2" role="dialog" aria-labelledby="tituloVentana" aria-hidden="true" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">    
                <div class="modal-header">
                    <h5 id="tituloVentana">Agregar Alumno</h5>
                    <button class="close" data-dismiss="modal" arial-label="cerrar">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="email" class="form-label">email</label>
                        <input type="email" class="form-control" id="email" aria-describedby="emailHelp" wire:model="email">
                        {{$email}}
                        @error('email')
                            <span>{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="dni" class="form-label">dni</label>
                        <input type="text" class="form-control" id="dni" aria-describedby="emailHelp" wire:model="dni">
                        @error('dni')
                            <span>{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" aria-describedby="emailHelp" wire:model="name" @if ($usuario) value="{{$usuario->name}}"@endif>
                        @error('name')
                            <span>{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="lastname" aria-describedby="emailHelp" wire:model="lastname">
                        @error('lastname')
                            <span>{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <select class="form-select" name="country" wire:model="country">
                        <option value="AR">Argentina</option>
                        <option value="BO">Bolivia</option>
                        <option value="CL">Chile</option>                                    
                        <option value="CO">Colombia</option>
                        <option value="CR">Costa Rica</option>
                        <option value="EC">Ecuador</option>
                        <option value="MX">Mexico</option>
                        <option value="SV">El Salvador</option>
                        <option value="ES">España</option>
                        <option value="GT">Guatemala</option>
                        <option value="HN">Hondura</option>
                        <option value="NI">Nicaragua</option>
                        <option value="PA">Panama</option>
                        <option value="PY">Paraguay</option>
                        <option value="PE">Perú</option>
                        <option value="CR">Puerto Rico</option>
                        <option value="DO">Republica Dominicana</option>
                        <option value="UY">Uruguay</option>
                        <option value="VE">Venezuela</option>
                        <option value="EU">E.E.U.U</option>
                        </select>
                        @error('country')
                            <span>{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Celular</label>
                        <input type="text" class="form-control" id="phone" aria-describedby="emailHelp" wire:model="phone">
                        @error('phone')
                            <span>{{$message}}</span>
                        @enderror
                    </div>         
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal">
                        Cerrar
                    </button>
                    <button class="btn btn-success" wire:loading.attr="disable" wire:target="save, inscripciones" type="button" wire:click="registrarinscripcion">
                        Subir Inscripciones
                    </button>
                </div>
        </div>
    </div>
</div>
</div>
