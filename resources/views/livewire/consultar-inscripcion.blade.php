<div class="col-xl-7 col-lg-12 d-flex">
    <div class="container align-self-center p-6">
        <h1 class="font-weight-bold mb-3">Inscripsción 2022</h1>
        <form action="{{route('inscripcion.registrar')}}" method="POST" class="formulario-inscripcion">
            @csrf
            <div class="form-row mb-2">
                <div class="form-group col-md-6">
                    <input type="text"  wire:model="search" name="email" class="form-control" placeholder="Email" >
                </div>
                @error('email')
                <span class="text-lightr">{{$message}}</span>
                @enderror
                <div class="form-group col-md-6">
                    <input type="text" name="dni" class="form-control" placeholder="DNI/CURP/DUI" @if ($inscripcion) value="{{$inscripcion->dni}}"@endif>
                </div>
                @error('dni')
                <span class="text-lightr">{{$message}}</span>
                @enderror
            </div> 
            <div class="form-row mb-2">
                <div class="form-group col-md-6">
                    <input type="text" name="name" class="form-control" placeholder="Nombres"  @if ($inscripcion) value="{{$inscripcion->name}}"@endif>
                </div>
                @error('name')
                <span class="text-light">{{$message}}</span>
                @enderror
                <div class="form-group col-md-6">
                    <input type="text" name="lastname" class="form-control" placeholder="Apellidos" @if ($inscripcion) value="{{$inscripcion->lastname}}"@endif>
                </div>
                @error('lastname')
                <span class="text-light">{{$message}}</span>
                @enderror
                
            </div>
            <div class="form-row mb-2">
                <div class="form-group col-md-6">
                    <select class="form-select" name="country">
                        @if ($inscripcion)
                        @if ($inscripcion->country == 'AR')
                        <option value="AR" selected>Argentina</option>   
                        @else
                        <option value="AR">Argentina</option>  
                        @endif
                        @if ($inscripcion->country == 'BO')
                        <option value="BO" selected>Bolivia</option>
                        @else
                        <option value="BO">Bolivia</option>
                        @endif
                        @if ($inscripcion->country == 'CL')
                        <option value="CL" selected>Chile</option>  
                        @else
                        <option value="CL">Chile</option> 
                        @endif
                        @if ($inscripcion->country == 'CO')
                        <option value="CO" selected>Colombia</option>
                        @else
                        <option value="CO">Colombia</option>
                        @endif
                        @if ($inscripcion->country == 'CR')
                        <option value="CR" selected>Costa Rica</option>
                        @else
                        <option value="CR">Costa Rica</option>
                        @endif
                        @if ($inscripcion->country == 'EC')
                        <option value="EC" selected>Ecuador</option>
                        @else
                        <option value="EC">Ecuador</option>
                        @endif
                        @if ($inscripcion->country == 'SV')
                        <option value="SV" selected>El Salvador</option>
                        @else
                        <option value="SV">El Salvador</option>
                        @endif
                        @if ($inscripcion->country == 'GT')
                        <option value="GT" selected>Guatemala</option>
                        @else
                        <option value="GT">Guatemala</option>
                        @endif
                        @if ($inscripcion->country == 'HN')
                        <option value="HN" selected>Hondura</option>
                        @else
                        <option value="HN">Hondura</option>
                        @endif
                        @if ($inscripcion->country == 'NI')
                        <option value="NI" selected>Nicaragua</option>
                        @else
                        <option value="NI">Nicaragua</option>
                        @endif
                        @if ($inscripcion->country == 'PA')
                        <option value="PA" selected>Panama</option>
                        @else
                        <option value="PA">Panama</option>
                        @endif
                        @if ($inscripcion->country == 'PY')
                        <option value="PY" selected>Paraguay</option>
                        @else
                        <option value="PY">Paraguay</option>
                        @endif
                        @if ($inscripcion->country == 'PE')
                        <option value="PE" selected>Perú</option>
                        @else
                        <option value="PE">Perú</option>
                        @endif
                        @if ($inscripcion->country == 'CR')
                        <option value="CR" selected>Puerto Rico</option>
                        @else
                        <option value="CR">Puerto Rico</option>
                        @endif
                        @if ($inscripcion->country == 'DO')
                        <option value="DO" selected>Republica Dominicana</option>
                        @else
                        <option value="DO">Republica Dominicana</option>
                        @endif
                        @if ($inscripcion->country == 'UY')
                        <option value="UY" selected>Uruguay</option>
                        @else
                        <option value="UY">Uruguay</option>
                        @endif
                        @if ($inscripcion->country == 'VE')
                        <option value="VE" selected>Venezuela</option>
                        @else
                        <option value="VE">Venezuela</option>
                        @endif
                        @if ($inscripcion->country == 'EU')
                        <option value="EU" selected>E.E.U.U</option>
                        @else
                        <option value="EU">E.E.U.U</option>
                        @endif
                        @if ($inscripcion->country == 'MX')
                        <option value="MX" selected>Mexico</option>
                        @else
                        <option value="MX">Mexico</option>
                        @endif
                        @else
                        @endif
                        <option value="PE" >Elegir el País</option>
                        <option value="AR">Argentina</option>
                        <option value="BO">Bolivia</option>
                        <option value="CL">Chile</option>                                    
                        <option value="CO">Colombia</option>
                        <option value="CR">Costa Rica</option>
                        <option value="EC">Ecuador</option>
                        <option value="MX">Mexico</option>
                        <option value="SV">El Salvador</option>
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
                      </div>
                @error('country')
                        <span class="text-lightr">{{$message}}</span>
                        @enderror
                <div class="form-group col-md-6">
                    <input type="tel" id="phone" name="phone" class="form-control" placeholder="Celular" @if ($inscripcion) value="{{$inscripcion->phone}}"@endif>
                </div>
                @error('phone')
                <span class="text-lightr">{{$message}}</span>
                @enderror
            </div> 
            <div class="form-group mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" name="politicas" id="politicas">
                    <label class="form-check-label text-muted" for="politicas"><a onclick="document.getElementById('politicas').checked">Al seleccionar esta casilla aceptas nuestro aviso de privacidad y los términos y condiciones</a></label>
                    @error('politicas')
                        <span class="text-lightr">Aceptar nuestras políticas para realizar la inscripción.</span>
                        @enderror
                </div>  
            </div>
            <button class="btn btn-primary width-100" type="submit">Regístrate</button>
        </form>
        <small class="d-inline-block text-muted mt-5">Todos los derechos reservados | ©2022 Learclass</small>
    </div>
</div>