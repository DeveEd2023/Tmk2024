@extends('layouts.master')
@section('title', 'Intituciones')
@section('style')
<style>
    .mailbox-attachment-icon,
    .mailbox-attachment-info,
    .mailbox-attachment-size {
        display: block;
    }
    .mailbox-attachment-info {
        padding: 10px;
        background: #f4f4f4;
    }
    .mailbox-attachment-size {
        color: #999;
        font-size: 12px;
    }
    .mailbox-attachment-icon {
        text-align: center;
        font-size: 65px;
        color: #666;
        padding: 20px 10px;

        &.has-img {
            padding: 0;

            >img {
                max-width: 100%;
                height: auto;
            }
        }
    }
    .mailbox-attachments {
        &:extend(.list-unstyled);

        li {
            float: left;
            width: 200px;
            border: 1px solid #eee;
            margin-bottom: 10px;
            margin-right: 10px;
        }
    }
    .mailbox-attachment-icon,
    .mailbox-attachment-info,
    .mailbox-attachment-size {
        display: block;
    }
    .mailbox-attachment-info {
        padding: 10px;
        background: #f4f4f4;
    }
    .mailbox-attachment-size {
        color: #999;
        font-size: 12px;
    }
       ul {
        list-style: none;
    }
</style>
    <link rel="stylesheet" href="{{ asset('assets/magnific/dist/magnific-popup.css') }}">
@endsection
@section('content')
    <section class="content-header">
        <h3 style="font-family: Franklin Gothic; text-align:center"> <i class="bx bx-book-content"></i> Recursos Extension de
            Libreta</h3>
        <hr style="color: #54ac7c;  border-width: 4px;">
        <div class="col-sm-12 col-md-12 col-lg-12">
            &nbsp;&nbsp;<a class="btn btn-outline-success" href="{{ url('edisal/extencion') }}">
                <i class="ri-arrow-go-back-fill" aria-hidden="true"></i> Volver al listado
            </a>
        </div><br>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><strong>Grado:</strong> {{ $recurso[0]->grado }}</h3> <br>
                        <h3 class="box-title"><strong>Materia:</strong> {{ $recurso[0]->materia }}</h3> <br>
                        <h3 class="box-title"><strong>Unidad:</strong> {{ $recurso[0]->unidad }}</h3> <br>
                    </div>
                    <div class="box-body no-padding">
                        <div class="mailbox-read-info">
                            <h3><strong>Tema:</strong> {{ $recurso[0]->tema }}</h3>
                            <h5>
                                <span class="mailbox-read-time pull-right">Fecha Creación: {{ $recurso[0]->fecha }}</span>
                            </h5>
                        </div>
                        <div class="mailbox-read-message">
                            <div class="row">
                                <div class="col-12 col-md-8">
                                    <h4><strong>Desarrollo :</strong></h4>
                                    <span class="contenido">{!! $recurso[0]->contenido !!}</span>
                                </div>
                            </div>
                        </div>
                        <br /> <br /> <br /> <br />
                        <div class="box-footer">
                            <h4><strong>Archivos:</strong></h4>
                            <ul class="mailbox-attachments">
                                {{-- Llenar automaticamente los archivos --}}
                                @foreach ($archivos as $archivo)
                                    <li>
                                        @if ($archivo->mime == 'application/pdf')
                                            <span class="mailbox-attachment-icon"><i class="bx bxs-file-pdf"></i></span>
                                            <div class="mailbox-attachment-info">
                                                <a href="{{ URL::to('/') . '/extensiones/' . $archivo->recurso_id . '/' . $archivo->archivo }}"
                                                    class="mailbox-attachment-name iframe-popup"> <i
                                                        class="bi bi-paperclip"></i>
                                                    {{ $archivo->nombre_archivo . ' (' . $archivo->extension . ')' }}</a>
                                                <span class="mailbox-attachment-size">
                                                    {{ round($archivo->tam, 2) }} KB
                                                </span>
                                            </div>
                                        @elseif($archivo->mime == 'image/png' || $archivo->mime == 'image/gif' || $archivo->mime == 'image/jpeg')
                                            <span class="mailbox-attachment-icon"><i class="ri-image-2-line"></i></span>
                                            <div class="mailbox-attachment-info">
                                                <a href="{{ URL::to('/') . '/extensiones/' . $archivo->recurso_id . '/' . $archivo->archivo }}"
                                                    class="mailbox-attachment-name image-popup-vertical-fit"> <i
                                                        class="bi bi-paperclip"></i>
                                                    {{ $archivo->nombre_archivo . ' (' . $archivo->extension . ')' }}</a>
                                                <span class="mailbox-attachment-size">
                                                    {{ round($archivo->tam, 2) }} KB
                                                </span>
                                            </div>
                                        @elseif($archivo->mime == 'video/mp4')
                                            <span class="mailbox-attachment-icon"><i class="bx bxl-youtube"></i></span>
                                            <div class="mailbox-attachment-info">
                                                <a href="{{ URL::to('/') . '/extensiones/' . $archivo->recurso_id . '/' . $archivo->archivo }}"
                                                    class="mailbox-attachment-name popup-youtube"> <i
                                                        class="bi bi-paperclip"></i>
                                                    {{ $archivo->nombre_archivo . ' (' . $archivo->extension . ')' }}</a>
                                                <span class="mailbox-attachment-size">
                                                    {{ round($archivo->tam, 2) }} KB
                                                </span>
                                            </div>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>

@endsection
@section('script')

    <script src="{{ asset('/assets/magnific/dist/jquery.magnific-popup.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('img').addClass('img-responsive');
            $('img').addClass('center-block');

            $('.popup-youtube').magnificPopup({
                disableOn: 700,
                type: 'iframe',
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: false,

                fixedContentPos: false
            });
            $('.image-popup-vertical-fit').magnificPopup({
                type: 'image',
                closeOnContentClick: true,
                mainClass: 'mfp-img-mobile',
                image: {
                    verticalFit: true
                }

            });

            $('.iframe-popup').magnificPopup({
                type: 'iframe'

            });
        });
    </script>
@endsection
