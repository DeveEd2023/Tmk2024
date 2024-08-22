<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Ciclo;
use App\Models\DatosUsuario;
use App\Models\Grado;
use App\Models\Institucion;
use App\Models\Materia;
use App\Models\ProfesorMateria;
use App\Models\ProfesorSeccion;
use App\Models\Roles;
use App\Models\Seccion;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;


class AdminController extends Controller
{

    //------------------------------------------------------------------- Instituciones -------------------------------------------------------------------

    public function listaInstitucion()
    {
        $instituciones = Institucion::orderBy('id', 'ASC')->get();
        $ciclo = Ciclo::all();
        return view('administrador.institucion')
            ->with('instituciones', $instituciones)
            ->with('ciclo', $ciclo);
    }

    public function nuevaInstitucion(Request $request)
    {
        $code = Institucion::where('ins_codigo', $request->codigo)->first();



        Validator::make(
            $request->all(),
            Institucion::ruleCrear()
        )->addCustomAttributes(
            Institucion::attrCrear()
        )->validate();

        if (!$code) {
            $logo = $request->logo;
            $institucion = new Institucion;
            $institucion->ins_nombre = $request->nombre;
            $institucion->ins_codigo = $request->codigo;
            $institucion->ins_encargado = $request->encargado;
            $institucion->ins_email_encargado = $request->correoEn;
            $institucion->ins_telefono = $request->telefono;
            $institucion->ins_telefono_encargado = $request->telefonoEn;
            $institucion->url_sistema_notas = 'https://sistema-notas-liceo-cristiano-rvdo-juan-bueno.portaledisalonline.com/admin/';
            $institucion->inst_ciclo_id = $request->ciclo;
            if ($logo != null) {
                $img = file_get_contents($logo);
                $imagen = base64_encode($img);
                $imagen = "data:image/jpg;base64," . $imagen;
                $institucion->inst_imagen = 1;
                $institucion->inst_logo = $imagen;
            }
            $institucion->save();

            $grados = DB::table('cat_grados')
                ->select('id')
                ->get();

            foreach ($grados as $key => $value) {
                $grado = new Grado;
                $grado->gra_grado_id = $value->id;
                $grado->gra_inst_id = $institucion->id;
                $grado->save();
            }
            Session::flash('type', 'success');
            Session::flash('message', ' Institución y Grados  registrados correctamente');
            return redirect()->back();
        } else {
            Session::flash('type', 'danger');
            Session::flash('message', 'Código de infraestructura ya registrado');
            return redirect()->back();
        }
    }

    public function nuevaImagen(Request $request)
    {
        $logo = $request->logo;
        $institucion_id = $request->institucion_id;
        if ($logo != null) {
            $img = file_get_contents($logo);
            $imagen = base64_encode($img);
            $imagen = "data:image/jpg;base64," . $imagen;
            DB::table('inst_institucion')->where('id', $institucion_id)
                ->update(array('inst_imagen' => 1, 'inst_logo' => $imagen));
        }
        Session::flash('type', 'success');
        Session::flash('message', 'Logo Cambiado con exito');
        return  redirect()->back();
    }

    public function buscarInstitucion(Request $request)
    {
        $institucion = Institucion::where('id', $request->id)
            ->first();
        return json_encode($institucion);
    }

    public function editarInstitucion(Request $request)
    {
        Validator::make(
            $request->all(),
            Institucion::ruleEd()
        )->addCustomAttributes(
            Institucion::attrEd()
        )->validate();

        $institucion = Institucion::where('id', $request->id)->first();
        $logo = $request->logo;
        $institucion->ins_nombre = $request->nombre;
        $institucion->ins_codigo = $request->codigo;
        $institucion->ins_encargado = $request->encargado;
        $institucion->ins_email_encargado = $request->correoEn;
        $institucion->ins_telefono = $request->telefono;
        $institucion->ins_telefono_encargado = $request->telefonoEn;

        if ($logo != null) {
            $img = file_get_contents($logo);
            $imagen = base64_encode($img);
            $imagen = "data:image/jpg;base64," . $imagen;
            $institucion->inst_imagen = 1;
            $institucion->inst_logo = $imagen;
        }
        $institucion->save();
        Session::flash('type', 'warning');
        Session::flash('message', 'Institución actualizada correctamente ');
        return redirect()->back();
    }

