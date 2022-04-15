<div>
    <div class="m-4">
        <a class="btn btn-danger" id="agregar" href="{{ route('admin.usuarios.create') }}" role="button"><i class="fas fa-user-plus"></i> Agregar Usuario</a>  
    </div>
    <div class="m-4">
        <input class="form-control" id="exampleDataList" placeholder="Buscar usuario" wire:model="search">
    </div>
    <div class="m-4 ">
        @if ($usuarios->count())
        <div class="table-responsive">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th class="cursor" scope="col" wire:click="order('name')">Nombres
                            {{-- sort --}}
                            @if ($sort == 'name')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
                                @else
                                    <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
                                @endif
                            @else
                                <i class="fas fa-sort float-right mt-1"></i>
                            @endif
                        </th>
                        <th scope="col">Email</th>
                        <th scope="col">Roles</th>
                        <th scope="col">Estados</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr>
                                <td>{{ $usuario->name }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>
                                    @foreach ($usuario->roles as $role)
                                        {{$role->name}}
                                    @endforeach
                                </td>
                                <td>
                                    <a class="btn btn-success" id="editarestudiante" href="{{ route('admin.usuarios.edit', $usuario->id) }}"
                                        role="button"><i class="fas fa-edit"></i></a>
                                    <a class="btn btn-danger" id="eliminarusuario" href="#"
                                        onclick="eliminar('eliminar-{{ $usuario->id }}')"><i class="fas fa-trash"></i></a>
                                    <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}"
                                        id="eliminar-{{ $usuario->id }}" method="POST" class="b-eliminar">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
                @else
                <div class="px-6 py-4">
                    No existe ningun registro coincidente
                </div>
            @endif
            <div class="d-flex justify-content-end">
                {{ $usuarios->links() }}
            </div>
        </div>
        <br>
</div>