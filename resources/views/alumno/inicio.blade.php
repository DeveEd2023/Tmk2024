@extends('layouts.alumno')
@section('title', 'Timonel')
@section('content')

    <section class="content">


        <div class=" text-center">
            @if ($img || $inst)
                <div class="btn btn-outline m-0 p-0 d-flex align-items-center justify-content-center">
                    @if ($img)
                        <div>
                            <img src="{{ $img }}" style="height: 120px; border: 0;" class="img-responsive thumbnail"
                                alt="Logo de la institución">
                        </div>
                    @endif
                    <div>
                        <h3 style="color: black
                            ;">Institucion {{ $inst }}</h3>
                    </div>
                </div>
            @endif
            <hr style="color: #40bcf0;  border-width: 4px;">
            <br><br>
        </div>
        <div class="row">
            @foreach ($portadas as $portada)
                <div class="col-md-6">
                    <div class="box box-widget widget-user">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header {{ $portada->color }}">
                            <h3 class="widget-user-username">{{ $portada->materia }}</h3>
                            <h5 class="widget-user-desc">Materia</h5>
                        </div>
                        <div class="widget-user-image">
                            <img class="img-responsive" src="{{ $portada->imagen }}" alt="Portada">
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="row">
                                    <div class="col-sm-2 border-right">
                                        <div class="description-block">

                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-8 border-right">
                                        <div class="description-block">
                                            <br>
                                            <h5> <a style="color: #58ac7c"
                                                    href="{{ URL::to('alumno/extension/consultar/') . '/' . $portada->grado_id . '/' . $portada->materia_id . '/' . $portada->materia }}">Ir
                                                    a la extensión del libro <i class="bx bx-link-external"
                                                        aria-hidden="true"></i></a></h5>
                                        </div>

                                    </div>

                                    <div class="col-sm-2">
                                        <div class="description-block">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
@section('script')
