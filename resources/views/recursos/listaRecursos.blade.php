@extends('layouts.master')
@section('title', 'Intituciones')
@section('content')
    <h3 style="font-family: Franklin Gothic;"> <i class="ri-admin-fill"></i> Administrar Recursos</h3>
    <hr style="color: #54ac7c;  border-width: 4px;">
    <a href="{{ url('edisal/nuevoRecurso') }}">
        <button type="button" class="btn btn-outline-success"><i class="bi bi-book"></i>
            Nuevo recurso
        </button>
    </a>
    <div class="box-body pad">
        <table id="trecursos" class="table table-bordered table-striped datatable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nombre</th>
                    <th>Grado</th>
                    <th>Materia</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $c = 1; ?>
                @foreach ($recursos as $key)
                    <tr class="text-left">
                        <td>{{ $c++ }}</td>
                        <td>{{ $key->nombre }}</td>
                        <td>{{ $key->grado }}</td>
                        <td>{{ $key->materia }}</td>
                        <td>
                            @if ($key->flag_imagen == 1)
                                <small class="badge bg-success">Con Imagen</small>
                            @else
                                <small class="badge bg-secondary">Sin Imagen</small>
                            @endif
                        </td>
                        <td align="center">
                            <a class="mostrar white-popup" id="ver" id_recurso="{{ $key->id }}"
                                grado_id ="{{ $key->grado_id }}" materia_id="{{ $key->materia_id }}"
                                tipo="{{ $key->tipo }}" archivo="{{ $key->archivo }}" data-toggle="tooltip"
                                title="Visualizar"><i class="ri-eye-line"></i></a>
                            @if ($key->tipo == 'Web')
                            @else
                                <a href="{{ url('edisal/descargar_archivo_recurso/' . $key->id . '/' . $key->grado_id . '/' . $key->materia_id . '/' . $key->archivo) }}"
                                    class="white-popup" data-toggle="tooltip" title="Descargar"><i
                                        class="fa fa-arrow-down"></i></a>
                            @endif

                            <a data-toggle="tooltip" title="Eliminar Recurso" id="{{ $key->id }}" class="eliminar"
                                name="{{ $key->nombre }}" href="#"><i class="bx bxs-trash "></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Delegación de eventos para elementos .eliminar
            $(document).on('click', '.eliminar', function() {
                var aqui = $(this);
                var id = aqui.attr('id');
                var name = aqui.attr('name');

                // Crear el modal
                var modal =
                    '<div class="modal fade" id="eliminarModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">';
                modal += '<div class="modal-dialog">';
                modal += '<div class="modal-content">';
                modal += '<div class="modal-header">';
                modal += '<h5 class="modal-title" id="eliminarModalLabel">Eliminar Recurso</h5>';
                modal += '</button>';
                modal += '</div>';
                modal += '<div class="modal-body">';
                modal += '<p>¿Está seguro que quiere eliminar el recurso: <strong>' + name +
                    '</strong>?</p>';
                modal += '</div>';
                modal += '<div class="modal-footer">';
                modal += '<button type="button" class="btn btn-danger" id="eliminarBtn">Eliminar</button>';
                modal += '</div>';
                modal += '</div>';
                modal += '</div>';
                modal += '</div>';
                $('body').append(modal);
                $('#eliminarModal').modal('show');
                $('#eliminarBtn').on('click', function() {
                    window.location.href = 'eliminarResurso/' + id;
                });
                $('#eliminarModal').on('hidden.bs.modal', function() {
                    $(this).remove();
                });
            });
            $('.mostrar').on('click', function() {
                var id = $(this).attr('id_recurso');
                var tipo = $(this).attr('tipo');
                var grado = $(this).attr('grado_id');
                var materia = $(this).attr('materia_id');
                var archivo = $(this).attr('archivo');
                var office = '{{ URL::to('/') }}/recursos/' + id + "/" + grado + "/" + materia + "/" +
                    archivo;
                console.log(office);

                if (tipo === 'Web') {
                    var src = '/recursos/' + id + "/" + grado + "/" + materia + "/" + archivo;
                    window.location.href = '/edisal/recursos/web/' + id + '/' + grado + '/' + materia +
                        '/' + archivo;
                } else {
                    console.error('Tipo de recurso desconocido');
                }
            });
        });
    </script>
@endsection
