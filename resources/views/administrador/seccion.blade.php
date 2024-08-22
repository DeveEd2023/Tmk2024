@extends('layouts.master')
@section('title', 'Intituciones')
@section('content')


    <h3 style="font-family: Franklin Gothic; text-align: center;"> <i class="ri-bookmark-fill"></i> Secci&oacute;n</h3>
    <hr style="color: #54ac7c;  border-width: 4px;">
    <section class="content">
        <div class="row">

            <div class="pull-left box-tools">
                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalCrear"><i
                        class="ri-bookmark-fill"></i>
                    Nueva secci&oacute;n
                </button>
            </div>
            <br>
            <br>
            <div class="col-md-12">
                <div class="">
                    <div class="box-body pad">
                        <table id="ttareas" class="table table-bordered table-striped datatable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th style="width: 30%">Institución</th>
                                    <th>Grado</th>
                                    <th>Sección</th>
                                    <th>Turno</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $cont = 1; ?>
                                @foreach ($secciones as $seccion)
                                    <tr align="left">
                                        <td>{{ $cont }}</td>
                                        <td>{{ $seccion->institucion }}</td>
                                        <td>{{ $seccion->grado }}</td>
                                        <td>{{ $seccion->seccion }}</td>
                                        <td>{{ $seccion->turno }}</td>
                                        <td>
                                            @if ($seccion->estado == 1)
                                                Activa
                                            @else
                                                Inactiva
                                            @endif
                                        </td>
                                        <td align="center">
                                            <a data-toggle="tooltip" title="Eliminar Seccion"
                                                id="{{ $seccion->seccion_id }}" class="eliminar"
                                                name="{{ '<br> Institucion: ' . $seccion->institucion . '<br> Secci&oacute;n: ' . $seccion->seccion }}"
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
        </div>
    </section>

    <!------------------------------------------------ modal crear --------------------------------------------------------------------->

    <div class="modal fade" id="modalCrear" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #57ad7a ">
                    <h5 class="modal-title" style="color: #fff; text-align: center;">
                        <i class="ri-bookmark-fill"></i> Nueva secci&oacute;n
                    </h5>
                </div>
                <form id="userForm" action="{{ url('admin/nuevaSeccion') }}" method="POST">
                    @csrf
                    <div class="modal-body row" id="cont_modal">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="institucio">
                                    <i class="bx bxs-bank"></i> Institución
                                </label><br>
                                <select name="institucion" class="form-select mt-2" id="institucion">
                                    <option selected disabled>Selecciona una institución</option>
                                    @foreach ($institucion as $i)
                                        <option value="{{ $i->id }}">{{ $i->institucion }}</option>
                                    @endforeach
                                </select>
                            </div><br>
                            <div class="form-group">
                                <label for="grado">
                                    <i class="bx bxs-chevrons-up"></i> Grado
                                </label><br>
                                <select name="grado" class="form-select mt-2" id="grado">
                                    <option selected disabled>Selecciona un grado</option>
                                </select>
                            </div><br>
                            <div class="form-group">
                                <label for="seccion">
                                    <i class="ri-bookmark-fill"></i> Secci&oacute;n
                                </label><br>
                                <select name="seccion" class="form-select mt-2" id="seccion">
                                    <option selected disabled>Selecciona una secci&oacute;n</option>
                                    @foreach ($lseccion as $s)
                                        <option value="{{ $s->id }}">{{ $s->cat_seccion }}</option>
                                    @endforeach
                                </select>
                            </div><br>
                            <div class="form-group">
                                <label for="turno">
                                    <i class="ri-time-line"></i> Secci&oacute;n
                                </label><br>
                                <select name="turno" class="form-select mt-2" id="turno">
                                    <option selected disabled>Selecciona un turno</option>
                                    @foreach ($turno as $t)
                                        <option value="{{ $t->id }}">{{ $t->cat_turno }}</option>
                                    @endforeach
                                </select>
                            </div><br>
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

    <!------------------------------------------------ modal Eliminar --------------------------------------------------------------------->

    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: red ">
                    <h5 class="modal-title" style="color: #fff; text-align: center;">
                        <i class="ri-chat-delete-line"></i> Elimiar Secci&oacute;n
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
        document.addEventListener('DOMContentLoaded', function() {
            const institucionSelect = document.getElementById('institucion');
            const gradoSelect = document.getElementById('grado');

            institucionSelect.addEventListener('change', function() {
                const institucionId = this.value;

                fetch(`/admin/obtenerGrado/${institucionId}`)
                    .then(response => response.json())
                    .then(data => {
                        gradoSelect.innerHTML =
                            '<option selected disabled>Selecciona un grado</option>';


                        data.forEach(grado => {
                            const option = document.createElement('option');
                            option.value = grado.id;
                            option.textContent = grado.cat_grado;
                            gradoSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error al obtener los grados:', error));
            });
        });

        //eliminar
        $('body').on('click', '.eliminar', function() {
            const id = $(this).attr('id');
            const name = $(this).attr('name');
            console.log('Institucion: ' + name);
            $('#confirmMessage').html(
                `¿Está seguro que quiere eliminar la Secci&oacute;n: <strong>${name}</strong> ?`);
            $('#confirmModal').modal('show');
            $('#confirmBtn').on('click', function() {
                window.location.href = `eliminarSeccion/${id}`;
            });
        });
    </script>

@endsection
