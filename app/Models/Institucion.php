<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    use HasFactory;
    protected $table = 'inst_institucion';

    //Relacion con el usuario
    public function usuario()
    {
        return $this->belongsTo('User');
    }
    //Relacion con el Grado
    public function grado()
    {
        return $this->belongsTo('Grado');
    }

    static function ruleCrear()
    {
        return [
            'nombre' => 'required',
            'codigo' => 'required',
            'telefono' => 'required',
            'encargado' => 'required',
            'correoEn' => 'required',
            'telefonoEn' => 'required'
        ];
    }

    static function attrCrear()
    {
        return [
            'nombre' => 'Nombre',
            'codigo' => 'Codigo',
            'telefono' => 'Telefóno',
            'encargado' => 'Encargado',
            'correoEn' => 'Correo de encargado',
            'telefonoEn' => 'Telefóno de encargado'
        ];
    }



    static function ruleEd(): array
    {
        return [

            'nombre' => 'required',
            'codigo' => 'required',
            'telefono' => 'required',
            'encargado' => 'required',
            'correoEn' => 'required',
            'telefonoEn' => 'required'
        ];
    }

    static function attrEd(): array
    {
        return [
            'nombre' => 'Nombre',
            'codigo' => 'Codigo',
            'telefono' => 'Telefóno',
            'encargado' => 'Encargado',
            'correoEn' => 'Correo de encargado',
            'telefonoEn' => 'Telefóno de encargado'
        ];
    }
}
