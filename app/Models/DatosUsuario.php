<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosUsuario extends Model
{
    use HasFactory;

    protected $table = "usu_usuario";


    static function ruleCrear(): array
    {
        return [
            'nombre' => 'required',
            'apellido' => 'required',
            'correo' => 'required',
            'telefono' => 'required',
            'rol' => 'required',
            'institucion' => 'required',
            'usuario' => 'required',
            'contraseña' => 'required|min:6|max:20'
        ];
    }


    static function attrCrear(): array
    {
        return [
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'correo' => 'Correo',
            'telefono' => 'Telefóno',
            'rol' => 'Rol',
            'institucion' => 'Institucion',
            'usuario' => 'Usuario',
            'contraseña' => 'Contraseña'
        ];
    }

    static function ruleUpdate(): array
    {
        return [
            'Unombre' => 'required',
            'Uapellido' => 'required',
            'Ucorreo' => 'required',
            'Utelefono' => 'required',
            'Uusuario' => 'required'

        ];
    }

    static function attrUpdate(): array
    {
        return [
            'Unombre' => 'Nombre',
            'Uapellido' => 'Apellido',
            'Ucorreo' => 'Correo',
            'Utelefono' => 'Telefóno',
            'Uusuario' => 'Nombre de usuario'
        ];
    }
}
