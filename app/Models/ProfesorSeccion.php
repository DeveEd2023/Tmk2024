<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfesorSeccion extends Model
{
    use HasFactory;

    protected $table = 'profesor_seccion';



    static function ruleCrear(): array
    {
        return [
            'institucion' => 'required',
            'grado' => 'required',
            'seccion' => 'required',
            'profesor' => 'required'
        ];
    }

    static function attrCrear(): array
    {
        return [
            'institucion' => 'Institución',
            'grado' => 'Grado',
            'seccion' => 'Sección',
            'profesor' => 'Profesor'
        ];
    }
}
