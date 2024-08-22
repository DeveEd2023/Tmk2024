@extends('layouts.profesor')
@section('title', 'Formación')
@section('content')
    
        <section class="content-header">
            <h3 style="font-family: Franklin Gothic; text-align: center;"> <i class="bx bxs-school"></i> Formaci&aacute;n
                Docente
            </h3>
            <hr style="color: #54ac7c;  border-width: 4px;">
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="">
                        <div class="box-body">
                            <h3>Titulo: {{ $formacion[0]->titulo }}</h3>
                            <div class="post">
                                <div class="form-group">
                                    <h5> Descripci&oacute;n: {{ $formacion[0]->descripcion }} </h5>
                                </div>
                                <br>
                                <br>
                                <div class="form-group">
                                    <img src="{{ URL::to('/') . '/public/formacion/' . $formacion[0]->formacion_id . '/archivos/' . '/imagen/' . $formacion[0]->imagen }}"
                                        class="img-responsive" alt="Image" width="200" height="200">
                                </div>
                                <div class="form-group">
                                    <p>
                                        <?php $arc = fopen(public_path('formacion/') . $formacion[0]->formacion_id . '/contenidos/' . $formacion[0]->archivo_txt . '.txt', 'r');
                                        while (!feof($arc)) {
                                            $linea = trim(fgets($arc)); // Eliminar espacios en blanco al inicio y al final de la línea
                                            echo nl2br($linea);
                                        } ?>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <hr>
                                    @if (!empty($formacion[0]->archivo) && !empty($formacion[0]->nombre_archivo))
                                        <p><i class="bx bxs-archive-in">Archivo: </i> <b>{{ $formacion[0]->nombre_archivo }}
                                            </b> <a
                                                href="{{ url('edisal/descargaArchivoFormacion/' . $formacion[0]->formacion_id . '/' . $formacion[0]->archivo) }}">Descargar</a>
                                        </p>
                                    @else
                                        <b>No hay archivos adjuntos!!</b>
                                    @endif
                                    <hr>
                                    <br>
                                </div>
                                <div class="form-group">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>

@endsection
@section('script')