    public function eliminarInstitucion($id)
    {
        $institucion = Institucion::find($id);

        if ($institucion) {
            $institucion->delete();
            Session::flash('type', 'danger');
            Session::flash('message', 'Institución Eliminada correctamente ');
            return redirect()->back();
        }
        Session::flash('type', 'warning');
        Session::flash('message', 'Institución no encotrada ');
        return redirect()->back();
    }

    //------------------------------------------------------------------- Usuarios -------------------------------------------------------------------
    public function listaUsuario()
    {
        $usuarios = Usuario::select(
            'usu.id as id',
            'usu.usu_rol_id as rol_id',
            'r.rol_nombre as rol',
            'usu.usu_inst_id as institucion_id',
            'usu.usu_nombres as nombres',
            'usu.usu_apellidos as apellidos',
            'usu.usu_contra_plana AS plano',
            'usu.usu_estado as estado',
            'l.log_nombre as usuario',
            'i.ins_nombre as institucion',
            'i.inst_estado as estado_institucion',
            'usu.usu_vigencia_inicio as fecha'
        )
            ->from('usu_usuario as usu')
            ->join('login_usuario as l', 'l.log_usu_id', '=', 'usu.id')
            ->join('inst_institucion as i', 'usu.usu_inst_id', '=', 'i.id')
            ->join('rol_roles as r', 'usu.usu_rol_id', '=', 'r.id')
            ->orderBy('usu.id', 'ASC')
            ->get();

        $rol = Roles::all();
        $instituciones = Institucion::orderBy('created_at', 'asc')->get();

        return view('administrador.usuarios')
            ->with('usuarios', $usuarios)
            ->with('rol', $rol)
            ->with('institucion', $instituciones);
    }

    public function nuevoUsuario(Request $request)
    {
        Validator::make(
            $request->all(),
            DatosUsuario::ruleCrear()
        )->addCustomAttributes(
            DatosUsuario::attrCrear()
        )->validate();


       $log = Usuario::select('log_nombre')->where('log_nombre',$request->usuario)->first();
       
      // dd($log);
       
       
       if(!$log){
        $anio_actual = date('Y-m-d');
        $usuario = new DatosUsuario;
        $usuario->usu_rol_id = $request->rol;
        $usuario->usu_inst_id = $request->institucion;
        $usuario->usu_nombres = $request->nombre;
        $usuario->usu_apellidos = $request->apellido;
        $usuario->usu_telefono = $request->telefono;
        $usuario->usu_email = $request->correo;
        $usuario->usu_vigencia_inicio = "$anio_actual";
        $usuario->usu_vigencia_fin = date('Y-m-d', strtotime("+1 year", strtotime($usuario->usu_vigencia_inicio)));
        $usuario->usu_contra_plana = $request->contraseña;
        $usuario->save();

        $user = new Usuario;
        $user->log_usu_id = $usuario->id;
        $user->log_nombre = $request->usuario;
        $user->password = Hash::make($request->contraseña);;
        $user->save();
        Session::flash('type', 'success');
        Session::flash('message', 'usuario registrado correctamente');
       }else{
          Session::flash('type', 'danger');
        Session::flash('message', 'Nombre de usuario ya registrado');  
           
       }
       
        return redirect()->back();
    }

