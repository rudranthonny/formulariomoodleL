<div>
    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ventanaModal2" style="color : white">
        <i class="fas fa-upload"></i> Subir Inscripciones
    </button>
<div wire:ignore.self class="modal face" id="ventanaModal2" tabindex="-2" role="dialog" aria-labelledby="tituloVentana2" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">    
                <div class="modal-header">
                    <h5 id="tituloVentana2">Subir Usuarios</h5>
                    <button class="close" data-dismiss="modal" arial-label="cerrar">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6><strong>el archivo tiene que ser csv</strong></h6>
                    <div class="p-4">
                        <input type="file" wire:model="inscripciones" accept=".zip">
                    </div>
                    <div class="alert alert-danger text-end"  wire:loading wire:target="inscripciones" style="display:none">
                        por favor espere
                    </div>
                    <strong>{{$resultado2}}</strong> 
                    <p class="alert alert-secondary"><a href="https://docs.google.com/spreadsheets/d/e/2PACX-1vS4C3c8lCJ2a0_yO8cWYQD20xWq98hch0KhodXzjwzAQgnRGeVRyk3hL2t8k5is8fQyyzerGvOtaYM5/pubhtml" target="_blank">Fomato para subir inscripciones "Clic Aqu&iacute;"</a></p>                     
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal2">
                        Cerrar
                    </button>
                    <button class="btn btn-success" wire:loading.attr="disable" wire:target="save, inscripciones" type="button" wire:click="subirinscripciones">
                        Subir Inscripciones
                    </button>
                </div>
        </div>
    </div>
</div>
</div>