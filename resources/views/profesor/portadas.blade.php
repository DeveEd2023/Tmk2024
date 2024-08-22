@extends('layouts.profesor')
@section('title', 'Intituciones')
@section('style')
    <style>
        .widget-user .widget-user-header {
            padding: 20px;
            height: 120px;
            border-top-right-radius: 3px;
            border-top-left-radius: 3px;
        }

        .box {
            position: relative;
            border-radius: 3px;
            background: #ffffff;
            border-top: 3px solid #d2d6de;
            margin-bottom: 20px;
            width: 100%;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        }

        .carousel-inner>.item>a>img,
        .carousel-inner>.item>img,
        .img-responsive,
        .thumbnail a>img,
        .thumbnail>img {
            display: block;
            max-width: 100%;
            height: auto;
        }

        .box-widget {
            border: none;
            position: relative;
        }

        .widget-user .widget-user-username {
            margin-top: 0;
            margin-bottom: 5px;
            font-size: 25px;
            font-weight: 300;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
        }

        .widget-user .widget-user-image>img {
            width: 90px;
            height: auto;
            border: 3px solid #fff;
        }
    </style>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

@endsection
@section('content')
    <section class="content">
        <h3 style="font-family: Franklin Gothic; text-align:center"> <i class="ri-share-line"></i> Timonel Papito</h3>
        <hr style="color: #54ac7c;  border-width: 5px;">
        <div class="row">
            @foreach ($portadas as $portada)
                <div class="col-md-6">
                    <div class="box box-widget widget-user">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header {{ $portada->color }}">
                            <h3 class="widget-user-username">{{ $portada->materia . ' ' . $portada->numero_grado }}</h3>
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
                                            <h5><a style="color: #58ac7c"
                                                    href="{{ URL::to('profesor/extension/consultar/') . '/' . $portada->grado_id . '/' . $portada->materia_id . '/' . $portada->materia }}">Ir
                                                    a la extensión del libro <i class="bx bx-link-external"
                                                        aria-hidden="true"></i></a></h5>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-2">
                                        <div class="description-block">

                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
@section('script')
   
@endsection
