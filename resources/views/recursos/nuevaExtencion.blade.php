@extends('layouts.master')
@section('title', 'Intituciones')
@section('style')

    <style>
        .tox-promotion {
            display: none;
        }

        span.tox-statusbar__branding {
            display: none;
        }

        .tox-statusbar__help-text {
            visibility: hidden;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">


@endsection
@section('content')
    <h3 style="font-family: Franklin Gothic; text-align:center"> <i class="bx bx-book-content"></i> Nueva Extension de
        Libreta</h3>
    <hr style="color: #54ac7c;  border-width: 4px;">
    <br>
    <form action="{{ url('edisal/guardarExtencion') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="grado">
                            <i class="bx bxs-chevrons-up"></i> Grado
                        </label><br>
                        <select name="grado" class="form-select mt-2" id="grado" required>
                            <option selected disabled>Selecciona un grado</option>
                            @foreach ($grado as $id => $grado)
                                <option value="{{ $id }}">{{ $grado }}</option>
                            @endforeach
                        </select>
                    </div><br>
                    <div class="form-group">
                        <label for="institucio">
                            <i class="ri-file-edit-line"></i> Materia
                        </label><br>
                        <select name="materia" class="form-select mt-2" id="materia" required>
                            <option selected disabled>Selecciona materia</option>
                            @foreach ($materia as $id => $m)
                                <option value="{{ $id }}">{{ $m }}</option>
                            @endforeach
                        </select>
                    </div><br>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="seccion">
                            <i class="ri-bookmark-fill"></i> Unidad
                        </label><br>
                        <select name="unidad" class="form-select mt-2" id="unidad" required>
                            <option selected disabled>Selecciona una unidad</option>
                            @foreach ($unidad as $id => $u)
                                <option value="{{ $id }}">{{ $u }}</option>
                            @endforeach
                        </select>
                    </div><br>
                    <div class="form-group">
                        <label for="materia">
                            <i class="ri-edit-box-line"></i> Tema
                        </label><br>
                        <input type="text" name="tema" id="" class="form-control mt-2"
                            placeholder="Digite un tema">
                    </div><br>
                </div>
            </div>
            <h5 class="card-title">Desarrollo</h5>
            <textarea class="tinymce-editor" name="datos" id="tinymce-editor"></textarea>
            <br>
            <div class="form-group archivos">
                <label>Compartir Archivo</label>
                <a id="arcmas" class="mas"><i class="ri-add-circle-line ri-xl"></i></a>
                <a id="arcmenos"><i class="ri-delete-back-2-line ri-xl" style="color: red"></i></a>
                </label>
                <hr />
                <input type="text" name="nombrefile[0]" value="Nombre del archivo" class="form-control arc_0" />
                <input type="file" name="file[0]" class="form-control arc_0"
                    accept="image/x-png,image/gif,image/jpeg,video/mp4,application/pdf" />
                <br class="arc_0" />
            </div>
            <button type="submit" class="btn btn-outline-success">Registrar</button>
        </div>
    </form>
    <br><br>
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#inicio, #agenda, #tareas, #clase, #recursos, #notas, #formacion, #admin, #instituciones, #usuarios, #grados, #secciones, #materias, #extension')
                .removeClass('active');
            $('#admin, #extension').addClass('active');

            var countarc = 0;
            var countarcm = 1;

            $('#arcmas').on('click', function() {
                countarc++;
                countarcm++;

                var newFileGroup = $('<div class="form-group-cpy">');



                newFileGroup.append('<input type="text" name="nombrefile[' + countarc +
                    ']" value="Nombre Archivo ' + countarcm + '" class="form-control arc_' + countarc +
                    '" />');
                newFileGroup.append('<input type="file" name="file[' + countarc +
                    ']" class="form-control arc_' + countarc +
                    '" accept="image/x-png,image/gif,image/jpeg,video/mp4,application/pdf" />');
                newFileGroup.append('<br class="arc_' + countarc + '" />');

                $('.archivos').append(newFileGroup);
            });
            $(document).on('click', '#arcmenos', function() {
                var group = $(this).closest('.form-group-cpy');
                if (countarc > 0) {
                    $('.arc_' + countarc).remove();

                    countarc--;
                    countarcm--;
                } else {
                    alert('No es permitido eliminar.');
                }
            });
        });
    </script>
@endsection
