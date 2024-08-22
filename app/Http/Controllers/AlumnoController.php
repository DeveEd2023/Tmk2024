<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\DatosUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlumnoController extends Controller
{
    public function verLibreta($id, $grado, $materia, $archivo)
    {
        return view('alumno.verLibreta')->with('id', $id)->with('grado', $grado)->with('materia', $materia)->with('archivo', $archivo);
    }


    public function mostrarRecurso($id)
    {

        $alumno = Alumno::where('ins_usu_id', $id)->first();

        if ($alumno->ins_grado_id != 0) {


            $materias = DB::table('inst_mat_materias AS m')
                ->select('m.id AS materia_id', 'cm.cat_materia AS materia', 'cm.id AS cat_materia_id')
                ->join('cat_materias AS cm', 'm.mat_cat_id', '=', 'cm.id')
                ->where('m.mat_gra_id', '=', $alumno->ins_grado_id)
                ->groupBy('cm.cat_materia', 'm.id', 'cm.id')
                ->get();

            $condicion = 'WHERE r.rec_profesor = 1';
            if (!empty($materias)) {
                foreach ($materias as $key => $value) {
                    if ($key == 0) {
                        $condicion = $condicion . ' AND r.rec_catmat_id = ' . $value->cat_materia_id . ' AND (r.rec_catgr_id = ' . $alumno->ins_grado_id  . ')';
                    } else {
                        $condicion = $condicion . ' OR r.rec_catmat_id = ' . $value->cat_materia_id . ' AND (r.rec_catgr_id = ' . $alumno->ins_grado_id  . ')';
                    }
                }
            }

            $recursos =  DB::select('SELECT
                                r.id AS id,
                                r.rec_nombre AS nombre,
                                r.rec_descripcion AS descripcion,
                                tr.tiprec_nombre AS tipo,
                                gr.cat_grado AS grado,
                                r.rec_catgr_id AS grado_id,
                                r.rec_catmat_id AS materia_id,
                                mt.cat_materia AS materia,
                                r.rec_archivo As archivo,
                                r.rec_libros AS libros,
                                r.rec_alumno AS alumno,
                                r.rec_profesor AS profesor,
                                r.rec_director AS director,
                                r.rec_padre AS padre,
                                r.rec_img AS flag_imagen,
                                r.ext_imagen_unidad AS imagen
                            FROM
                                rec_rec_recursos AS r
                                INNER JOIN rec_tiprec_tiporecurso AS tr ON r.rec_tiprec_id = tr.id
                                INNER JOIN cat_grados AS gr ON r.rec_catgr_id = gr.id
                                INNER JOIN cat_materias AS mt ON r.rec_catmat_id = mt.id
                            ' . $condicion . ' ORDER BY gr.id ASC;');


            return view('alumno.mostrarRecursos')->with('archivos', $recursos);
        } else {
            return View('recursos.sin_recursos');
        }
    }



    public function  consultarExtencion($grado_id, $materia_id, $materia)
    {

        $temas =  DB::select('SELECT DISTINCT
        ext_cat_unidad_id As unidad_id
      FROM
        rec_ext_extension
      WHERE ext_cat_grado_id =  ' . $grado_id . ' AND ext_cat_materia_id = ' . $materia_id . ' ORDER BY unidad_id ASC;');
        return View("alumno.mostrarExtencion")
            ->with('materia', $materia)
            ->with('grado_id', $grado_id)
            ->with('materia_id', $materia_id)
            ->with('temas', $temas);
    }
    public function inicio($id)
    {


        $alumno = Alumno::where('ins_usu_id', $id)->first();
        $materias = DB::table('inst_mat_materias AS m')
            ->select('m.id AS materia_id', 'cm.cat_materia AS materia', 'cm.id AS cat_materia_id')
            ->join('cat_materias AS cm', 'm.mat_cat_id', '=', 'cm.id')
            ->where('m.mat_gra_id', '=', $alumno->ins_grado_id)
            ->groupBy('cm.cat_materia', 'm.id', 'cm.id')
            ->get();
        $condicion = 'WHERE';
        if (!empty($materias)) {
            foreach ($materias as $key => $value) {
                if ($key == 0) {
                    $condicion = $condicion . ' p.port_materia_id = ' . $value->cat_materia_id . ' AND (p.port_grado_id = ' . $alumno->ins_grado_id . ')';
                } else {
                    $condicion = $condicion . ' OR p.port_materia_id = ' . $value->cat_materia_id . ' AND (p.port_grado_id = ' . $alumno->ins_grado_id . ')';
                }
            }
        }
        $portadas =  DB::select("SELECT DISTINCT
                           p.port_imagen AS imagen,
                           p.port_portada AS portada,
                           gr.cat_grado AS grado,
                           mt.cat_materia As materia,
                           mt.cat_color AS color,
                           p.port_grado_id AS grado_id,
                           p.port_materia_id AS materia_id
                       FROM
                           port_portadas as p
                       INNER JOIN cat_grados As gr ON p.port_grado_id = gr.id
                       INNER JOIN cat_materias AS mt ON p.port_materia_id = mt.id
                       $condicion;");



        $img = DatosUsuario::select('i.ins_nombre as inst', 'i.inst_logo as img')
            ->from('usu_usuario as u')
            ->join('inst_institucion as i', 'i.id', '=', 'u.usu_inst_id')
            ->where('u.id', $id)
            ->first();


  

        return View('alumno.inicio')->with('portadas', $portadas)
            ->with('inst', $img->inst)
            ->with('img', $img->img)
            ->with('id', $id);
    }

    //Consulta ajax 


    public function temas(Request $request)
    {
        if ($request->ajax()) {
            $grado_id = $request->grado_id;
            $materia_id = $request->materia_id;
            $unidad_id = $request->unidad_id;
            $temas = DB::table('rec_ext_extension')
                ->select('id AS id_recurso', 'ext_cat_unidad_id AS unidad_id', 'ext_tema AS tema')
                ->where('ext_cat_grado_id', $grado_id)
                ->where('ext_cat_materia_id', $materia_id)
                ->where('ext_cat_unidad_id', $unidad_id)
                ->get();
            return response()->json($temas);
        }
    }

    public function mostrarTema(Request $request)
    {
        if ($request->ajax()) {

            $tema_id = $request->input('tema_id');
            $tema = DB::table('rec_ext_extension')
                ->select('ext_contenido AS contenido')
                ->where('id', $tema_id)
                ->first();
            return response()->json($tema);
        }
    }

    public function mostraArchivos(Request $request)
    {
        if ($request->ajax()) {
            $tema_id = $request->input('tema_id');
            $archivos = DB::table('arcext_archivos')
                ->select(
                    'id AS archivo_id',
                    'arcext_ext_id AS recurso_id',
                    'arcext_nombre AS nombre_archivo',
                    'arcext_archivo AS archivo',
                    'arcext_extension AS extension',
                    'arcext_mime AS mime',
                    'arcext_tamano AS tam'
                )
                ->where('arcext_ext_id', $tema_id)
                ->get();

            return response()->json($archivos);
        }
    }
}
