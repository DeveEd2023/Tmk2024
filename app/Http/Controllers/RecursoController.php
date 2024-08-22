<?php

namespace App\Http\Controllers;

use App\Models\ArchivoExtencion;
use App\Models\Extenciones;
use App\Models\Formacion;
use App\Models\FormacionArchivo;
use App\Models\Planificacion;
use App\Models\RecursoExtencion;
use App\Models\Recursos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use ZipArchive;

class RecursoController extends Controller
{

    //------------------------------------------------------------------- Formacion docente -------------------------------------------------------------------
    public function formacionDocente()
    {
        $publicaciones = DB::table('forc_formacioncontinua AS f')
            ->select(
                'f.id AS id',
                'f.forc_titulo As titulo',
                'f.forc_descripcion AS descripcion',
            )
            ->get();
        return view('recursos.formacionDocente')->with('publicaciones', $publicaciones);
    }
    public function nuevaFormacionDocente()
    {
        $categorias = DB::table('catfc_categoriasformacion')->pluck('catfc_nombre', 'id');
        $materias = DB::table('cat_materias')->pluck('cat_materia', 'id');
        return view('recursos.nuevaFormacion')
            ->with('materias', $materias)
            ->with('categorias', $categorias);
    }
    public function crearFormacion(Request $request)
    {

        Validator::make(
            $request->all(),
            Formacion::ruleCrear()
        )->addCustomAttributes(
            Formacion::attrCrear()
        )->validate();

        $imagen = $request->file('imagen');
        $formacion = new Formacion;

        $fecha = date("Y-m-d_H-i-s");
        $nombre = str_replace(' ', '_', $fecha);
        $nombre = $nombre . "." . Auth::user()->log_nombre;
        $formacion->forc_titulo = $request->get('titulo');
        $formacion->forc_descripcion = $request->get('descripcion');
        $formacion->forc_imagen = str_replace(' ', '_', $imagen->getClientOriginalName());
        $formacion->forc_archivo_txt = $nombre;
        $formacion->save();
        // Guardar archivo de texto
        $contenido = $request->get('txtEditor');
        $path = public_path('formacion/') . $formacion->id . '/contenidos/';
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        $archivo = fopen($path . $nombre . '.txt', "w");
        fwrite($archivo, $contenido);
        fclose($archivo);
        $imagen->move(public_path('formacion/' . $formacion->id . '/archivos/imagen/'), str_replace(' ', '_', $imagen->getClientOriginalName()));
        $nfile = $request->get('nombrefile');
        $file = $request->file('file');
        if (!empty($nfile) && $file != null) {
            $archivo = new FormacionArchivo;
            $archivo->aforc_forc_id = $formacion->id;
            $archivo->aforc_nombre_archivo = $nfile;
            $archivo->aforc_nombre_fisico = str_replace(' ', '_', $file->getClientOriginalName());
            $archivo->aforc_tipo_extension = $file->getClientOriginalExtension();
            $archivo->aforc_mime = $file->getMimeType();
            $archivo->save();
            $file->move(public_path('formacion/' . $formacion->id . '/archivos/'), str_replace(' ', '_', $file->getClientOriginalName()));
        }
        Session::flash('type', 'success');
        Session::flash('message', '¡Publicación creada con éxito!');
        return Redirect('edisal/formacionDocente');
    }

