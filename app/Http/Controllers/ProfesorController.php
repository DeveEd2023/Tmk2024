<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Stmt\Return_;

class ProfesorController extends Controller
{


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
        return view('profesor.verFormacionP')->with('formacion', $formacion)->with('formacion_id', $id);
    }
    public function formacionDocente()
    {

        $publicaciones = DB::table('forc_formacioncontinua AS f')
            ->select(
                'f.id AS id',
                'f.forc_titulo As titulo',
                'f.forc_descripcion AS descripcion',
                'f.forc_imagen AS imagen'
            )
            ->get();
        return view('profesor.profesorFormacionDocente')->with('publicaciones', $publicaciones);
    }


    public function planificacionArchivos()
    {
        if (request()->ajax()) {
            $gradoId = request()->input('grado_id');
            $materiaId = request()->input('materia_id');
            $unidadId = request()->input('unidad_id');

            $planificacion = DB::table('planificacion')
                ->select('id AS planificacion_id')
                ->where('plan_cat_grado_id', $gradoId)
                ->where('plan_cat_materia_id', $materiaId)
                ->where('plan_cat_unidad_id', $unidadId)
                ->first();

            if ($planificacion) {
                $archivos = DB::table('planificacion_archivos')
                    ->select('id AS archivo_id', 'plan_id AS recurso_id', 'plan_arc_nombre AS nombre_archivo', 'plan_arc_archivo AS archivo', 'plan_arc_extension AS extension', 'plan_arc_mime AS mime', 'plan_arc_tamano AS tam')
                    ->where('plan_id', $planificacion->planificacion_id)
                    ->get();

                return response()->json($archivos);
            } else {
                return response()->json([], 404); // No se encontró la planificación
            }
        }
    }



    public function mostrarRecursoPlanificacion($grado_id, $materia_id, $materia)
    {
        $temas =  DB::select('SELECT DISTINCT
        plan_cat_unidad_id As unidad_id
      FROM
        planificacion
      WHERE plan_cat_grado_id =  ' . $grado_id . ' AND plan_cat_materia_id = ' . $materia_id . ' ORDER BY unidad_id ASC;');
        return View("profesor.mostrarRecursosPlanificaciones")
            ->with('materia', $materia)
            ->with('grado_id', $grado_id)
            ->with('materia_id', $materia_id)
            ->with('temas', $temas);
    }

    public function verPlanificacion($id)
    {
        $encargado = DB::table('profesor_seccion')->where('enc_usu_id', $id)->first();
        $especial = DB::table('profesor_materia')->where('pm_usu_id', $id)->first();

        if ($encargado) {
            $grados = DB::table('profesor_seccion AS ps')
                ->select('igr.id AS grado_id', 'catg.cat_grado AS grado', 'ps.enc_encargado as encargado', 'catg.id AS cat_grado_id')
                ->join('inst_gra_grados AS igr', 'ps.enc_gr_id', '=', 'igr.id')
                ->join('cat_grados AS catg', 'igr.gra_grado_id', '=', 'catg.id')
                ->where('ps.enc_usu_id', '=', $id)
                ->groupBy('igr.id', 'catg.cat_grado', 'ps.enc_encargado', 'catg.id')
                ->get();

            $materias = DB::table('inst_mat_materias AS m')
                ->select('m.id AS materia_id', 'cm.cat_materia AS materia', 'cm.id AS cat_materia_id')
                ->join('cat_materias AS cm', 'm.mat_cat_id', '=', 'cm.id')
                ->where('m.mat_gra_id', '=', $grados[0]->grado_id)
                ->groupBy('cm.cat_materia', 'm.id', 'cm.id')
                ->get();

            $condicion = '';
            foreach ($materias as $key => $value) {
                if ($key == 0) {
                    $condicion = 'WHERE p.port_materia_id = ' . $value->cat_materia_id . ' AND (p.port_grado_id = ' . $grados[0]->cat_grado_id . ')';
                } else {
                    $condicion .= ' OR p.port_materia_id = ' . $value->cat_materia_id . ' AND (p.port_grado_id = ' . $grados[0]->cat_grado_id . ')';
                }
            }

            $portadas =  DB::select("SELECT DISTINCT
                                          p.port_imagen AS imagen,
                                          p.port_portada AS portada,
                                          gr.cat_grado AS grado,
                                          gr.cat_abreviacion AS numero_grado,
                                          mt.cat_materia As materia,
                                          mt.cat_color AS color,
                                          p.port_grado_id AS grado_id,
                                          p.port_materia_id AS materia_id
                                      FROM
                                          port_portadas as p
                                      INNER JOIN cat_grados As gr ON p.port_grado_id = gr.id
                                      INNER JOIN cat_materias AS mt ON p.port_materia_id = mt.id
                                      $condicion;");
            if (!empty($portadas)) {
                return View('profesor.planificacion')->with('portadas', $portadas);
            } else {
                return View('extension.sin_portadas');
            }
        } elseif ($especial) {
            $materias = DB::table('profesor_materia AS pm')
                ->select('cg.id AS grado_id', 'cm.cat_materia AS materia', 'cm.id AS materia_id')
                ->join('inst_gra_grados AS g', 'pm.pm_gr_id', '=', 'g.id')
                ->join('cat_grados AS cg', 'g.gra_grado_id', '=', 'cg.id')
                ->join('inst_mat_materias AS m', 'pm.pm_mat_id', '=', 'm.id')
                ->join('cat_materias AS cm', 'm.mat_cat_id', '=', 'cm.id')
                ->where('pm.pm_usu_id', '=', $id)
                ->get();

            $where = '';
            if (!empty($materias)) {
                foreach ($materias as $key => $value) {
                    if ($key == 0) {
                        $where = 'WHERE p.port_materia_id = ' . $value->materia_id . ' AND (p.port_grado_id = ' . $value->grado_id . ')';
                    } else {
                        $where .= ' OR p.port_materia_id = ' . $value->materia_id . ' AND (p.port_grado_id = ' . $value->grado_id . ')';
                    }
                }
                $portadas =  DB::select('SELECT DISTINCT
                                              p.port_imagen AS imagen,
                                              p.port_portada AS portada,
                                              gr.cat_grado AS grado,
                                              gr.cat_abreviacion AS numero_grado,
                                              mt.cat_materia As materia,
                                              mt.cat_color AS color,
                                              p.port_grado_id AS grado_id,
                                              p.port_materia_id AS materia_id
                                          FROM
                                              port_portadas as p
                                          INNER JOIN cat_grados As gr ON p.port_grado_id = gr.id
                                          INNER JOIN cat_materias AS mt ON p.port_materia_id = mt.id
                                          ' . $where . ';');
            } else {
                return View('extension.sin_portadas');
            }

            if (!empty($portadas)) {
                return View('profesor.planificacion')->with('portadas', $portadas);
            } else {
                return View('extension.sin_portadas');
            }
        } else {
            return View('extension.sin_portadas');
        }
    }


    public function  consultarExtencion($grado_id, $materia_id, $materia)
    {

        $temas =  DB::select('SELECT DISTINCT
        ext_cat_unidad_id As unidad_id
      FROM
        rec_ext_extension
      WHERE ext_cat_grado_id =  ' . $grado_id . ' AND ext_cat_materia_id = ' . $materia_id . ' ORDER BY unidad_id ASC;');
        return View("profesor.mostrarExtencion")
            ->with('materia', $materia)
            ->with('grado_id', $grado_id)
            ->with('materia_id', $materia_id)
            ->with('temas', $temas);
    }

    public function mostrarListaExtenciones($id)
    {
        $encargado = DB::table('profesor_seccion')->where('enc_usu_id', $id)->first();
        $especial = DB::table('profesor_materia')->where('pm_usu_id', $id)->first();

        if ($encargado) {
            $grados = DB::table('profesor_seccion AS ps')
                ->select('igr.id AS grado_id', 'catg.cat_grado AS grado', 'ps.enc_encargado as encargado', 'catg.id AS cat_grado_id')
                ->join('inst_gra_grados AS igr', 'ps.enc_gr_id', '=', 'igr.id')
                ->join('cat_grados AS catg', 'igr.gra_grado_id', '=', 'catg.id')
                ->where('ps.enc_usu_id', '=', $id)
                ->groupBy('igr.id', 'catg.cat_grado', 'ps.enc_encargado', 'catg.id')
                ->get();

            $materias = DB::table('inst_mat_materias AS m')
                ->select('m.id AS materia_id', 'cm.cat_materia AS materia', 'cm.id AS cat_materia_id')
                ->join('cat_materias AS cm', 'm.mat_cat_id', '=', 'cm.id')
                ->where('m.mat_gra_id', '=', $grados[0]->grado_id)
                ->groupBy('cm.cat_materia', 'm.id', 'cm.id')
                ->get();
            $condicion = 'WHERE';
            if (!empty($materias)) {
                foreach ($materias as $key => $value) {
                    if ($key == 0) {
                        $condicion = $condicion . ' p.port_materia_id = ' . $value->cat_materia_id . ' AND (p.port_grado_id = ' . $grados[0]->cat_grado_id . ')';
                    } else {
                        $condicion = $condicion . ' OR p.port_materia_id = ' . $value->cat_materia_id . ' AND (p.port_grado_id = ' . $grados[0]->cat_grado_id . ')';
                    }
                }
            }
            $portadas =  DB::select("SELECT DISTINCT
                                          p.port_imagen AS imagen,
                                          p.port_portada AS portada,
                                          gr.cat_grado AS grado,
                                          gr.cat_abreviacion AS numero_grado,
                                          mt.cat_materia As materia,
                                          mt.cat_color AS color,
                                          p.port_grado_id AS grado_id,
                                          p.port_materia_id AS materia_id
                                      FROM
                                          port_portadas as p
                                      INNER JOIN cat_grados As gr ON p.port_grado_id = gr.id
                                      INNER JOIN cat_materias AS mt ON p.port_materia_id = mt.id
                                      $condicion;");
            if (!empty($portadas)) {

                //  dd($portadas);
                return View('profesor.portadas')->with('portadas', $portadas);
            } else {
                return View('extension.sin_portadas');
            }
        } else if ($especial) {
            $materias = DB::table('profesor_materia AS pm')
                ->select('cg.id AS grado_id', 'cm.cat_materia AS materia', 'cm.id AS materia_id')
                ->join('inst_gra_grados AS g', 'pm.pm_gr_id', '=', 'g.id')
                ->join('cat_grados AS cg', 'g.gra_grado_id', '=', 'cg.id')
                ->join('inst_mat_materias AS m', 'pm.pm_mat_id', '=', 'm.id')
                ->join('cat_materias AS cm', 'm.mat_cat_id', '=', 'cm.id')

                ->where('pm.pm_usu_id', '=', $id)->get();
            $where = 'WHERE';
            if (!empty($materias)) {
                foreach ($materias as $key => $value) {
                    if ($key == 0) {
                        $where = $where . ' p.port_materia_id = ' . $value->materia_id . ' AND (p.port_grado_id = ' . $value->grado_id . ')';
                    } else {
                        $where = $where . ' OR p.port_materia_id = ' . $value->materia_id . ' AND (p.port_grado_id = ' . $value->grado_id . ')';
                    }
                }
                $portadas =  DB::select('SELECT DISTINCT
                                          p.port_imagen AS imagen,
                                          p.port_portada AS portada,
                                          gr.cat_grado AS grado,
                                          gr.cat_abreviacion AS numero_grado,
                                          mt.cat_materia As materia,
                                          mt.cat_color AS color,
                                          p.port_grado_id AS grado_id,
                                          p.port_materia_id AS materia_id
                                      FROM
                                          port_portadas as p
                                      INNER JOIN cat_grados As gr ON p.port_grado_id = gr.id
                                      INNER JOIN cat_materias AS mt ON p.port_materia_id = mt.id
                                        ' . $where . ';');
                // print_r($portadas);
            } else {
                return View('extension.sin_portadas');
            }

            if (!empty($portadas)) {
                return View('profesor.portadas')->with('portadas', $portadas);
            } else {
                return View('extension.sin_portadas');
            }
        } else {
            return View('extension.sin_portadas');
        }
    }

    public function mostrarRecurso($id)
    {
        $encargado = DB::table('profesor_seccion')->where('enc_usu_id', $id)->first();
        $especial = DB::table('profesor_materia')->where('pm_usu_id', $id)->first();

        if ($encargado) {
            $grados = DB::table('profesor_seccion AS ps')
                ->select('igr.id AS grado_id', 'catg.cat_grado AS grado', 'ps.enc_encargado as encargado', 'catg.id AS cat_grado_id')
                ->join('inst_gra_grados AS igr', 'ps.enc_gr_id', '=', 'igr.id')
                ->join('cat_grados AS catg', 'igr.gra_grado_id', '=', 'catg.id')
                ->where('ps.enc_usu_id', '=', $id)
                ->groupBy('igr.id', 'catg.cat_grado', 'ps.enc_encargado', 'catg.id')
                ->get();
                
            //Siendo orientador de un solo grado
            $materias = DB::table('inst_mat_materias AS m')
                ->select('m.id AS materia_id', 'cm.cat_materia AS materia', 'cm.id AS cat_materia_id')
                ->join('cat_materias AS cm', 'm.mat_cat_id', '=', 'cm.id')
                ->where('m.mat_gra_id', '=', $grados[0]->grado_id)
                ->groupBy('m.id', 'cm.cat_materia', 'cm.id')
                ->get();
                
            $condicion = 'WHERE r.rec_profesor = 1';
            
            if (!empty($materias)) {
                foreach ($materias as $key => $value) {
                    if ($key == 0) {
                        $condicion = $condicion . ' AND r.rec_catmat_id = ' . $value->cat_materia_id . ' AND (r.rec_catgr_id = ' . $grados[0]->cat_grado_id . ')';
                    } else {
                        $condicion = $condicion . ' OR r.rec_catmat_id = ' . $value->cat_materia_id . ' AND (r.rec_catgr_id = ' . $grados[0]->cat_grado_id . ')';
                    }
                }
            }
            $recursos =  DB::select("SELECT
                                    r.id AS id,
                                    r.rec_nombre AS nombre,
                                    r.rec_descripcion AS descripcion,
                                    tr.tiprec_nombre AS tipo,
                            
                                    r.rec_catgr_id AS grado_id,
                                    r.rec_catmat_id AS materia_id,
                                    mt.cat_materia AS materia,
                                    r.rec_archivo As archivo,
                                    r.rec_libros AS libros,
                                 
                                    r.rec_img AS flag_imagen,
                                    r.ext_imagen_unidad AS imagen
                                FROM
                                    rec_rec_recursos AS r
                                    INNER JOIN rec_tiprec_tiporecurso AS tr ON r.rec_tiprec_id = tr.id
                                    INNER JOIN cat_grados AS gr ON r.rec_catgr_id = gr.id
                                    INNER JOIN cat_materias AS mt ON r.rec_catmat_id = mt.id
                         $condicion
                                ORDER BY gr.id ASC;");
                               //dd($recursos);
            if ($recursos) {
                return view('profesor.mostrarRecursos')->with('archivos', $recursos);
            } else {
                Session::flash('type', 'success');
                Session::flash('message', 'No tiene asignado ningun recurso');
                return redirect()->back();
            }
        } elseif ($especial) {
            $materias = DB::table('profesor_materia AS pm')
                ->select('cg.id AS grado_id', 'cm.cat_materia AS materia', 'cm.id AS materia_id')
                ->join('inst_gra_grados AS g', 'pm.pm_gr_id', '=', 'g.id')
                ->join('cat_grados AS cg', 'g.gra_grado_id', '=', 'cg.id')
                ->join('inst_mat_materias AS m', 'pm.pm_mat_id', '=', 'm.id')
                ->join('cat_materias AS cm', 'm.mat_cat_id', '=', 'cm.id')
                ->where('pm.pm_usu_id', '=', $id)->get();
            $where = 'WHERE';
            $grados = count($materias);
            if (!empty($materias)) {
                foreach ($materias as $key => $value) {
                    if ($key == 0) {
                        $where = $where . ' r.rec_catmat_id = ' . $value->materia_id . ' AND (r.rec_catgr_id = ' . $value->grado_id . ')';
                    } else {
                        $where = $where . ' OR r.rec_catmat_id = ' . $value->materia_id . ' AND (r.rec_catgr_id = ' . $value->grado_id . ')';
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
                                    ' . $where . ' ORDER BY gr.id ASC;');


                if ($recursos) {
                    return view('profesor.mostrarRecursos')->with('archivos', $recursos);
                } else {
                    Session::flash('type', 'success');
                    Session::flash('message', 'No tiene asignado ningun recurso');
                    return redirect()->back();
                }
            } else {
                Session::flash('type', 'success');
                Session::flash('message', 'Profesor no asignado');
                return redirect()->back();
            }
        }
    }

    public function verLibreta($id, $grado, $materia, $archivo)
    {
        return view('profesor.verLibreta')->with('id', $id)->with('grado', $grado)->with('materia', $materia)->with('archivo', $archivo);
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
