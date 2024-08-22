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
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h3 style="font-family: Franklin Gothic; text-align:center"> <i class="bx bx-book-content"></i>
                Planificaci&oacute;n</h3>
            <hr style="color: #54ac7c;  border-width: 4px;">
            <div class="col-sm-12 col-md-12 col-lg-12">
                &nbsp;&nbsp;<a class="btn btn-outline-success" href="{{ url('edisal/planificacion') }}">
                    <i class="ri-arrow-go-back-fill" aria-hidden="true"></i> Volver al listado
                </a>
            </div><br>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h4 class="box-title"><strong>Grado:</strong> {{ $recurso[0]->grado }}</h4>
                            <h4 class="box-title"><strong>Materia:</strong> {{ $recurso[0]->materia }}</h4> 
                            <h4 class="box-title"><strong>Unidad:</strong> {{ $recurso[0]->unidad }}</h4> 
                        </div>
                        <hr>
                        <div class="box-body no-padding">
                            <div class="box-footer">
                                <!--<h4><strong>Archivos:</strong></h4>-->
                                <ul class="mailbox-attachments">
                                    {{-- Llenar automaticamente los archivos --}}
                                    @foreach ($archivos as $archivo)
                                        <li>
                                            @if ($archivo->mime == 'application/pdf')
                                                <span class="mailbox-attachment-icon"><i class="bx bxs-file-pdf"></i></span>
                                                <div class="mailbox-attachment-info">
                                                    <a href="{{ URL::to('/') . '/public/planificacion/' . $archivo->recurso_id . '/' . $archivo->archivo }}"
                                                        class="mailbox-attachment-name iframe-popup"  style="color: #000;"> <i
                                                            class="bx bx-paperclip"></i>
                                                        {{ $archivo->nombre_archivo . ' (' . $archivo->extension . ')' }}</a>
                                                    <span class="mailbox-attachment-size">
                                                        {{ round($archivo->tam, 2) }} KB
                                                    </span>
                                                </div>
                                            @elseif($archivo->mime == 'image/png' || $archivo->mime == 'image/gif' || $archivo->mime == 'image/jpeg')
                                                <span class="mailbox-attachment-icon"><i class="ri-image-2-line"></i></span>
                                                <div class="mailbox-attachment-info">
                                                    <a href="{{ URL::to('/') . '/public/planificacion/' . $archivo->recurso_id . '/' . $archivo->archivo }}"
                                                        class="mailbox-attachment-name image-popup-vertical-fit"  style="color: #000;"> <i
                                                            class="bi paperclip"></i>
                                                        {{ $archivo->nombre_archivo . ' (' . $archivo->extension . ')' }}</a>
                                                    <span class="mailbox-attachment-size">
                                                        {{ round($archivo->tam, 2) }} KB
                                                    </span>
                                                </div>
                                            @elseif($archivo->mime == 'video/mp4' || $archivo->mime == 'audio/mpeg')
                                                <span class="mailbox-attachment-icon"><i class="bx bxl-youtube"></i></span>
                                                <div class="mailbox-attachment-info">
                                                    <a href="{{ URL::to('/') . '/public/planificacion/' . $archivo->recurso_id . '/' . $archivo->archivo }}"
                                                        class="mailbox-attachment-name popup-youtube"  style="color: #000;"> <i
                                                            class="bi paperclip"></i>
                                                        {{ $archivo->nombre_archivo . ' (' . $archivo->extension . ')' }}</a>
                                                    <span class="mailbox-attachment-size">
                                                        {{ round($archivo->tam, 2) }} KB
                                                    </span>
                                                </div>
                                            @elseif($archivo->mime == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
                                                <span class="mailbox-attachment-icon"><i class="bx bxs-file-doc"></i></span>
                                                <div class="mailbox-attachment-info">
                                                    <a href="{{ 'https://docs.google.com/viewer?url=' . URL::to('/public/planificacion/' . $archivo->recurso_id . '/' . $archivo->archivo) }}"
                                                        class="mailbox-attachment-name" target="_blank"  style="color: #000;">
                                                        <i class="bi paperclip"></i>
                                                        {{ $archivo->nombre_archivo . ' (' . $archivo->extension . ')' }}
                                                    </a>
                                                    <span class="mailbox-attachment-size">
                                                        {{ round($archivo->tam / 1024, 2) }} KB
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
