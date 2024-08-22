@extends('layouts.master')
@section('title', 'Intituciones')
@section('content')




    <h3 style="font-family: Franklin Gothic; text-align:center"> <i class="bx bx-book-content"></i> Recursos Extension de
        Libreta</h3>
    <hr style="color: #54ac7c;  border-width: 4px;">
    <div class="box-body pad">


        <div class="pull-left box-tools">
            <a href="{{ url('edisal/nuevaExtencion') }}" class="btn btn-outline-success"><i class="ri-file-edit-line"></i>
                Nueva Extensión
            </a>
        </div>

        <br>
        <table id="ttemas" class="table table-bordered table-striped datatable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tema</th>
                    <th>Grado</th>
                    <th>Materia</th>
                    <th>Unidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $cont = 1; ?>
                @foreach ($recursos as $recurso)
                    <tr align="left">
                        <td>{{ $cont }}</td>
                        <td>{{ $recurso->tema }}</td>
                        <td>{{ $recurso->grado }}</td>
                        <td>{{ $recurso->materia }}</td>
                        <td>{{ $recurso->unidad }}</td>
                        <td><a data-toggle="tooltip" title="Ver Tema" href="extension/mostrar/{{ $recurso->id }}"><i
                                    class="ri-eye-line"></i> &nbsp;&nbsp;</a>
                            <a data-toggle="tooltip" title="Editar Contenido" href="extension/editar/{{ $recurso->id }}"><i
                                    class="fa fa-pencil"></i> &nbsp;&nbsp;</a>
                            <a data-toggle="tooltip" title="Eliminar Tema" id="{{ $recurso->id }}" class="eliminar"
                                name="{{ $recurso->tema }}"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                    <?php $cont++; ?>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection
@section('script')