    public function buscarUsuario(Request $request)
    {

        $user = Usuario::select(
            'usu.id as id',
            'usu.usu_rol_id as rol_id',
            'r.rol_nombre as rol',
            'usu.usu_inst_id as institucion_id',
            'usu.usu_nombres as nombre',
            'usu.usu_apellidos as apellido',
            'usu.usu_contra_plana AS plano',
            'usu.usu_telefono AS telefono',
            'usu.usu_email AS correo',
            'l.log_nombre as user',
            'i.ins_nombre as institucion',
        )
            ->from('usu_usuario as usu')
            ->join('login_usuario as l', 'l.log_usu_id', '=', 'usu.id')
            ->join('inst_institucion as i', 'usu.usu_inst_id', '=', 'i.id')
            ->join('rol_roles as r', 'usu.usu_rol_id', '=', 'r.id')
            ->where('usu.id', $request->id)
            ->first();


        return json_encode($user);
    }

    public function editarUsuario(Request $request)
    {
        $usuario = DatosUsuario::where('id', $request->id)->first();

        Validator::make(
            $request->all(),
            DatosUsuario::ruleUpdate()
        )->addCustomAttributes(
            DatosUsuario::attrUpdate()
        )->validate();
        if ($request->id) {
            if ($request->institucion) {
                $usuario->usu_inst_id = $request->institucion;
            }
            $usuario->usu_nombres = $request->Unombre;
            $usuario->usu_apellidos = $request->Uapellido;
            $usuario->usu_telefono = $request->Utelefono;
            $usuario->usu_email = $request->ucorreo;
            if ($request->contraseña) {
                $usuario->usu_contra_plana = $request->contraseña;
            }
            $usuario->save();
            $user = Usuario::where('id', $request->id)->first();
            $user->log_usu_id = $usuario->id;
            $user->log_nombre = $request->Uusuario;
            if ($request->contraseña) {
                $user->password = Hash::make($request->contraseña);
            }
            $user->save();
            Session::flash('type', 'warning');
            Session::flash('message', 'Actualizado correctamente');
            return redirect()->back();
        } else {
            return redirect()->back()->withErrors('Error: no se pudo realizar la acción.');
        }
    }

    public function eliminarUsuario($id)
    {

        $user = Usuario::find($id);
        $datos = DatosUsuario::find($id);
        if ($user && $datos) {

            $datos->delete();
            $user->delete();
            Session::flash('type', 'success');
            Session::flash('message', 'Usuario eliminado correctamente');
            return redirect()->back();
        }
        return redirect()->back()->withErrors('Error: no se pudo realizar la acción.');
    }

    //------------------------------------------------------------------- grado -------------------------------------------------------------------

    public function listaGrado()
    {
        $grado = Grado::select(
            'g.id AS id',
            'g.gra_estado AS estado',
            'cg.cat_grado AS grado',
            'i.ins_nombre AS institucion'
        )
            ->from('inst_gra_grados AS g')
            ->join('cat_grados AS cg', 'g.gra_grado_id', '=', 'cg.id')
            ->join('inst_institucion AS i', 'g.gra_inst_id', '=', 'i.id')
            ->orderBy('g.created_at', 'ASC')
            ->get();

        $institucion = Institucion::select(
            'i.id as id',
            'i.ins_nombre as institucion'
        )
            ->from('inst_institucion as i')
            ->orderBy('i.created_at', 'ASC')
            ->get();
        $g  = DB::table('cat_grados')->get();

        return view('administrador.grado')
            ->with('grados', $grado)
            ->with('institucion', $institucion)
            ->with('g', $g);
    }

    public function nuevoGrado(Request $request)
    {

        Validator::make(
            $request->all(),
            Grado::ruleCrear()
        )->addCustomAttributes(
            Grado::attrCrear()
        )->validate();

        $asignado = Grado::where('gra_grado_id', $request->grado)
            ->where('gra_inst_id', $request->institucion)->first();

        if ($asignado) {
            Session::flash('type', 'danger');
            Session::flash('message', 'Grado ya registrado en la institución');
            return redirect()->back();
        } else {
            $grado = new Grado;
            $grado->gra_grado_id = $request->grado;
            $grado->gra_inst_id = $request->institucion;
            $grado->save();
            Session::flash('type', 'success');
            Session::flash('message', 'Grado asignado correctamete');
            return redirect()->back();
        }
    }
    public function eliminarGrado($id)
    {
        $grado = Grado::where('id', $id)->first();

        if ($grado) {
            $grado->delete();
            Session::flash('type', 'danger');
            Session::flash('message', 'Grado eliminado correctamente');
            return redirect()->back();
        }
        return redirect()->back()->withErrors('Error: no se pudo realizar la acción.');
    }

