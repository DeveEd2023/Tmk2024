@extends('layouts.profesor')
@section('title', 'Timonel')
@section('style')
    <style>
        .separador {
            color: #54ac7c;
            border-width: 10px;
        }

        .separador:not([size]) {
            height: 5px;
        }
    </style>
@endsection
@section('content')

    <section class="content">
        <div class="row">


            <h3 style="font-family: Franklin Gothic; text-align:center"> <i class="bx bx-book-content"></i> Recursos de
                {{ $materia }}</h3>
            <hr class="separador">
            <div class="col-md-12">
                <div class="">
                    <div class="box-header with-border">
                        <input type="hidden" id="grado_id" value="{{ $grado_id }}">
                        <input type="hidden" id="materia_id" value="{{ $materia_id }}">
                    </div>
                    <div class="box-body no-padding">
                        <div class="mailbox-read-info">
                            <div class="row">
                                <div class="col-md-2">
                                    <h4><strong>Eje Globalizador:</strong></h4>
                                </div>
                                <div class="col-md-3">
                                    <select name="unidad" id="unidad" class="form-control unidad">
                                        <option value="">Seleccionar Eje</option>
                                        @foreach ($temas as $tema)
                                            <option value="{{ $tema->unidad_id }}">{{ $tema->unidad_id }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <h4><strong>Tema globalizador:</strong></h4>
                                </div>
                                <div class="col-md-3" id="contenedor_tema">
                                    <select name="tema" id="tema" class="form-control tema" disabled>
                                        <option value="">Seleccionar Situación</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-success" id="consultar">Mostrar</button>
                                </div>
                            </div>

                        </div>
                        <div class="mailbox-read-message">
                            <h4><strong>Desarrollo :</strong></h4>
                            <div class="contenido">

                            </div>
                        </div>
                        <hr style="color: #c4c4c4">
                        <div class="">
                            <h4><strong>Archivos:</strong></h4>
                            <ul class="mailbox-attachments list-inline" id="archivos">
                            </ul>
                        </div>
                        <hr style="color: #c4c4c4">
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->

                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>


@endsection
@section('script')
    <link rel="stylesheet" href="{{ asset('/assets/magnific/dist/magnific-popup.css') }}">
    <script src="{{ asset('/assets/magnific/dist/jquery.magnific-popup.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var BASE = "{{ url('/') }}";
            var grado_id = $("#grado_id").val();
            var materia_id = $("#materia_id").val();

            $('#unidad').on('change', function() {
                var unidad_id = $(this).val();
                if (unidad_id !== '') {
                    $('#contenedor_tema').html('');
                    $('#contenedor_tema').append(
                        '<select name="tema" id="tema" class="form-control"></select>');
                    $('#tema').append('<option value="">Seleccionar Tema</option>');
                    $.post(BASE + '/profesor/extension/temas', {
                        unidad_id: unidad_id,
                        materia_id: materia_id,
                        grado_id: grado_id
                    }, function(temas) {
                        $.each(temas, function(i, j) {
                            $('#tema').append('<option value="' + j.id_recurso + '">' + j
                                .tema + '</option>');
                        });
                    }).fail(function(xhr, status, error) {
                        console.error(xhr.responseText);
                        swal("Error al cargar los temas. Por favor, inténtelo de nuevo más tarde.");
                    });
                } else {
                    swal("¡Debe seleccionar una unidad!");
                    $('#contenedor_tema').html('');
                    $('#contenedor_tema').append(
                        '<select name="tema" id="tema" class="form-control"></select>');
                    $('#tema').append('<option value="">Seleccionar Tema</option>');
                }
            });

            $('#consultar').on('click', function() {

                var tema_id = $("#tema").val();
                if (tema_id !== '') {

                    $.getJSON(BASE + '/profesor/extension/mostrarTema', {
                        tema_id: tema_id
                    }, function(tema) {


                        $(".contenido").html('');
                        $(".contenido").append('<p>' + tema['contenido'] + '</p>');
                        $('img').addClass('img-responsive');
                        $('img').addClass('center-block');
                    }).fail(function(jqxhr, textStatus, error) {
                        var err = textStatus + ", " + error;
                        console.log("Solicitud fallida: " + err);
                    });

                    $.getJSON(BASE + '/profesor/extension/archivos', {
                        tema_id: tema_id
                    }, function(archivos) {

                        $("#archivos").html('');
                        $.each(archivos, function(i, j) {
                            var archivo = "{{ URL::to('/') . '/extensiones/' }}" + j[
                                'recurso_id'] + "/" + j['archivo'];
                            var icono;
                            if (j['mime'] == 'application/pdf') {
                                icono = '<i class="bi bxs-file-pdf"></i>';
                            } else if (j['mime'] == 'image/png' || j['mime'] ==
                                'image/gif' || j['mime'] == 'image/jpeg') {
                                icono = '<i class="fa fa-image"></i>';
                            } else if (j['mime'] == 'video/mp4') {
                                icono = '<i class="bx bxl-youtube"></i>';
                            }
                            var boton =
                                '<button title="Doble click para ver archivo" class="mailbox-attachment-name iframe-popup" archivo="' +
                                archivo + '"> <i class="bx bxs-file-doc"></i> ' + j[
                                    'nombre_archivo'] + '</button>';
                            var tamano = '<span class="mailbox-attachment-size">' + j[
                                'tam'] + ' KB</span>';
                            var listItem = '<li> <span class="mailbox-attachment-icon">' +
                                icono + '</span><div class="mailbox-attachment-info">' +
                                boton + tamano + '</div></li>';
                            $("#archivos").append(listItem);
                        });
                    }).fail(function(jqxhr, textStatus, error) {
                        var err = textStatus + ", " + error;
                        console.log("Solicitud fallida: " + err);
                    });
                } else {
                    swal("¡Debe seleccionar un tema!");
                }
            });
        });






        $('body').on('click', '.popup-youtube', function() {
            var archivo = $(this).attr('archivo');
            $(this).magnificPopup({
                items: {
                    src: archivo,
                    disableOn: 700,
                    type: 'iframe',
                    mainClass: 'mfp-fade',
                    removalDelay: 160,
                    preloader: false,

                    fixedContentPos: false
                }
            });
        });


        $('body').on('click', '.image-popup-vertical-fit', function() {
            var archivo = $(this).attr('archivo');
            $(this).magnificPopup({
                items: {
                    src: archivo,
                    type: 'image',
                    closeOnContentClick: true,
                    mainClass: 'mfp-img-mobile',
                    image: {
                        verticalFit: true
                    }
                }
            });
        });

        $('.image-popup-vertical-fit').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            mainClass: 'mfp-img-mobile',
            image: {
                verticalFit: true
            }

        });

        $('body').on('click', '.iframe-popup', function() {
            var archivo = $(this).attr('archivo');
            $(this).magnificPopup({
                items: {
                    src: archivo,
                    type: 'iframe'
                }
            });
        });
    </script>
@endsection
