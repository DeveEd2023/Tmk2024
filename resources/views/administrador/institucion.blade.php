@extends('layouts.master')
@section('title', 'Intituciones')
@section('style')
    <style>
        .logo_intitucion img {
            width: 500px;
            /* Ancho estándar */
            height: auto;
            /* Altura ajustada automáticamente */
        }
    </style>
@endsection
@section('content')

    <h3 style="font-family: Franklin Gothic; text-align: center;"> <i class="bx bxs-school"></i> Instituciones</h3>

    <hr style="color: #54ac7c;  border-width: 4px;">


    <div class="">
        <section class="content">
            <div class="row">

                <div class="col-md-12">

                </div>
                <div class="col-md-12">
                    <div class="">


                        <div class="pull-left box-tools">
                            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                data-bs-target="#modalCrear"><i class="bx bxs-institution"></i>
                                Nueva instituci&oacute;n
                            </button>
                        </div>
                        <br>
                        <div class="box-body pad">
                            <table id="datatable" class="table table-bordered table-striped datatable">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">No.</th>
                                        <th style="width: 35%">Nombre</th>
                                        <th>Código</th>
                                        <th>Encargado</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $cont = 1; ?>
                                    @foreach ($instituciones as $institucion)
                                        <tr align="left">
                                            <td>{{ $cont }}</td>
                                            <td>{{ $institucion->ins_nombre }}</td>
                                            <td>{{ $institucion->ins_codigo }}</td>
                                            <td>{{ $institucion->ins_encargado }}</td>
                                            @if ($institucion->inst_estado == 1)
                                                <td>Activa</td>
                                            @else
                                                <td>Inactiva</td>
                                            @endif
                                            <td align="center">
                                                <a data-toggle="modal" title="Cambiar Imagen" data-target="#modal-default"
                                                    class="cambiar_logo" institucion_id = "{{ $institucion->id }}"
                                                    imagen="{{ $institucion->inst_imagen }}"
                                                    logo="{{ $institucion->inst_logo }}"><i
                                                        class="ri-image-edit-fill"></i></a>
                                                &nbsp;
                                                <a data-toggle="tooltip" href="#" title="editarUsuario"
                                                    data-value-editar="{{ $institucion->id }}">
                                                    <i class="bx bxs-pencil"></i>
                                                </a>
                                                @if ($institucion->id != 1)
                                                    <a data-toggle="tooltip" title="Eliminar Usuario"
                                                        id="{{ $institucion->id }}" class="eliminar"
                                                        name="{{ $institucion->ins_nombre }}" href="#"><i
                                                            class="bx bxs-trash"></i> </a>
                                                @endif
                                            </td>
                                        </tr>
                                        <?php $cont++; ?>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!------------------------------------------------ modal crear --------------------------------------------------------------------->

    <div class="modal fade" id="modalCrear" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #57ad7a ">
                    <h5 class="modal-title" style="color: #fff; text-align: center;">
                        <i class="bx bxs-institution"></i> Nueva Instituci&oacute;n
                    </h5>
                </div>
                <form id="userForm" class="needs-validation was-validated" action="{{ url('admin/nuevaInstitucion') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body row" id="cont_modal">
                        <div class="col-md-6">
                            <div class="form-group">
                                <i class="bx bxs-institution"></i> <label for="nombre"> Nombre:</label>
                                <input type="text" id="nombre" name="nombre" class="form-control"
                                    placeholder="Digite el nombre de la instituci&oacute;n" required>
                            </div><br>
                            <div class="form-group">
                                <i class="bx bx-hash"></i> <label for="codigo"> C&oacute;digo</label>
                                <input type="text" id="codigo" name="codigo" class="form-control"
                                    placeholder="Digite el codigo de infraestructura" required>
                            </div><br>
                            <div class="form-group">
                                <i class="bx bxs-phone-call"></i> <label for="telefono"> Tel&eacute;fono</label>
                                <input type="text" id="telefono" name="telefono" class="form-control"
                                    placeholder="Digite el n&uacute;mero de tel&eacute;fono" required>
                            </div><br>


                            <div class="form-group">
                                <i class="ri-map-pin-time-line"></i> <label for="ciclo"> ciclo</label>
                                <select name="ciclo" class="form-select mt-2" id="ciclo" required>
                                    <option selected disabled>Selecciona una institución</option>
                                    @foreach ($ciclo as $c)
                                        <option value="{{ $c->id }}">{{ $c->cic_ciclo }}</option>
                                    @endforeach
                                </select>
                            </div><br>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <i class="bx bxs-institution"></i> <label for="encargado"> Encargado:</label>
                                <input type="text" id="encargado" name="encargado" class="form-control"
                                    placeholder="Digite el nombre del encargado" required>
                            </div><br>
                            <div class="form-group">
                                <i class="ri-mail-check-line"></i> <label for="correoEnc"> Correo del encargado</label>
                                <input type="email" id="correoEn" name="correoEn" class="form-control"
                                    placeholder="Digite un correo" required>
                            </div><br>
                            <div class="form-group">
                                <i class="bx bxs-phone-call"></i> <label for="telefonoEn"> Tel&eacute;fono
                                    encargado</label>
                                <input type="text" id="telefonoEn" name="telefonoEn" class="form-control"
                                    placeholder="Digite un n&uacute;mero de tel&eacute;fono" required>
                            </div><br>
                            <div class="form-group">
                                <i class="ri-image-add-fill"></i> <label for="logo" style=""> Seleccione un
                                    logo</label>

                                <input id="upload-Image" name="logo" type="file" class="form-control"
                                    accept="image/x-png,image/gif,image/jpeg" style="max-width: 100%;" />
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

    <!------------------------------------------------ modal Imagenes --------------------------------------------------------------------->

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formEdit" action="{{ url('admin/nuevaImagen') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header" style="background-color: #6cbcbc">
                        <h5 class="modal-title" style="color: #fff; text-align: center;">
                            <i class=" ri-picture-in-picture-2-line"></i> Cambiar logo
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="logo_intitucion" style="width: 100%; padding: 10px; text-align: center;">
                            <img id="logo-preview" src="" style="width: 200px; height: 150px;" alt="Logo">
                        </div>
                        <i class="ri-image-add-fill"></i> <label for="telefono" style=""> Seleccione un
                            logo</label>
                        <input id="upload-Image" name="logo" type="file"
                            accept="image/x-png,image/gif,image/jpeg" />
                        <input type="hidden" name="institucion_id" id="institucion_id">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="submit">Guardar</button>
                        <button type="button" class="btn btn-default pull-rigth" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!------------------------------------------------ modal Editar --------------------------------------------------------------------->



    <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #dea500 ">
                    <h5 class="modal-title" style="color: #fff; text-align: center;">
                        <i class="bx bxs-institution"></i> Editar instituci&oacute;n
                    </h5>
                </div>
                <form id="userForm" action="{{ url('admin/editarInstitucion') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body row" id="cont_modal">

                        <div class="col-md-6">
                            <input id="uid" name="id" hidden>
                            <div class="form-group">
                                <i class="bx bxs-institution"></i> <label for="nombre"> Nombre:</label>
                                <input type="text" id="Unombre" name="nombre" class="form-control"
                                    placeholder="Digite el nombre de la instituci&oacute;n" required>
                            </div><br>
                            <div class="form-group">
                                <i class="bx bx-hash"></i> <label for="codigo"> C&oacute;digo</label>
                                <input type="text" id="Ucodigo" name="codigo" class="form-control"
                                    placeholder="Digite el codigo de infraestructura" required>
                            </div><br>
                            <div class="form-group">
                                <i class="bx bxs-phone-call"></i> <label for="telefono"> Tel&eacute;fono</label>
                                <input type="text" id="Utelefono" name="telefono" class="form-control"
                                    placeholder="Digite el n&uacute;mero de tel&eacute;fono" required>
                            </div><br>

                            <div class="form-group">
                                <i class="ri-image-add-fill"></i> <label for="telefono" style=""> Seleccione un
                                    logo</label>
                                <input id="UImage" name="logo" type="file"
                                    accept="image/x-png,image/gif,image/jpeg" />
                            </div><br>


                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <i class="bx bxs-institution"></i> <label for="encargado"> Encargado:</label>
                                <input type="text" id="Uencargado" name="encargado" class="form-control"
                                    placeholder="Digite el nombre del encargado" required>
                            </div><br>
                            <div class="form-group">
                                <i class="ri-mail-check-line"></i> <label for="correoEnc"> Correo del encargado</label>
                                <input type="text" id="UcorreoEn" name="correoEn" class="form-control"
                                    placeholder="Digite un correo" required>
                            </div><br>
                            <div class="form-group">
                                <i class="bx bxs-phone-call"></i> <label for="telefonoEn"> Tel&eacute;fono
                                    encargado</label>
                                <input type="text" id="UtelefonoEn" name="telefonoEn" class="form-control"
                                    placeholder="Digite un n&uacute;mero de tel&eacute;fono" required>
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


    <!------------------------------------------------ modal Editar --------------------------------------------------------------------->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: red ">
                    <h5 class="modal-title" style="color: #fff; text-align: center;">
                        <i class="bx bxs-institution"></i> Elimiar Instituci&oacute;n
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
        $('.cambiar_logo').on('click', function() {
            var aqui = $(this);
            var id = aqui.attr('institucion_id');
            var logo = aqui.attr('logo');
            var imagen = aqui.attr('imagen');

            if (parseInt(imagen) == 1) {

                $('.logo_intitucion').html('<img src="' + logo + '" class="img-responsive" id="logo" alt="Logo">');
            } else {

                $('.logo_intitucion').html("");
            }

            $('#institucion_id').val(id);
            $('#modal-default').modal('show');
        });


        //editar
        const modal_editar = new bootstrap.Modal("#modalEditar");
        const button_editar = document.querySelectorAll("[data-value-editar]");
        const codigo = document.getElementById("uid");
        const nombre = document.getElementById("Unombre");
        const codigoInstitucion = document.getElementById("Ucodigo");
        const telefono = document.getElementById("Utelefono");
        const imagen = document.getElementById("Uimage");
        const encargado = document.getElementById("Uencargado");
        const correoEn = document.getElementById("UcorreoEn");
        const UtelefonoEn = document.getElementById("UtelefonoEn");

        [].slice.call(button_editar).forEach(async function(item) {
            item.addEventListener('click', async () => {
                await fetch("{{ url('admin/buscarInstitucion') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            "id": item.getAttribute("data-value-editar")
                        }),
                    }).then((response) => response.json())
                    .then((data) => {

                        codigo.value = data.id;
                        nombre.value = data.ins_nombre;
                        codigoInstitucion.value = data.ins_codigo;
                        telefono.value = data.ins_telefono;
                        encargado.value = data.ins_encargado;
                        correoEn.value = data.ins_email_encargado;
                        UtelefonoEn.value = data.ins_telefono_encargado;
                        modal_editar.show();
                    });
            });
        });

        //eliminar
        $('body').on('click', '.eliminar', function() {
            const id = $(this).attr('id');
            const name = $(this).attr('name');
            console.log('Institucion: ' + name);
            $('#confirmMessage').html(`¿Está seguro que quiere eliminar la institucion: <strong>${name}</strong>?`);
            $('#confirmModal').modal('show');
            $('#confirmBtn').on('click', function() {
                window.location.href = `eliminarInstitucion/${id}`;
            });
        });
    </script>
@endsection
