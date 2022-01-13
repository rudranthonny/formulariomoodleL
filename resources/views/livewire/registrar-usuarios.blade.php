<div>
    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#ventanaModal">
        <i class="fas fa-plus-circle"></i> Nuevo Alumno
    </button>
<div wire:ignore.self class="modal face" id="ventanaModal" tabindex="-2" role="dialog" aria-labelledby="tituloVentana" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">    
                <div class="modal-header">
                    <h5 id="tituloVentana">Subir Usuarios</h5>
                    <button class="close" data-dismiss="modal" arial-label="cerrar">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" aria-describedby="emailHelp">
                    </div>               
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal">
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