    //------------------------------------------------------------------- secciones -------------------------------------------------------------------

    public function listaSeccion()
    {
        $seccion = Seccion::select(
            's.id AS seccion_id',
            's.sec_estado AS estado',
            'cs.cat_seccion AS seccion',
            'g.gra_grado_id AS grado_id',
            'cg.cat_grado AS grado',
            'i.ins_nombre AS institucion',
            't.cat_turno AS turno'
        )
            ->from('inst_sec_secciones AS s')
            ->join('cat_secciones AS cs', 's.sec_cat_id', '=', 'cs.id')
            ->join('inst_gra_grados AS g', 's.sec_grado_id', '=', 'g.id')
            ->join('cat_grados AS cg', 'g.gra_grado_id', '=', 'cg.id')
            ->join('inst_institucion AS i', 's.sec_inst_id', '=', 'i.id')
            ->join('cat_turnos AS t', 's.sec_turno_id', '=', 't.id')
            ->orderBy('s.id', 'ASC')
            ->get();

        $s  = DB::table('cat_secciones')->get();
        $t  = DB::table('cat_turnos')->get();


        $institucion = Institucion::select(
            'i.id as id',
            'i.ins_nombre as institucion'
        )
            ->from('inst_institucion as i')
            ->orderBy('i.ins_nombre', 'ASC')
            ->get();

        return view('administrador.seccion')
            ->with('secciones', $seccion)

            ->with('lseccion', $s)
            ->with('turno', $t)
            ->with('institucion', $institucion);
    }

    public function nuevaSeccion(Request $request)
    {

        Validator::make(
            $request->all(),
            Seccion::ruleCrear()
        )->addCustomAttributes(
            Seccion::attrCrear()
        )->validate();

        $datos = Seccion::where('sec_inst_id', $request->institucion)
            ->where('sec_grado_id', $request->grado)
            ->where('sec_cat_id', $request->seccion)
            ->where('sec_turno_id', $request->turno)
            ->first();
        if (!$datos) {
            $seccion = new Seccion;
            $seccion->sec_cat_id = $request->seccion;
            $seccion->sec_inst_id = $request->institucion;
            $seccion->sec_grado_id = $request->grado;
            $seccion->sec_turno_id = $request->turno;
            $seccion->save();
            Session::flash('type', 'success');
            Session::flash('message', 'Sección inscrita correctamente');
            return redirect()->back();
        } else {
            Session::flash('type', 'danger');
            Session::flash('message', 'Sección ya registrada en la institución');
            return redirect()->back();
        }
    }

