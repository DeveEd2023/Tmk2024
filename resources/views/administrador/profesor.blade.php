@extends('layouts.master')
@section('title', 'Intituciones')
@section('content')
    <h3 style="font-family: Franklin Gothic; text-align: center;"> <i class="ri-shield-user-line"></i> Profesores</h3>
    <hr style="color: #54ac7c;  border-width: 4px;">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                role="tab" aria-controls="home" aria-selected="true">SECCIONES / ENCARGADO</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                role="tab" aria-controls="profile" aria-selected="false">ESPECIALIDADES</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <br>
            <h5>LISTADO DE PROFESORES ASIGNADOS A UNA SECCI&Oacute;N.</h5><br>
            <div class="pull-left box-tools">
                <a href="{{ url('admin/nuevoEn') }}">
                    <button type="button" class="btn btn-outline-success"><i class="ri-user-add-line"></i>
                        Nuevo Encargado
                    </button>
                </a>
            </div>
            <br>
            <div class="box-body pad">
                <table id="<ttareas></ttareas>" class="table table-bordered table-striped datatable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Profesor</th>
                            <th>Institución</th>
                            <th>Grado</th>
                            <th>Sección</th>
                            <th>Turno</th>
                            <th>Estado</th>
                            <th>Orientador</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $cont = 1; ?>
                        @foreach ($profesores as $profesor)
                            <tr align="left">
                                <td>{{ $cont }}</td>
                                <td>{{ $profesor->nombres . ' ' . $profesor->apellidos }}</td>
                                <td>{{ $profesor->institucion }}</td>
                                <td>{{ $profesor->grado }}</td>
                                <td>{{ $profesor->seccion }}</td>
                                <td>{{ $profesor->turno }}</td>
                                @if ($profesor->estado == 1)
                                    <td>Activa</td>
                                @else
                                    <td>Inactiva</td>
                                @endif
                                @if ($profesor->encargado == 1)
                                    <td align="center"><i class="bi bi-check-lg" aria-hidden="true"></i></td>
                                @else
                                    <td></td>
                                @endif
                                <td align="center">

                                    <a data-toggle="tooltip" title="Eliminar Profesor" id="{{ $profesor->encargado_id }}"
                                        class="eliminar" name="{{ $profesor->nombres . ' ' . $profesor->apellidos }}"
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
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <br>
            <h5>LISTADO DE PROFESORES ASIGNADOS A UNA SECCI&Oacute;N POR ESPECIALIDAD.</h5><br>
            <div class="pull-left box-tools">
                <a href="{{ url('admin/nuevoEs') }}">
                    <button type="button" class="btn btn-outline-success"><i class="ri-user-add-line"></i>
                        Profesor Especial
                    </button>
                </a>
            </div>
            <br>
            <div class="box-body pad">
                <table id="ttareas" class="table table-bordered table-striped datatable">
                    <thead>
                        <tr>
                        <tr>
                            <th>No.</th>
                            <th>Profesor</th>
                            <th>Institución</th>
                            <th>Grado</th>
                            <th>Sección</th>
                            <th>Turno</th>
                            <th>Especialidad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $cont = 1; ?>
                        @foreach ($especialidades as $especialidad)
                            <tr align="left">
                                <td>{{ $cont }}</td>
                                <td>{{ $especialidad->nombres . ' ' . $especialidad->apellidos }}</td>
                                <td>{{ $especialidad->institucion }}</td>
                                <td>{{ $especialidad->grado }}</td>
                                <td>{{ $especialidad->seccion }}</td>
                                <td>{{ $especialidad->turno }}</td>
                                <td>{{ $especialidad->materia }}</td>
                                @if ($especialidad->estado == 1)
                                    <td>Activa</td>
                                @else
                                    <td>Inactiva</td>
                                @endif
                                <td align="center">
                                    <a data-toggle="tooltip" title="Eliminar Profesor especial"
                                        id="{{ $especialidad->profesor_id }}" class="eliminar2"
                                        name="{{ $especialidad->nombres . ' ' . $especialidad->apellidos }}"
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




    <!------------------------------------------------ modal eliminar --------------------------------------------------------------------->

    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: red ">
                    <h5 class="modal-title" style="color: #fff; text-align: center;">
                        <i class="ri-chat-delete-line"></i> Eliminar profesor
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
        //eliminar
        function confirmarEliminacion(id, name, url) {
            $('#confirmMessage').html(`¿Está seguro que quiere eliminar el usuario: <strong>${name}</strong>?`);
            $('#confirmModal').modal('show');
            $('#confirmBtn').off('click').on('click', function() {
                window.location.href = `${url}/${id}`;
            });
        }

        $('body').on('click', '.eliminar', function() {
            const id = $(this).attr('id');
            const name = $(this).attr('name');
            const url = 'eliminarEncargado';
            confirmarEliminacion(id, name, url);
        });

        $('body').on('click', '.eliminar2', function() {
            const id = $(this).attr('id');
            const name = $(this).attr('name');
            const url = 'eliminarEspecial';
            confirmarEliminacion(id, name, url);
        });
    </script>
@endsection
