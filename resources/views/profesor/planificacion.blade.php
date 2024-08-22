@extends('layouts.profesor')
@section('title', 'Timonel')
@section('content')
    <h3 style="font-family: Franklin Gothic; text-align:center"> <i class="ri-pencil-fill"></i> Recursos Didácticos</h3>
    <hr class="separador">
    <div class="row">
        @foreach ($portadas as $portada)
            <div class="col-md-6">
                <div class="box box-widget widget-user">
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
                                </div>
                                <div class="col-sm-8 border-right">
                                    <div class="description-block">
                                        <br>
                                        <h5> <a style="text-decoration: none; color: #58ac7c;"
                                                href="{{ URL::to('profesor/planificacion/mostrarRecursos/') . '/' . $portada->grado_id . '/' . $portada->materia_id . '/' . $portada->materia }}">Ver
                                                Planificación <i class="ri-share-forward-2-fill" aria-hidden="true"></i></a>
                                        </h5>
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
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ Session::get('usuario_institucion_nombre') }}</h4>
                </div>
                <div class="modal-body">
                    <img src="{{ Session::get('usuario_institucion_logo') }}" class="img-responsive"
                        alt="Logo de la institución">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
