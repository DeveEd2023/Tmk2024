@extends('layouts.master')
@section('title', 'Timonel')
@section('content')
    <form action="{{ url('edisal/guardarRecurso') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <h3 style="font-family: Franklin Gothic; text-align: center;"> <i class="ri-book-open-line"></i>
                Nuevo Recurso
            </h3>
            <hr style="color: #54ac7c;  border-width: 4px;">
            <div class="col-md-6">
                <form action="{{ url('edisal/guardarRecurso') }}" method="post" enctype="multipart/form-data">
                    <div class="box box-primary">

                        <div class="box-body">
                            <div class="form-group">
                                <input type="text" value="1" name="checkboxProfesor" hidden>
                            </div>
                            <div class="form-group">
                                <label for="grado">
                                    <i class="bx bxs-chevrons-up"></i> Grado
                                </label><br>
                                <select name="grado" class="form-select mt-2" id="grado" required>
                                    <option selected disabled>Selecciona un grado</option>
                                    @foreach ($grado as $id => $grado)
                                        <option value="{{ $id }}">{{ $grado }}</option>
                                    @endforeach
                                </select>
                            </div><br>
                            <div class="form-group">
                                <label for="institucio">
                                    <i class="ri-file-edit-line"></i> Materia
                                </label><br>
                                <select name="materia" class="form-select mt-2" id="materia" required>
                                    <option selected disabled>Selecciona materia</option>
                                    @foreach ($materia as $id => $m)
                                        <option value="{{ $id }}">{{ $m }}</option>
                                    @endforeach
                                </select>
                            </div><br>
                            <div class="form-group">
                                <i class="ri-ball-pen-fill"></i> <label>Nombre del recurso</label>
                                <input type="text" name="nombre" id="nombre" class="form-control"
                                    required="required" />
                            </div><br>
                            <div class="form-group file">

                                <i class="ri-file-zip-line"></i> <label>Seleccione un archivo ZIP</label> <br>
                                <input type="file" name="archivo" accept=".zip" required="">
                            </div>
                        </div>
                    </div>
            </div>
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="form-group">
                            <i class="ri-mark-pen-fill"></i> <label>Agregue una descripción</label>
                            <textarea name="descripcion" id="descripcion" class="form-control" cols="90" rows="3" placeholder="." required></textarea>
                        </div> <br>
                        <div class="form-group">
                            <i class="ri-image-add-line<"></i> <label>Imagen </label>
                            <input type="file" name="imagen" class="form-control" accept="image/x-png,image/jpeg"
                                required="">
                        </div>
                    </div>
                    <div class="box-footer"><br>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
    </form>
    </div>

@endsection
@section('script')