    public function eliminarSeccion($id)
    {
        $seccion = Seccion::where('id', $id)->first();

        if ($seccion) {
            $seccion->delete();
            Session::flash('type', 'danger');
            Session::flash('message', 'Sección eliminada correctamente');
            return redirect()->back();
        }
        Session::flash('type', 'danger');
        Session::flash('message', 'Error: no se pudo realizar la acción.');
        return redirect()->back();
    }
    //------------------------------------------------------------------- Materia -------------------------------------------------------------------
    public function listaMateria()
    {
        $materia = Materia::select(
            'm.id AS materia_id',
            'm.mat_estado AS estado',
            'cm.cat_materia AS materia',
            'g.gra_grado_id AS grado_id',
            'cg.cat_grado AS grado',
            'i.ins_nombre AS institucion',
            'm.mat_cat_id as m_id'
        )
            ->from('inst_mat_materias AS m')
            ->join('cat_materias AS cm', 'm.mat_cat_id', '=', 'cm.id')
            ->join('inst_gra_grados AS g', 'm.mat_gra_id', '=', 'g.id')
            ->join('cat_grados AS cg', 'g.gra_grado_id', '=', 'cg.id')
            ->join('inst_institucion AS i', 'm.mat_inst_id', '=', 'i.id')
            ->orderBy('m.id', 'ASC')
            ->get();


        $institucion = Institucion::select(
            'i.id as id',
            'i.ins_nombre as institucion'
        )
            ->from('inst_institucion as i')
            ->orderBy('i.ins_nombre', 'ASC')
            ->get();

        $listaMateria = DB::table('cat_materias')

            ->get();

        return view('administrador.materia')

            ->with('materias', $materia)
            ->with('institucion', $institucion)
            ->with('listaMateria', $listaMateria);
    }

    public function nuevaMateria(Request $request)
    {
        Validator::make(
            $request->all(),
            Materia::ruleCrear()
        )->addCustomAttributes(
            Materia::attrCrear()
        )->validate();
        $datos = Materia::where('mat_inst_id', $request->institucion)
            ->where('mat_cat_id', $request->materia)
            ->where('mat_gra_id', $request->grado)
            ->first();

        if (!$datos) {
            $materia = new Materia;
            $materia->mat_inst_id = $request->institucion;
            $materia->mat_cat_id = $request->materia;
            $materia->mat_gra_id = $request->grado;
            $materia->save();

            Session::flash('type', 'success');
            Session::flash('message', 'Materia asignada correctamente');
            return redirect()->back();
        }
        Session::flash('type', 'danger');
        Session::flash('message', 'Materia ya fue asignada a la institución.');
        return redirect()->back();
    }

    public function eliminarMateria($id)
    {

        $dato = Materia::where('id', $id)->first();
        if ($dato) {
            $dato->delete();
            Session::flash('type', 'danger');
            Session::flash('message', 'Materia eliminada correctamente');
            return redirect()->back();
        }
        Session::flash('type', 'danger');
        Session::flash('message', 'Error: no se pudo realizar la acción.');
        return redirect()->back();
    }

    //------------------------------------------------------------------- Profesor -------------------------------------------------------------------


    public function listaProfesor()
    {
        $profesores = ProfesorSeccion::select(
            'e.id AS encargado_id',
            'e.enc_estado AS estado',
            'e.enc_encargado AS encargado',
            'u.usu_nombres AS nombres',
            'u.usu_apellidos AS apellidos',
            'cg.cat_grado AS grado',
            'cs.cat_seccion AS seccion',
            'i.ins_nombre AS institucion',
            't.cat_turno AS turno'
        )
            ->from('profesor_seccion AS e')

            ->join('usu_usuario AS u', 'e.enc_usu_id', '=', 'u.id')
            ->join('inst_gra_grados AS g', 'e.enc_gr_id', '=', 'g.id')
            ->join('cat_grados AS cg', 'g.gra_grado_id', '=', 'cg.id')
            ->join('inst_institucion AS i', 'e.enc_inst_id', '=', 'i.id')
            ->join('inst_sec_secciones AS s', 'e.enc_sec_id', '=', 's.id')
            ->join('cat_secciones AS cs', 's.sec_cat_id', '=', 'cs.id')
            ->join('cat_turnos AS t', 's.sec_turno_id', '=', 't.id')
            ->get();

        $especialidades = ProfesorMateria::select(
            'pm.id AS profesor_id',
            'pm.pm_estado AS estado',
            'u.usu_nombres AS nombres',
            'u.usu_apellidos AS apellidos',
            'cg.cat_grado AS grado',
            'cs.cat_seccion AS seccion',
            'i.ins_nombre AS institucion',
            't.cat_turno AS turno',
            'cm.cat_materia AS materia'
        )
            ->from('profesor_materia AS pm')
            ->join('usu_usuario AS u', 'pm.pm_usu_id', '=', 'u.id')
            ->join('inst_gra_grados AS g', 'pm.pm_gr_id', '=', 'g.id')
            ->join('cat_grados AS cg', 'g.gra_grado_id', '=', 'cg.id')
            ->join('inst_institucion AS i', 'pm.pm_inst_id', '=', 'i.id')
            ->join('inst_sec_secciones AS s', 'pm.pm_sec_id', '=', 's.id')
            ->join('cat_secciones AS cs', 's.sec_cat_id', '=', 'cs.id')
            ->join('cat_turnos AS t', 's.sec_turno_id', '=', 't.id')
            ->join('inst_mat_materias AS m', 'pm.pm_mat_id', '=', 'm.id')
            ->join('cat_materias AS cm', 'm.mat_cat_id', '=', 'cm.id')
            ->get();


        $institucion = Institucion::select(
            'i.id as id',
            'i.ins_nombre as institucion'
        )
            ->from('inst_institucion as i')
            ->orderBy('i.ins_nombre', 'ASC')
            ->get();

        return view('administrador.profesor')
            ->with('profesores', $profesores)
            ->with('especialidades', $especialidades)
            ->with('institucion', $institucion);
    }



