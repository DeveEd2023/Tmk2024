@extends('layouts.master')
@section('title', 'Intituciones')

@section('content')
    <h3 style="font-family: Franklin Gothic; text-align: center;"> <i class="ri-user-star-line"></i> Alumnos</h3>
    <hr style="color: #54ac7c;  border-width: 4px;">

    <div class="box-body pad">

        <div class="pull-left box-tools">
            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalCrear"><i
                    class="ri-user-star-line"></i>
                Nuevo Alumno
            </button>

        </div>
        <br>
        <table id="ttareas" class="table table-bordered table-striped datatable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Alumno</th>
                    <th>Institución</th>
                    <th>Grado</th>
                    <th>Sección</th>
                    <th>Turno</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $cont = 1; ?>
                @foreach ($alumnos as $alumno)
                    <tr align="left">
                        <td>{{ $cont }}</td>
                        <td>{{ $alumno->nombres . ' ' . $alumno->apellidos }}</td>
                        <td>{{ $alumno->institucion }}</td>
                        <td>{{ $alumno->grado }}</td>
                        <td>{{ $alumno->seccion }}</td>
                        <td>{{ $alumno->turno }}</td>
                        @if ($alumno->estado == 1)
                            <td>Activo</td>
                        @else
                            <td>Inactiva</td>
                        @endif
                        <td align="center">
                            <a data-toggle="tooltip" title="Eliminar alumno" id="{{ $alumno->alumno_id }}"
                                class="eliminarAlumno" name="{{ '<br>' . $alumno->nombres . ' ' . $alumno->apellidos }}"
                                href="#"><i class="bx bxs-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php $cont++; ?>
                @endforeach

            </tbody>
        </table>
    </div>


    <!------------------------------------------------ modal eliminar --------------------------------------------------------------------->

    <div class="modal fade" id="modalEliminarAlumno" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
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



    <!------------------------------------------------ modal crear --------------------------------------------------------------------->
    <div class="modal fade" id="modalCrear" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #57ad7a ">
                    <h5 class="modal-title" style="color: #fff; text-align: center;">
                        <i class="ri-user-star-line"></i> Nuevo alumno
                    </h5>
                </div>
                <form id="alumnoform" action="{{ url('admin/nuevoAlumno') }}" method="POST">
                    @csrf
                    <div class="modal-body row" id="create_modal">
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
                                </select>
                            </div><br>

                            <div class="form-group">
                                <label for="alumno">
                                    <i class="ri-shield-user-line"></i> Alumno
                                </label><br>
                                <select name="alumno" class="form-select mt-2" id="alumno" required>
                                    <option selected disabled> Seleccione un alumno </option>
                                </select>
                            </div>
                            <br>

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






@endsection
@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const institucionSelect = document.getElementById('institucion');
            const gradoSelect = document.getElementById('grado');
            const seccionSelect = document.getElementById('seccion');
            const alumnoSelect = document.getElementById('alumno');

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

                fetch(`/admin/obtenerAlumno/${institucionId}`)
                    .then(response => response.json())
                    .then(data => {
                        alumnoSelect.innerHTML =
                            '<option selected disabled>Seleccion un alumno</option>';
                        data.forEach(alumno => {
                            const option = document.createElement('option');
                            option.value = alumno.alumno_id;
                            option.textContent = alumno.nombres + ' ' + alumno.apellidos;
                            alumnoSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error al obtener el alumno:', error));
            });

            gradoSelect.addEventListener('change', function() {
                const gradoId = this.value;

                fetch(`/admin/obtenerSeccion/${gradoId}`)
                    .then(response => response.json())
                    .then(data => {
                        seccionSelect.innerHTML =
                            '<option selected disabled>Selecciona una sección</option>';
                        data.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.seccion_id;
                            option.textContent = `${item.seccion} - ${item.turno}`;
                            seccionSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error al obtener las secciones:', error));
            });
        });


        $('body').on('click', '.eliminarAlumno', function() {
            const id = $(this).attr('id');
            const name = $(this).attr('name');
            console.log('Institucion: ' + name);
            $('#confirmMessage').html(`¿Está seguro que quiere eliminar el usuario: <strong>${name}</strong>?`);
            $('#modalEliminarAlumno').modal('show');


            $('#confirmBtn').off('click').on('click', function() {
                window.location.href = `eliminarAlumno/${id}`;
            });
        });
    </script>

@endsection
