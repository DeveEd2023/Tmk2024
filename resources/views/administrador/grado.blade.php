@extends('layouts.master')
@section('title', 'Intituciones')
@section('content')
    <h3 style="font-family: Franklin Gothic; text-align: center"> <i class="bx bxs-chevrons-up"></i> Grados</h3>
    <hr style="color: #54ac7c;  border-width: 4px;">
    <section class="content">
        <div class="row">

            <div class="pull-left box-tools">
                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalCrear"><i
                        class="bx bxs-chevrons-up"></i>
                    Nuevo grado
                </button>
            </div>
            <br> <br>
            <div class="box-body pad">
                <table id="ttareas" class="table table-bordered table-striped datatable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Grado</th>
                            <th>Instituci&oacute;n</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $cont = 1; ?>
                        @foreach ($grados as $grado)
                            <tr align="left">
                                <td>{{ $cont }}</td>
                                <td>{{ $grado->grado }}</td>
                                <td>{{ $grado->institucion }}</td>
                                <td>
                                    @if ($grado->estado == 1)
                                        Activo
                                    @else
                                        Inactivo
                                    @endif
                                </td>
                                <td align="center">
                                    <a data-toggle="tooltip" title="Eliminar Usuario" id="{{ $grado->id }}"
                                        class="eliminar" name="{{ $grado->grado }}" href="#"><i
                                            class="bx bxs-trash"></i> </a>
                                </td>
                            </tr>
                            <?php $cont++; ?>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modalCrear" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #57ad7a ">
                    <h5 class="modal-title" style="color: #fff; text-align: center;">
                        <i class="bx bxs-chevrons-up"></i> Nuevo Grado
                    </h5>
                </div>
                <form id="userForm" action="{{ url('admin/nuevoGrado') }}" method="POST">
                    @csrf
                    <div class="modal-body row" id="cont_modal">
                        <div class="col-md-12">
                            <div class="form-group">
                                <i class="bx bxs-chevrons-up"></i>
                                <label for="grado"> Grado</label>
                                <select name="grado" class="form-select" id="grado">
                                    <option selected disabled>Selecciona un grado</option>
                                    @foreach ($g as $g)
                                        <option value="{{ $g->id }}"> {{ $g->cat_grado }}
                                        </option>
                                    @endforeach
                                </select>
                            </div><br>
                            <div class="form-group">
                                <i class="bx bxs-institution"></i>
                                <label for="institucion"> Instituci&oacute;n</label>
                                <select name="institucion" class="form-select" id="institucion">
                                    <option selected disabled>Selecciona una institucion</option>
                                    @foreach ($institucion as $i)
                                        <option value="{{ $i->id }}"> {{ $i->institucion }}
                                        </option>
                                    @endforeach
                                </select>
                            </div><br>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-secondary" data-bs-dismiss="modal" style="border: none;"
                            aria-label="Close">Cerrar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <!------------------------------------------------ modal eliminar --------------------------------------------------------------------->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: red ">
                    <h5 class="modal-title" style="color: #fff; text-align: center;">
                        <i class="ri-chat-delete-line"></i> Elimiar Grado
                    </h5>
                </div>
                <div class="modal-body">
                    <p id="confirmMessage"></p>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-secondary" data-bs-dismiss="modal" style="border: none;"
                        aria-label="Close">Cerrar</a>
                    <button type="button" class="btn btn-danger" id="confirmBtn">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        //eliminar
        $('body').on('click', '.eliminar', function() {
            const id = $(this).attr('id');
            const name = $(this).attr('name');
            console.log('Institucion: ' + name);
            $('#confirmMessage').html(`¿Está seguro que quiere eliminar el grado: <strong>${name}</strong>?`);
            $('#confirmModal').modal('show');
            $('#confirmBtn').on('click', function() {
                window.location.href = `eliminarGrado/${id}`;
            });
        });
    </script>
@endsection
