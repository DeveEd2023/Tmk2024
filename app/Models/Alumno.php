<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;
    protected $table = 'alumno_seccion';


    static function ruleCrear(): array
    {
        return [
            'institucion' => 'required',
            'grado' => 'required',
            'seccion' => 'required',
            'alumno' => 'required'
        ];
    }

    static function attrCrear(): array
    {
        return [
            'institucion' => 'Institución',
            'grado' => 'Grado',
            'seccion' => 'Sección',
            'alumno' => 'Alumno'
        ];
    }
}