    //-------------------------------------------------- Profesor encargado 


    public function nuevoEn()
    {
        $institucion = Institucion::select(
            'i.id as id',
            'i.ins_nombre as institucion'
        )
            ->from('inst_institucion as i')
            ->orderBy('i.ins_nombre', 'ASC')
            ->get();


        return view('administrador.nuevoEncargado')
            ->with('institucion', $institucion);
    }



    public function crearEncargado(Request $request)
    {

        Validator::make(
            $request->all(),
            ProfesorSeccion::ruleCrear()
        )->addCustomAttributes(
            ProfesorSeccion::attrCrear()
        )->validate();

        $asignado_seccion = ProfesorSeccion::select('id')
            ->where('enc_inst_id', $request->institucion)
            ->where('enc_gr_id',  $request->grado)
            ->where('enc_sec_id', $request->seccion)
            ->get();

        $asignado_materia = ProfesorMateria::select('id')
            ->where('pm_inst_id', $request->institucion)
            ->where('pm_gr_id', $request->grado)
            ->where('pm_sec_id', $request->seccion)
            ->where('pm_usu_id',  $request->profesor)->get();

        if (count($asignado_seccion) > 0 || count($asignado_materia) > 0) {
            if (count($asignado_seccion) > 0) {
                Session::flash('type', 'danger');
                Session::flash('message', 'No se pudo asignar el profesor, la sección ya tiene encargado!');
                return redirect('admin/profesor');
            } else {
                Session::flash('type', 'danger');
                Session::flash('message', 'No se pudo asignar el profesor, tiene una materia de especialidad asignada en la sección seleccionada!');
                return redirect('admin/profesor');
            }
        } else {
            $encargado = 1;
            $asignar = new Profesorseccion;
            $asignar->enc_usu_id = $request->profesor;
            $asignar->enc_sec_id = $request->seccion;
            $asignar->enc_gr_id =  $request->grado;
            $asignar->enc_inst_id = $request->institucion;
            $asignar->enc_encargado = $encargado;
            $asignar->save();

            Session::flash('type', 'success');
            Session::flash('message', 'Profesor asignado correctamente!');
            return redirect('admin/profesor');
        }
    }
    public function eliminarEncargado($id)
    {
        $dato = ProfesorSeccion::where('id', $id)->first();


        if ($dato) {
            $dato->delete();
            Session::flash('type', 'danger');
            Session::flash('message', 'Profesor encargado eliminado correctamente');
            return redirect()->back();
        }
        Session::flash('type', 'danger');
        Session::flash('message', 'Error: no se pudo realizar la acción.');
        return redirect()->back();
    }


    //-------------------------------------------------- Profesor especial 

