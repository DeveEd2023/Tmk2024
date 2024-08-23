@extends('layouts.master')

@section('title', 'Timonel')

@section('content')


    <div class="col-md-2"></div>
    <div class="col-md-8 max-auto center">

        <div class="box-body pad">
            <form action="{{url('admin/guardarAlumunos')}}" method="POST" enctype="multipart/form-data">
                @csrf



                <!-- Campo para seleccionar la institución -->
                <div class="form-group">
                    <label for="institucion">Institución:</label>
                    <select name="institucion" class="form-control" required>
                        <option value="">Seleccione una institución</option>
                        <!-- Aquí irían las opciones de instituciones dinámicamente -->
                        <option value="1">Institución A</option>
                        <option value="2">Institución B</option>
                        <option value="3">Institución C</option>
                    </select>
                </div>


                <div class="form-group">
                    <label for="grado">Grado:</label>
                    <select name="grado" class="form-control" required>
                        <option value="">Seleccione un grado</option>

                        <option value="1">Grado 1</option>
                        <option value="2">Grado 2</option>
                        <option value="3">Grado 3</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="seccion">Sección:</label>
                    <select name="seccion" class="form-control" required>
                        <option value="">Seleccione una sección</option>

                        <option value="1">Sección A</option>
                        <option value="2">Sección B</option>
                        <option value="3">Sección C</option>
                    </select>
                </div>


                <div class="form-group">
                    <label for="file">Subir archivo Excel:</label>
                    <input type="file" name="file" class="form-control" required accept=".xls,.xlsx">
                </div>

                <br><br>


                <button type="submit" class="btn btn-primary">Registrar Alumnos</button>
            </form>

        </div>
    </div>
    <div class="col-md-2"></div>
@endsection

@section('script')
