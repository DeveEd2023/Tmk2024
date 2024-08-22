<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecursoExtencion extends Model
{
    use HasFactory;

    protected $table = 'rec_ext_extension';


    static function ruleCrear(): array
    {
        return [
            'grado' => 'required',
            'materia' => 'required',
            'unidad' => 'required',
            'tema' => 'required',
            'datos' => 'required'
        ];
    }

    static function attrCrear(): array
    {
        return [
            'grado' => 'Grado',
            'materia' => 'Materia',
            'unidad' => 'Unidad',
            'tema' => 'Tema',
            'datos' => 'Desarrollo'
        ];
    }
}