    public function nuevoEs()
    {
        $institucion = Institucion::select(
            'i.id as id',
            'i.ins_nombre as institucion'
        )
            ->from('inst_institucion as i')
            ->orderBy('i.ins_nombre', 'ASC')
            ->get();


        return view('administrador.nuevoEspecial')
            ->with('institucion', $institucion);
    }
    
    public function crearEspecial(Request $request)
    {
        Validator::make(
            $request->all(),
            ProfesorMateria::ruleCrear()
        )->addCustomAttributes(
            ProfesorMateria::attrCrear()
        )->validate();

       /* $asignado_seccion = ProfesorSeccion::select('id')
            ->where('enc_inst_id', $request->institucion)
            ->where('enc_gr_id',  $request->grado)
            ->where('enc_sec_id', $request->seccion)
            ->get();*/


        $asignado_materia = ProfesorMateria::select('id')
            ->where('pm_inst_id', $request->institucion)
            ->where('pm_gr_id', $request->grado)
            ->where('pm_sec_id', $request->seccion)
            ->where('pm_mat_id',$request->materia)
            ->where('pm_usu_id',  $request->profesor)->get();
 
 //dd($asignado_materia );
       
        if (count($asignado_materia) > 0) {
            if (count($asignado_materia) > 0) {
                Session::flash('type', 'danger');
                Session::flash('message', 'No se pudo asignar el profesor, la materia de la sección seleccionada ya tiene profesor asignado!');
                return redirect('admin/profesor');
            } else {
                Session::flash('type', 'danger');
                Session::flash('message', 'No se pudo asignar el profesor, el profesor seleccionado ya es encargado de la sección seleccionada!');
                return redirect('admin/profesor');
            }
        } else {
            $asignar = new Profesormateria;

            $asignar->pm_usu_id = $request->profesor;
            $asignar->pm_sec_id = $request->seccion;
            $asignar->pm_gr_id =  $request->grado;
            $asignar->pm_inst_id = $request->institucion;
            $asignar->pm_mat_id = $request->materia;
            $asignar->save();
            Session::flash('type', 'success');
            Session::flash('message', 'Asignación registrada correctamente!');
            return redirect('admin/profesor');
        }
    }
    public function eliminarEspecial($id)
    {
        $dato = ProfesorMateria::where('id', $id)->first();

        if ($dato) {
            $dato->delete();
            Session::flash('type', 'danger');
            Session::flash('message', 'Profesor encargado eliminado correctamente');
            return redirect()->back();
        }
        Session::flash('type', 'danger');
        Session::flash('message', 'Error: no se pudo realizar la acción.');
        return redirect()->back();
    }

    //------------------------------------------------------------------- Alumno -------------------------------------------------------------------

    public function listaAlumno()
    {

        $alumnos = Alumno::select(
            'a.id AS alumno_id',
            'a.ins_estado AS estado',
            'u.usu_nombres AS nombres',
            'u.usu_apellidos AS apellidos',
            'cg.cat_grado AS grado',
            'cs.cat_seccion AS seccion',
            'i.ins_nombre AS institucion',
            't.cat_turno AS turno'
        )
            ->from('alumno_seccion AS a')
            ->join('usu_usuario AS u', 'a.ins_usu_id', '=', 'u.id')
            ->join('inst_gra_grados AS g', 'a.ins_grado_id', '=', 'g.id')
            ->join('cat_grados AS cg', 'g.gra_grado_id', '=', 'cg.id')
            ->join('inst_institucion AS i', 'a.ins_inst_id', '=', 'i.id')
            ->join('inst_sec_secciones AS s', 'a.ins_seccion_id', '=', 's.id')
            ->join('cat_secciones AS cs', 's.sec_cat_id', '=', 'cs.id')
            ->join('cat_turnos AS t', 's.sec_turno_id', '=', 't.id')
            ->get();

        $institucion = Institucion::select(
            'i.id as id',
            'i.ins_nombre as institucion'
        )
            ->from('inst_institucion as i')
            ->orderBy('i.ins_nombre', 'ASC')
            ->get();
        return view('administrador.alumno')
            ->with('alumnos', $alumnos)
            ->with('institucion', $institucion);
    }


