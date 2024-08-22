@extends('layouts.master')
@section('title', 'Intituciones')

@section('content')
    <h3 style="font-family: Franklin Gothic; text-align: center"> <i class="bx bxs-user-detail"></i> Usuarios</h3>
    <hr style="color: #54ac7c;  border-width: 4px;">
    <div class="col-md-12">
        <div class="">

            <div class="pull-left box-tools">
                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalCrear"><i
                        class="ri-user-add-line"></i>
                    Nuevo Usuario
                </button>
            </div>
            <br>
            <div class="box-body pad">
                <table id="datatable" class="table table-bordered table-striped datatable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th style="width: 10%">Nombres</th>
                            <th>Apellidos</th>
                            <th>Institucion</th>
                            <th style="width: 8%">Usuario</th>
                            <th style="width: 8%">Contraseña</th>
                            <th>Rol</th>
                            <th>Inscripci&oacute;n</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $cont = 1; ?>
                        @foreach ($usuarios as $usuario)
                            <tr align="left">
                                <td>{{ $cont }}</td>
                                <td>{{ $usuario->nombres }}</td>
                                <td>{{ $usuario->apellidos }}</td>
                                <td>{{ $usuario->institucion }}</td>
                                <td>{{ $usuario->usuario }}</td>
                                <td>{{ $usuario->plano }}</td>
                                <td>{{ $usuario->rol }}</td>
                                <td>{{ \Carbon\Carbon::parse($usuario->fecha)->format('d-m-Y') }}</td>
                                <td>
                                    @if ($usuario->estado === 1)
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </td>
                                <td align="center">
                                    <a data-toggle="tooltip" href="#" title="editarUsuario"
                                        data-value-editar="{{ $usuario->id }}">
                                        <i class="bx bxs-pencil"></i>
                                    </a>
                                    &nbsp;&nbsp;
                                    <a data-toggle="tooltip" title="Eliminar Usuario" id="{{ $usuario->id }}"
                                        class="eliminar" name="{{ $usuario->nombres . ' ' . $usuario->apellidos }}"
                                        href="#"><i class="bx bxs-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php $cont++; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!------------------------------------------------ modal crear --------------------------------------------------------------------->

    <div class="modal fade" id="modalCrear" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #57ad7a ">
                    <h5 class="modal-title" style="color: #fff; text-align: center;">
                        <i class="bx bxs-user-detail"></i> Crear usuario
                    </h5>
                </div>
                <form id="userForm" action="{{ url('admin/nuevoUsuario') }}" method="POST">
                    @csrf
                    <div class="modal-body row" id="cont_modal">
                        <div class="col-md-6">
                            <div class="form-group">
                                <i class="ri-file-user-line"></i> <label for="nombre"> Nombre:</label>
                                <input type="text" id="nombre" name="nombre" class="form-control"
                                    placeholder="Digite los nombres" required>
                            </div><br>
                            <div class="form-group">
                                <i class="ri-file-user-line"></i> <label for="apellido"> Apellido</label>
                                <input type="text" id="apellido" name="apellido"
                                    class="form-control"placeholder="Digite los apellidos" required>
                            </div><br>
                            <div class="form-group">

                                <i class="ri-mail-check-line"></i> <label for="correo"> correo</label>
                                <input type="text" id="correo" name="correo" required class="form-control"
                                    placeholder="Digite correo electronico">
                            </div><br>
                            <div class="form-group">
                                <i class="ri-phone-line"></i> <label for="telefono"> tel&eacute;fono</label>
                                <input type="text" id="telefono" name="telefono" required class="form-control"
                                    placeholder="Digite numero telefonico">
                            </div><br>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <i class="bx  bxs-brightness"></i>
                                <label for="rol"> Rol</label>
                                <select name="rol" class="form-select" id="rol">
                                    <option selected disabled>Selecciona un rol</option>
                                    @foreach ($rol as $r)
                                        <option value="{{ $r->id }}">{{ $r->rol_nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div><br>
                            <div class="form-group">
                                <label for="institucio">
                                    <i class="bx bxs-bank"></i> Institución
                                </label><br>
                                <input type="text" class="form-control" id="filtro" placeholder="Buscar institución">
                                <select name="institucion" class="form-select mt-2" id="institucion">
                                    <option selected disabled>Selecciona una institución</option>
                                    @foreach ($institucion as $i)
                                        <option value="{{ $i->id }}">{{ $i->ins_nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <i class="bx bxs-user-check"></i> <label for="usuario">usuario</label>
                                <input type="text" id="usuario" name="usuario" required class="form-control"
                                    placeholder="Digite nombre de usuario">
                            </div><br>
                            <div class="form-group">
                                <i class="ri-lock-password-fill"></i> <label for="contraseña">Contraseña</label>
                                <input type="text" id="contraseña" name="contraseña" required
                                    class="form-control"placeholder="Digite contraseña">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-secondary" data-bs-dismiss="modal" style="border: none;"
                            aria-label="Close">Cerrar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!------------------------------------------------ modal editar --------------------------------------------------------------------->

    <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #dea500 ">
                    <h5 class="modal-title" style="color: #fff; text-align: center;">
                        <i class="ri-user-settings-line"></i> Editar usuario
                    </h5>
                </div>
                <form id="userForm" action="{{ url('admin/editarUsuario') }}" method="POST">
                    @csrf
                    <div class="modal-body row" id="cont_modal">
                        <div class="col-md-6">
                            <input id="uid" name="id" hidden>
                            <div class="form-group">
                                <i class="ri-file-user-line"></i> <label for="nombre"> Nombre:</label>
                                <input type="text" id="Unombre" name="Unombre" class="form-control"
                                    placeholder="Digite los nombres" required>
                            </div><br>
                            <div class="form-group">
                                <i class="ri-file-user-line"></i> <label for="apellido"> Apellido</label>
                                <input type="text" id="Uapellido" name="Uapellido"
                                    class="form-control"placeholder="Digite los apellidos" required>
                            </div><br>
                            <div class="form-group">
                                <i class="ri-mail-check-line"></i> <label for="correo"> correo</label>
                                <input type="text" id="Ucorreo" name="Ucorreo" required class="form-control"
                                    placeholder="Digite correo electronico">
                            </div><br>
                            <div class="form-group">
                                <i class="ri-phone-line"></i> <label for="telefono"> tel&eacute;fono</label>
                                <input type="text" id="Utelefono" name="Utelefono" required class="form-control"
                                    placeholder="Digite numero telefonico">
                            </div><br>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="institucio">
                                    <i class="bx bxs-bank"></i> Institución
                                </label><br>
                                <input type="text" class="form-control" id="filtro"
                                    placeholder="Buscar institución">
                                <select name="institucion" class="form-select mt-2">
                                    <option selected disabled>Selecciona una institución</option>
                                    @foreach ($institucion as $i)
                                        <option value="{{ $i->id }}">{{ $i->ins_nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <i class="bx bxs-user-check"></i> <label for="usuario">usuario</label>
                                <input type="text" id="Uusuario" name="Uusuario" required class="form-control"
                                    placeholder="Digite nombre de usuario">
                            </div><br>
                            <div class="form-group">
                                <i class="ri-lock-password-fill"></i> <label for="contraseña">Contraseña</label>
                                <input type="text" id="contraseña" name="contraseña"
                                    class="form-control"placeholder="Digite contraseña">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-secondary" data-bs-dismiss="modal" style="border: none;"
                            aria-label="Close">Cerrar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!------------------------------------------------ modal eliminar --------------------------------------------------------------------->

    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: red ">
                    <h5 class="modal-title" style="color: #fff; text-align: center;">
                        <i class="ri-chat-delete-line"></i> Elimiar Usuario
                    </h5>
                </div>
                <div class="modal-body">
                    <p id="confirmMessage"></p>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-secondary" data-bs-dismiss="modal" style="border: none;"
                        aria-label="Close">Cerrar</a>
                    <button type="button" class="btn btn-danger" id="confirmBtn">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        //buscador de instituciones 
        document.getElementById('filtro').addEventListener('input', function() {
            var filtro = this.value.toLowerCase();
            var opciones = document.querySelectorAll('#institucion option');
            opciones.forEach(function(opcion) {
                var textoOpcion = opcion.textContent.toLowerCase();
                var esVisible = textoOpcion.includes(filtro);
                if (esVisible) {
                    opcion.style.display = 'block';
                } else {
                    opcion.style.display = 'none';
                }
            });
        });

        //editar
        const modal_editar = new bootstrap.Modal("#modalEditar");
        const button_editar = document.querySelectorAll("[data-value-editar]");
        const codigo = document.getElementById("uid");
        const enombre = document.getElementById("Unombre");
        const eapellido = document.getElementById("Uapellido");
        const etel = document.getElementById("Utelefono");
        const ecorreo = document.getElementById("Ucorreo");
        const euser = document.getElementById("Uusuario");

        [].slice.call(button_editar).forEach(async function(item) {
            item.addEventListener('click', async () => {
                await fetch("{{ url('admin/buscarUsuario') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            "id": item.getAttribute("data-value-editar")
                        }),
                    }).then((response) => response.json())
                    .then((data) => {
                        codigo.value = data.id;
                        enombre.value = data.nombre;
                        eapellido.value = data.apellido;
                        etel.value = data.telefono;
                        ecorreo.value = data.correo;
                        euser.value = data.user;
                        modal_editar.show();
                    });
            });
        });

        //eliminar
        $('body').on('click', '.eliminar', function() {
            const id = $(this).attr('id');
            const name = $(this).attr('name');
            console.log('Institucion: ' + name);
            $('#confirmMessage').html(`¿Está seguro que quiere eliminar el usuario: <strong>${name}</strong>?`);
            $('#confirmModal').modal('show');
            $('#confirmBtn').on('click', function() {
                window.location.href = `eliminarUsuario/${id}`;
            });
        });
    </script>

@endsection
