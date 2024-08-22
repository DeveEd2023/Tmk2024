@extends('layouts.profesor')
@section('title', 'Timonel')
@section('content')
    <h3 style="font-family: Franklin Gothic; text-align: center;"> <i class="bx bxs-school"></i> Formaci&aacute;n Docente
    </h3>
    <hr class="separador">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="">

                    <div class="box-body pad">
                        <div class="row">
                            @foreach ($publicaciones as $publicacion)
                                <div class="col-md-3">
                                    <div class="post clearfix">
                                        <h3>{{ $publicacion->titulo }}</h3>
                                        <div class="row margin-bottom">
                                            <div class="col-sm-6">
                                                <img src="{{ URL::to('/') . '/public/formacion/' . $publicacion->id . '/archivos/' . '/imagen/' . $publicacion->imagen }}"
                                                    class="img-responsive" alt="Image"
                                                    style="width: 300px; height: 200px; border-radius: 7% ">
                                            </div>
                                        </div>
                                        <p>
                                            {{ $publicacion->descripcion }}
                                        </p>
                                        <ul class="list-inline">
                                            <li><a href="verFormacion/{{ $publicacion->id }}"
                                                    class="link btn btn-success"><i class="ri-eye-line"></i> Ver
                                                    publicación</a></li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
