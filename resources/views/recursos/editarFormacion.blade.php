@extends('layouts.master')
@section('title', 'Formación')
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
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Formación Docente
            </h1>
            <ol class="breadcrumb">
                <li><a href="principal"><i class="fa fa-dashboard"></i> Inicio</a></li>
                <li class="active">Formación Docente</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Editar publicación de formación docente</h3>
                        </div>
                        <div class="box-body">
                            <form action="{{ url('edisal/actualizarFormacion') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <input name="formacion_id" hidden="" value="{{ $formacion[0]->formacion_id }}">
                                <input name="nombre_anterior_txt" hidden="" value="{{ $formacion[0]->archivo_txt }}">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="rol">Categoria</label>
                                    </div>
                                    <div class="form-group mostrar">
                                    </div>
                                    <div class="form-group">
                                        <label for="titulo">Título</label>
                                        <input type="text" id="titulo" name="titulo" class="form-control"
                                            placeholder="Titulo de la clase" required="required"
                                            value="{{ $formacion[0]->titulo }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Descripción</label>
                                        <textarea name="descripcion" id="desc_id" class="form-control" rows="4" required="required" value=""
                                            placeholder="Digite una breve descripcion de la clase">{{ $formacion[0]->descripcion }}
                </textarea>
                                        <p id="caracteres"></p>
                                    </div>
                                    <div class="form-group">
                                        <img src="{{ URL::to('/') . '/public/formacion/' . $formacion[0]->formacion_id . '/archivos/' . '/imagen/' . $formacion[0]->imagen }}"
                                            width="200" height="200" class="img-responsive" alt="Image"><br><br><a
                                            class="btn btn-info" id="cambiar_imagen">Cambiar imagen</a>
                                    </div>
                                    <div class="form-group" id="mostrar_imagen" style="display: none;">
                                        <label>Imagen</label>
                                        <input type="file" class="form-control" accept="image/x-png, image/jpeg"
                                            name="imagen" placeholder="imagen">
                                    </div><br>
                                    <div class="form-group"> <label>Contenido</label>
                                        <?php
                                        $arc = fopen(public_path('formacion/') . $formacion[0]->formacion_id . '/contenidos/' . $formacion[0]->archivo_txt . '.txt', 'r');
                                        $texto = '';
                                        while (!feof($arc)) {
                                            $linea = trim(fgets($arc)); // Eliminar espacios en blanco al inicio y al final de la línea
                                            if (!empty($linea)) {
                                                // Agregar solo líneas no vacías
                                                $texto .= $linea . "\n"; // Agregar la línea al contenido con un salto de línea al final
                                            }
                                        }
                                        fclose($arc);
                                        ?>
                                        <textarea id="editor" class="tinymce-editor" name="txtEditor"><?= htmlspecialchars($texto) ?></textarea>
                                        <textarea id="txtEditorContent" name="txtEditorContent" hidden="" required="required"><?= htmlspecialchars($texto) ?></textarea>
                                    </div>
                                </div><br>
                                <button type="submit" class="btn btn-primary">Actualizar</button><br><br>
                            </form>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection
@section('script')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
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
            $("button:submit").click(function() {
                var tmp = $('#editor').val();
                var scsi = tmp.replace(/'/g, "&apos;");
                $('#txtEditorContent').val(scsi);
            });
        });
        $(document).on('click', '#cambiar_imagen', function(event) {
            $("#mostrar_imagen").show();
        });
    </script>
@endsection
