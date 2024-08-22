@extends('layouts.master')
@section('title', 'Timonel')

@section('style')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/css/bootstrap-dialog.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/js/bootstrap-dialog.min.js"></script>

@endsection

@section('content')
    <h3 style="font-family: Franklin Gothic; text-align: center;"> <i class="bx bxs-school"></i> Formaci&aacute;n Docente</h3>
    <hr style="color: #54ac7c;  border-width: 4px;">
    <section class="content">
        <div class="row">

            <div class="pull-left box-tools">
                <a href="{{ url('edisal/nuevaFor') }}">
                    <button type="button" class="btn btn-outline-success"><i class="bx bxs-school"></i>
                        Nueva Publicaci&oacute;n
                    </button>
                </a>
            </div>
            <br>
            <br>
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">LISTADO DE PUBLICACIONES</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body pad">
                        <table id="tformacion" class="table table-striped datatable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Título</th>
                                    <th>Descripción</th>

                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $c = 1; ?>
                                @foreach ($publicaciones as $key)
                                    <tr>
                                        <td>{{ $c++ }}</td>
                                        <td>{{ $key->titulo }}</td>
                                        <td>{{ $key->descripcion }}</td>

                                        <td align="">
                                            <a class="mostrar white-popup" id="ver"
                                                href="verFormacion/{{ $key->id }}"><i class="ri-eye-line"></i></a>
                                            <a href="editarFormacion/{{ $key->id }}"> <i
                                                    class="bx bxs-pencil"></i></a>
                                            <a data-toggle="tooltip" title="Eliminar publicación" id="{{ $key->id }}"
                                                class="eliminar" name="{{ $key->titulo }}" href="#"><i
                                                    class="bx bxs-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/js/bootstrap-dialog.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.eliminar').on('click', function() {
                var aqui = $(this);
                var id = aqui.attr('id');
                var name = aqui.attr('name');

                // Crear el modal
                var modal =
                    '<div class="modal fade" id="eliminarModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">';
                modal += '<div class="modal-dialog">';
                modal += '<div class="modal-content">';
                modal += '<div class="modal-header">';
                modal += '<h5 class="modal-title" id="eliminarModalLabel">Eliminar Publicación</h5>';
                modal += '</button>';
                modal += '</div>';
                modal += '<div class="modal-body">';
                modal += '<p>¿Está seguro que quiere eliminar la publicación: <strong>' + name +
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
                    window.location.href = 'eliminarFormacion/' + id;
                });
                $('#eliminarModal').on('hidden.bs.modal', function() {
                    $(this).remove();
                });
            });
        });
    </script>
@endsection
