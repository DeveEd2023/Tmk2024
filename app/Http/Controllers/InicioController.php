<?php

namespace App\Http\Controllers;

use App\Models\DatosUsuario;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

use function PHPUnit\Framework\returnSelf;

class InicioController extends Controller
{
    public function inicio()
    {
        if (Auth::check()) {
            $user = Auth::user()->id;
            $datos = DatosUsuario::where('id', $user)->first();
            switch ($datos->usu_rol_id) {
                case 1:
                    return view('inicioAdmin');
                    break;
                case 2:


                    $img = DatosUsuario::select('i.ins_nombre as inst', 'i.inst_logo as img')
                        ->from('usu_usuario as u')
                        ->join('inst_institucion as i', 'i.id', '=', 'u.usu_inst_id')
                        ->where('u.id', $user)
                        ->first();


                    return view('profesor.inicioProfesor')
                        ->with('inst', $img->inst)
                        ->with('img', $img->img)
                        ->with('id', $user);


                    break;
                case 3:

                    return redirect('alumno/inicio/' . $user);

                    break;


                default:
                    Session::flash('type', 'warning');
                    Session::flash('message', '¡Usuario sin acceso!');
                    return view('login');
            }
        } else {
            return view('login');
        }
    }
    public function acceso(Request $request)
    {
        Validator::make(
            $request->all(),
            Usuario::ruleLogin()
        )->setAttributeNames(
            Usuario::attrLogin()
        )->validate();
        $user = Usuario::where("log_nombre", $request->username)->first();
        if ($user)
            if (Hash::check($request->password, $user->password))
                Auth::login($user);
        if (Auth::check()) {
            $request->session()->regenerate();
        } else {
            Session::flash('type', 'danger');
            Session::flash('message', 'Usuario o Contraseña no validos');
        }

        return redirect()->back()->with('usuario', $user);
    }

    public function salir()
    {
        if (Auth::check())
            Auth::logout();
        return redirect("/");
    }
}
