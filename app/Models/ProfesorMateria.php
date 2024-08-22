<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfesorMateria extends Model
{
    use HasFactory;


    protected $table = 'profesor_materia';
    static function ruleCrear(): array
    {
        return [
            'institucion' => 'required',
            'grado' => 'required',
            'seccion' => 'required',
            'materia' => 'required',
            'profesor' => 'required'
        ];
    }

    static function attrCrear(): array
    {

        return [
            'institucion' => 'Institución',
            'grado' => 'Grado',
            'seccion' => 'Sección',
            'materia' => 'Materia',
            'profesor' => 'Profesor'
        ];
    }
}