    public function verFormacion($id)
    {
        $formacion =  DB::select('SELECT
        f.id AS formacion_id,
        f.forc_titulo AS titulo,
        f.created_at AS fecha,
        f.forc_descripcion AS descripcion,
        f.forc_imagen AS imagen,
        f.forc_archivo_txt AS archivo_txt,
          a.aforc_nombre_fisico AS archivo,
        a.aforc_nombre_archivo AS nombre_archivo,
        a.aforc_mime AS mime,
        a.aforc_tipo_extension AS extension
    FROM
        forc_formacioncontinua AS f
    LEFT JOIN aforc_archivoforc AS a ON a.aforc_forc_id= f.id
    WHERE f.id = ' . $id . ';');
        return view('recursos.verFormacion')->with('formacion', $formacion)->with('formacion_id', $id);
    }
    public function eliminarFormacion($id)
    {
        $formacion = Formacion::findOrFail($id);
        $path = public_path('formacion/' . $formacion->id);
        File::deleteDirectory($path);
        if (is_dir($path)) {
            rmdir($path);
        }
        $formacion->delete();
        Session::flash('type', 'warning');
        Session::flash('message', '¡Publicación eliminada correctamente!');
        return redirect('edisal/formacionDocente');
    }

    public function editarFormacion($id)
    {
        $formacion =  DB::select('SELECT
											f.id AS formacion_id,
											f.forc_titulo AS titulo,
			   							    f.forc_descripcion AS descripcion,
											f.forc_imagen AS imagen,
											f.forc_archivo_txt AS archivo_txt,
											a.aforc_nombre_fisico AS archivo,
											a.aforc_nombre_archivo AS nombre_archivo,
											a.aforc_mime AS mime,
											a.aforc_tipo_extension AS extension
										FROM
											forc_formacioncontinua AS f
										LEFT JOIN aforc_archivoforc AS a ON a.aforc_forc_id= f.id
										WHERE f.id = ' . $id . ';');
        return view('recursos.editarFormacion')->with('formacion', $formacion);
    }

    public function actualizarFormacion(Request $request)
    {
        $imagen = $request->imagen;
        $nombreAnterior = $request->nombre_anterior_txt;
        $formacion_id = $request->formacion_id;
        $forc_titulo = $request->titulo;
        $forc_descripcion = $request->descripcion;
        $contenido = trim($request->txtEditor);
        $path = public_path('formacion/') . $formacion_id . '/contenidos/';

        $archivo = fopen($path . $nombreAnterior . '.txt', "w");
        if ($archivo !== false) {
            fwrite($archivo, $contenido);
            fclose($archivo);
        } else {
        }
        if ($imagen !== null) {
            $forc_imagen = str_replace(' ', '_', $imagen->getClientOriginalName());
            $imagen->move(public_path('formacion/' . $formacion_id . '/archivos/imagen/'), $forc_imagen);
        }
        // Actualizar la base de datos
        $dataToUpdate = [
            'forc_titulo' => $forc_titulo,
            'forc_descripcion' => $forc_descripcion,
        ];
        if (isset($forc_imagen)) {
            $dataToUpdate['forc_imagen'] = $forc_imagen;
        }

        DB::table('forc_formacioncontinua')->where('id', $formacion_id)->update($dataToUpdate);
        Session::flash('type', 'success');
        Session::flash('message', '¡Publicación Actualizada con éxito!');

        return redirect('edisal/formacionDocente');
    }

    public function descargaArchivoFormacion($id, $archivo)
    {
        $file = public_path() . "/formacion/" . $id . "/archivos/" . $archivo;
        //header para el archivo html
        $headers = array(
            'Content-Type: application/pdf',
        );
        return response()->download($file, $archivo, $headers);
    }


    //------------------------------------------------------------------- Recursos -------------------------------------------------------------------

    public function listarRecursos()
    {
        $recursos = Recursos::select(
            'r.id AS id',
            'r.rec_nombre AS nombre',
            'r.rec_descripcion AS descripcion',
            'tr.tiprec_nombre AS tipo',
            'gr.cat_grado AS grado',
            'r.rec_catgr_id AS grado_id',
            'r.rec_catmat_id AS materia_id',
            'mt.cat_materia AS materia',
            'r.rec_archivo AS archivo',
            'r.rec_libros AS libros',
            'r.rec_alumno AS alumno',
            'r.rec_profesor AS profesor',
            'r.rec_director AS director',
            'r.rec_padre AS padre',
            'r.rec_img AS flag_imagen',
            'r.ext_imagen_unidad AS imagen'
        )
            ->from('rec_rec_recursos AS r')
            ->join('rec_tiprec_tiporecurso AS tr', 'r.rec_tiprec_id', '=', 'tr.id')
            ->join('cat_grados AS gr', 'r.rec_catgr_id', '=', 'gr.id')
            ->join('cat_materias AS mt', 'r.rec_catmat_id', '=', 'mt.id')
            ->orderBy('r.id', 'desc')
            ->get();

        return view('recursos.listaRecursos')->with('recursos', $recursos);
    }

    public function verRecurso($id, $grado, $materia, $archivo)
    {
        return view('recursos.verWeb')
            ->with('id', $id)
            ->with('grado', $grado)
            ->with('materia', $materia)
            ->with('archivo', $archivo);
    }
    public function nuevoRecurso()
    {
        $grados = DB::table('cat_grados')->pluck('cat_grado', 'id');
        $materias = DB::table('cat_materias')->pluck('cat_materia', 'id');
        return view('recursos.nuevoRecurso')
            ->with('grado', $grados)
            ->with('materia', $materias);
    }
    public function guardarRecurso(Request $request)
    {

        Validator::make(
            $request->all(),
            Recursos::ruleCrear()
        )->addCustomAttributes(
            Recursos::attrCrear()
        )->validate();

        $profesor = 1;
        $tip = 10;
        $nom = $request->nombre;
        $grado = $request->grado;
        $materia = $request->materia;
        $file_imagen = $request->imagen;
        $recurso = new Recursos;
        $recurso->rec_tiprec_id = $tip;
        $recurso->rec_catgr_id = $grado;
        $recurso->rec_catmat_id = $materia;
        $recurso->rec_nombre = $nom;
        $recurso->rec_archivo = "index.html";
        $recurso->rec_descripcion = $request->descripcion;
        $recurso->rec_url = 0;
        $recurso->rec_profesor = $profesor;
        $recurso->rec_alumno = 0;
        $recurso->rec_director = 0;
        $recurso->rec_padre = 0;
        $recurso->rec_todos = 0;
        $recurso->rec_libros = 0;
        if (isset($file_imagen) && !empty($file_imagen)) {
            $img = file_get_contents($file_imagen);
            $imagen = base64_encode($img);
            $imagen = "data:image/jpg;base64," . $imagen;
            $recurso->rec_img = 1;
            $recurso->ext_imagen_unidad = $imagen;
        }
        $recurso->save();
        if ($_FILES["archivo"]["name"]) {
            $nombre = $_FILES["archivo"]["name"];
            $ruta = $_FILES["archivo"]["tmp_name"];
            $tipo = $_FILES["archivo"]["type"];

            $zip = new ZipArchive;
            if ($zip->open($ruta) === TRUE) {

                $extraido = $zip->extractTo(public_path('recursos/' . $recurso->id . '/' . $grado . '/' . $materia));
                $zip->close();
            } else {
            }
        }
        Session::flash('type', 'success');
        Session::flash('message', 'Recurso subido con éxito!');

        return Redirect('edisal/recursos');
    }

    public function eliminarResurso($id)
    {
        $recursos = Recursos::findOrFail($id);

        $path = public_path('recursos/' . $recursos->id);
        File::deleteDirectory($path);
        if (is_dir($path)) {
            rmdir($path);
        }
        $recursos->delete();
        Session::flash('type', 'warning');
        Session::flash('message', '¡Recurso eliminado correctamente!');
        return redirect('edisal/recursos');
    }
    //------------------------------------------------------------------- Extenciones -------------------------------------------------------------------

    public function listaExtenciones()
    {
        $recursos = Extenciones::select(
            'rec.id AS id',
            'rec.ext_tema As tema',
            'gr.cat_grado AS grado',
            'mt.cat_materia AS materia',
            'u.cat_rec_unidad_numero AS unidad'
        )
            ->from('rec_ext_extension AS rec')
            ->join('cat_materias AS mt', 'rec.ext_cat_materia_id', '=', 'mt.id')
            ->join('cat_grados AS gr', 'rec.ext_cat_grado_id', '=', 'gr.id')
            ->join('cat_rec_unidades AS u', 'rec.ext_cat_unidad_id', '=', 'u.id')
            ->orderBy('rec.id', 'desc')

            ->get();
        return view('recursos.listaExtenciones')->with('recursos', $recursos);
    }

    public function extensionMostrar($id)
    {

        $recurso = DB::table('rec_ext_extension AS rec')
            ->select(
                'rec.id AS id',
                'rec.ext_tema As tema',
                'rec.ext_contenido AS contenido',
                'rec.created_at AS fecha',
                'gr.cat_grado AS grado',
                'mt.cat_materia AS materia',
                'u.cat_rec_unidad_numero AS unidad'
            )
            ->join('cat_materias AS mt', 'rec.ext_cat_materia_id', '=', 'mt.id')
            ->join('cat_grados AS gr', 'rec.ext_cat_grado_id', '=', 'gr.id')
            ->join('cat_rec_unidades AS u', 'rec.ext_cat_unidad_id', '=', 'u.id')
            ->where('rec.id', '=', $id)
            ->get();
        $archivos = DB::table('arcext_archivos')
            ->select('id AS archivo_id', 'arcext_ext_id AS recurso_id', 'arcext_nombre AS nombre_archivo', 'arcext_archivo AS archivo', 'arcext_extension AS extension', 'arcext_mime AS mime', 'arcext_tamano AS tam')
            ->where('arcext_ext_id', '=', $recurso[0]->id)
            ->get();

        return view('recursos.extencionMostrar')
            ->with('recurso', $recurso)
            ->with('archivos', $archivos);
    }
    public function nuevaExtencion()
    {
        $grado = DB::table('cat_grados')->pluck('cat_grado', 'id');
        $materia = DB::table('cat_materias')->pluck('cat_materia', 'id');
        $unidad = DB::table('cat_rec_unidades')->pluck('cat_rec_unidad_numero', 'id');


        return view('recursos.nuevaExtencion')
            ->with('grado', $grado)
            ->with('materia', $materia)
            ->with('unidad', $unidad);
    }

    public function guardarExtencion(Request $request)
    {
        Validator::make(
            $request->all(),
            RecursoExtencion::ruleCrear()
        )->addCustomAttributes(
            RecursoExtencion::attrCrear()
        )->validate();
   
        $recurso = new RecursoExtencion;
        $recurso->ext_cat_grado_id = $request->grado;
        $recurso->ext_cat_materia_id = $request->materia;
        $recurso->ext_cat_unidad_id = $request->unidad;
        $recurso->ext_tema = $request->tema;
        $recurso->ext_contenido = $request->datos;
        $recurso->save();
        $nfile      = $request->nombrefile;
        $file       = $request->file;

        foreach ($nfile as $key => $value) {
            if (!empty($file[$key])) {
                $archivos = new ArchivoExtencion;
                $tamanioArchivoByte = filesize($file[$key]);
                $tamanioArchivoKbyte = $tamanioArchivoByte / 1024;
                $archivos->arcext_ext_id   = $recurso->id;
                $archivos->arcext_nombre   = $value;
                $archivos->arcext_archivo  = str_replace(' ', '_', $file[$key]->getClientOriginalName());
                $archivos->arcext_tamano   = round($tamanioArchivoKbyte, 2);
                $archivos->arcext_extension = $file[$key]->getClientOriginalExtension();
                $archivos->arcext_mime     = $file[$key]->getMimeType();
                $archivos->save();

                //Cargo al servidor el archivo fisico
                $file[$key]->move(public_path('extensiones/' . $recurso->id), str_replace(' ', '_', $file[$key]->getClientOriginalName()));
            }
        }
        Session::flash('type', 'success');
        Session::flash('message', '¡Extension de Libro subida con éxito!');
        return redirect('edisal/extencion');
    }

    //------------------------------------------------------------------- Planificaciones -------------------------------------------------------------------

    public function listaPlanificaciones()
    {
        $planificacion = Planificacion::select(
            'plan.id AS id',
            'gr.cat_grado AS grado',
            'mt.cat_materia AS materia',
            'u.cat_rec_unidad_numero AS unidad'
        )
            ->from('planificacion AS plan')
            ->join('cat_materias AS mt', 'plan.plan_cat_materia_id', '=', 'mt.id')
            ->join('cat_grados AS gr', 'plan.plan_cat_grado_id', '=', 'gr.id')
            ->join('cat_rec_unidades AS u', 'plan.plan_cat_unidad_id', '=', 'u.id')
            ->orderBy('plan.id', 'desc')
            ->get();

        return view('recursos.listaPlanificaciones')->with('planificacion', $planificacion);
    }

    public function planificacionMostrar($id = null)
    {
        $recurso = DB::table('planificacion AS plan')
            ->select(
                'plan.id AS id',
                'plan.created_at AS fecha',
                'gr.cat_grado AS grado',
                'mt.cat_materia AS materia',
                'u.cat_rec_unidad_numero AS unidad'
            )
            ->join('cat_materias AS mt', 'plan.plan_cat_materia_id', '=', 'mt.id')
            ->join('cat_grados AS gr', 'plan.plan_cat_grado_id', '=', 'gr.id')
            ->join('cat_rec_unidades AS u', 'plan.plan_cat_unidad_id', '=', 'u.id')
            ->where('plan.id', '=', $id)
            ->get();
        $archivos = DB::table('planificacion_archivos')
            ->select('id AS archivo_id', 'plan_id AS recurso_id', 'plan_arc_nombre AS nombre_archivo', 'plan_arc_archivo AS archivo', 'plan_arc_extension AS extension', 'plan_arc_mime AS mime', 'plan_arc_tamano AS tam')
            ->where('plan_id', '=', $recurso[0]->id)
            ->get();

        return view('recursos.planificacionMostrar')->with('recurso', $recurso)->with('archivos', $archivos);
    }
}