    public function nuevoAlumno(Request $request)
    {

        Validator::make(
            $request->all(),
            Alumno::ruleCrear()
        )->addCustomAttributes(
            Alumno::attrCrear()
        )->validate();

        $datos = Alumno::where('ins_usu_id', $request->alumno)
            ->where('ins_seccion_id', $request->seccion)
            ->where('ins_grado_id', $request->grado)
            ->where('ins_inst_id', $request->institucion)
            ->first();

        if (!$datos) {
            $alumno = new Alumno;
            $alumno->ins_usu_id = $request->alumno;
            $alumno->ins_seccion_id = $request->seccion;
            $alumno->ins_grado_id = $request->grado;
            $alumno->ins_inst_id = $request->institucion;
            $alumno->save();
            Session::flash('type', 'success');
            Session::flash('message', 'Alumno asignado correctamente');
            return redirect()->back();
        }
        Session::flash('type', 'danger');
        Session::flash('message', 'Alumno ya fue asignado');
        return redirect()->back();
    }

    public function eliminarAlumno($id)
    {
        $dato = Alumno::where('id', $id)->first();

        if ($dato) {
            $dato->delete();
            Session::flash('type', 'danger');
            Session::flash('message', 'Alumno eliminado correctamente');
            return redirect()->back();
        }
        Session::flash('type', 'danger');
        Session::flash('message', 'Error: no se pudo realizar la acción.');
        return redirect()->back();
    }

    //------------------------------------------------------------------- Consultas Json -------------------------------------------------------------------

    public function obtenerGrados($id)
    {
        $grados = Grado::where('gra_inst_id', $id)
            ->join('cat_grados', 'inst_gra_grados.gra_grado_id', '=', 'cat_grados.id')
            ->select(
                'inst_gra_grados.id',
                'cat_grados.cat_grado'
            )

            ->get();
        return response()->json($grados);
    }

    public function obtenerMateria($id)
    {
        $materia = Materia::where('mat_inst_id', $id)
            ->get();
        return response()->json($materia);
    }

    public function obtenerSeccion($id)
    {
        $seccion = Seccion::select('s.id AS seccion_id', 'cs.cat_seccion AS seccion', 't.cat_turno AS turno')
            ->from('inst_sec_secciones as s')
            ->join('cat_secciones AS cs', 's.sec_cat_id', '=', 'cs.id')
            ->join('cat_turnos AS t', 's.sec_turno_id', '=', 't.id')
            ->where('s.sec_grado_id', '=', $id)
            ->get();

        return response()->json($seccion);
    }

    public function obtenerProfesor($id)
    {
        $profesor = DatosUsuario::select(
            'id AS profesor_id',
            'usu_nombres AS nombres',
            'usu_apellidos AS apellidos'
        )
            ->where('usu_inst_id', '=', $id)
            ->where('usu_rol_id', '=', '2')
            ->get();
        return response()->json($profesor);
    }
    public function obtenerAlumno($id)
    {
        $alumno = DatosUsuario::select(
            'id AS alumno_id',
            'usu_nombres AS nombres',
            'usu_apellidos AS apellidos'
        )
            ->where('usu_inst_id', '=', $id)
            ->where('usu_rol_id', '=', '3')
            ->get();
        return response()->json($alumno);
    }

    public function cargarMateria($id)
    {
        $materia = DB::table('inst_mat_materias AS m')
            ->select('m.id AS materia_id', 'cm.cat_materia AS materia')
            ->join('cat_materias AS cm', 'm.mat_cat_id', '=', 'cm.id')
            ->where('m.mat_gra_id', '=', $id)
            ->groupBy('m.id', 'cm.cat_materia')
            ->get();
        return response()->json($materia);
    }
}
