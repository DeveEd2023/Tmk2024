@extends('layouts.master')
@section('title', 'Intituciones')
@section('content')

    <h3 style="font-family: Franklin Gothic; text-align: center"> <i class="bx bxs-user-plus"></i> Nuevo profesor encargado
    </h3>
    <hr style="color: #54ac7c;  border-width: 4px;">



    <div class="container">

        <form id="userForm" action="{{ url('admin/crearEncargado') }}" method="POST">
            @csrf

            <div class="col-md-12">
                <div class="form-group">
                    <label for="institucio">
                        <i class="bx bxs-bank"></i> Institución
                    </label><br>
                    <select name="institucion" class="form-select mt-2" id="institucion" required>
                        <option selected disabled> Selecciona una institución</option>
                        @foreach ($institucion as $i)
                            <option value="{{ $i->id }}">{{ $i->institucion }}</option>
                        @endforeach
                    </select>
                </div><br>
                <div class="form-group">
                    <label for="grado">
                        <i class="bx bxs-chevrons-up"></i> Grado
                    </label><br>
                    <select name="grado" class="form-select mt-2" id="grado" required>
                        <option selected disabled> Selecciona un grado</option>
                    </select>
                </div><br>

                <div class="form-group">
                    <label for="seccion">
                        <i class="ri-bookmark-fill"></i> Secci&oacute; y Turno
                    </label><br>
                    <select name="seccion" class="form-select mt-2" id="seccion" required>
                        <option selected disabled> Selecciona una secci&oacute;n</option>

                    </select>
                </div><br>

                <div class="form-group">
                    <label for="profesor">
                        <i class="ri-shield-user-line"></i> Profesor
                    </label><br>
                    <select name="profesor" class="form-select mt-2" id="profesor" required>
                        <option selected disabled> Seleccion un profesor </option>

                    </select>
                </div><br>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>

@endsection
@section('script')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const institucionSelect = document.getElementById('institucion');
            const gradoSelect = document.getElementById('grado');
            const seccionSelect = document.getElementById('seccion');
            const profesorSelect = document.getElementById('profesor');

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

                fetch(`/admin/obtenerProfesor/${institucionId}`)
                    .then(response => response.json())
                    .then(data => {
                        profesorSelect.innerHTML =
                            '<option selected disabled>Seleccion un profesor</option>';
                        data.forEach(profesor => {
                            const option = document.createElement('option');
                            option.value = profesor.profesor_id;
                            option.textContent = profesor.nombres + ' ' + profesor.apellidos;
                            profesorSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error al obtener el profesor:', error));
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
    </script>
@endsection
