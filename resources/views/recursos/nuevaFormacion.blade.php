@extends('layouts.master')
@section('title', 'Timonel')
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

        label {
            font-weight: bold;

        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">


@endsection
@section('content')

    <div class="content-wrapper">

        <h3 style="font-family: Franklin Gothic; text-align: center;"> <i class="bx bxs-school"></i> Formaci&aacute;n Docente
        </h3>
        <hr style="color: #54ac7c;  border-width: 4px;">

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h4 class="box-title">Nueva publicación de formación docente</h4>
                            <hr style="color: rgb(172, 172, 172)">
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form action="{{ url('edisal/crearFormacion') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="titulo">Título</label>
                                            <input type="text" id="titulo" name="titulo" class="form-control"
                                                placeholder="Titulo de la clase" required="required">
                                        </div><br>
                                        <div class="form-group">
                                            <label>Descripción</label>
                                            <textarea name="descripcion" id="desc_id" class="form-control" rows="4" required="required"
                                                placeholder="Digite una breve descripcion de la clase"></textarea>
                                            <p id="caracteres"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Imagen</label>
                                            <input type="file" class="form-control" accept="image/x-png, image/jpeg"
                                                name="imagen" placeholder="imagen" required="required">
                                        </div>
                                        <div class="form-group"><br>
                                            <label>Contenido</label>
                                            <textarea id="txtEditor" class="tinymce-editor" name="txtEditor"></textarea>
                                        </div>
                                        <br><br><br>
                                    </div>
                                    <div class="col-md-4">
                                        <hr style="color: #54ac7c;  border-width: 4px;">
                                        <div class="box box-primary">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Adjuntar Material</h3>
                                            </div>
                                            <div class="box-body">
                                                <div class="form-group">
                                                    <label for="nombrefile">Archivo</label>
                                                    <input type="text" name="nombrefile" placeholder="Nombre del archivo"
                                                        class="form-control"><br>
                                                    <input type="file" id="file" name="file">
                                                    <p class="help-block">Adjuntar archivo para compartir.</p>
                                                </div>
                                            </div>
                                            <div class="box-footer">
                                                <button type="submit" class="btn btn-primary">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var caracteres = 500;
            $("#caracteres").html("*Quedan <strong>" + caracteres + "</strong> caracteres.");
            $("#desc_id").keyup(function() {
                if ($(this).val().length > caracteres) {
                    $(this).val($(this).val().substr(0, caracteres));
                }
                var quedan = caracteres - $(this).val().length;
                $("#caracteres").html("*Quedan <strong>" + quedan + "</strong> caracteres.");
                if (quedan <= 10) {
                    $("#caracteres").css("color", "red");
                } else {
                    $("#caracteres").css("color", "black");
                }
            });
            $("#txtEditor").Editor();
            $("button:submit").click(function() {
                var tmp = $('#editor').val();
                var scsi = tmp.replace(/'/g, "&apos;");
                $('#txtEditorContent').val(scsi);
            });
            $('#inicio').removeClass('active');
            $('#agenda').removeClass('active');
            $('#tareas').removeClass('active');
            $('#clase').removeClass('active');
            $('#recursos').removeClass('active');
            $('#notas').removeClass('active');
            $('#formacion').removeClass('active');
            $('#admin').removeClass('active');
            $('#instituciones').removeClass('active');
            $('#usuarios').removeClass('active');
            $('#grados').removeClass('active');
            $('#secciones').removeClass('active');
            $('#materias').removeClass('active');
            $('#formacion').addClass('active');
        });
    </script>
@endsection
