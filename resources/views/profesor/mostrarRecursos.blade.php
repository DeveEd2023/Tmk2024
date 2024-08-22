@extends('layouts.profesor')
@section('title', 'Recursos')
@section('style')
    <style type="text/css">
        <style>.mailbox-attachment-icon,
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

        .mailbox-attachment-info a {
            color: #000;
            text-decoration: none;
        }

        .mailbox-attachment-info li {
            list-style-type: none;
            margin-bottom: 10px;
        }

        ul {
            list-style: none;
        }

        hr {
            color: #54ac7c;
            border-width: 10px;
        }

        hr:not([size]) {
            height: 5px;
        }
    </style>
@endsection
@section('content')

    <section class="content">

        <h3 style="font-family: Franklin Gothic; text-align: center"> <i class="ri-book-read-line"></i> Libreta
            digital</h3>
        <hr>
        <div class="row">
            <div class="col-md-12">

                <div class="">

                    <div class="">
                        @if (empty($archivos))
                            <h4>No se ha compartido recursos para su grado, sección o materia!!</h4>
                        @else
                            <div class="row">
                                @php $contador = 1 @endphp
                                @foreach ($archivos as $archivo)
                                    @if ($archivo->tipo == 'Web')
                                        <div class="col-md-2">
                                            <li style="list-style: none;">
                                                <?php $extension = 'Web'; ?>
                                                <span class="mailbox-attachment-icon"
                                                    style="border-style: solid; border-radius: 30px 0 30px 0; border-color: #08c4ec">


                                                    @if ($archivo->flag_imagen != 0)
                                                        @if ($archivo->imagen != '---')
                                                            <img class="img-responsive"
                                                                style="max-width: 275px; max-height: 325px; width: 100%; height: 100%; "
                                                                src="{{ $archivo->imagen }}">
                                                        @else
                                                            <img src="{{ asset('public/img/sin_imagen.png') }}"
                                                                style="max-width: 200px; max-height: 3200px; width: 100%; height: 100%;"
                                                                class="img-responsive">
                                                        @endif
                                                    @endif
                                                </span>
                                                <div class="mailbox-attachment-info"
                                                    style="border-radius: 0 30px 0 0 ; border-style: solid;  border-width: 0.5px;">
                                                    <a href="{{ url('/profesor/ver/' . $archivo->id . '/' . $archivo->grado_id . '/' . $archivo->materia_id . '/' . $archivo->archivo) }}"
                                                        class="mailbox-attachment-name"><i
                                                            class="bi bi-arrow-right-square
                                                            "></i>
                                                        {{ $archivo->nombre }}</a>

                                                </div>
                                            </li>
                                        </div>

                                        @if ($contador % 5 == 0)
                            </div>
                            <br>
                            <div class="row">
                        @endif

                        @php $contador++ @endphp
                        @endif
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
@section('script')
