<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recursos extends Model
{
    use HasFactory;
    protected $table = 'rec_rec_recursos';

    static function ruleCrear(): array
    {
        return [
            'grado' => 'required',
            'materia' => 'required',
            'nombre' => 'required ',
            'descripcion' => 'required|string|max:200',
        ];
    }
    static function attrCrear(): array
    {
        return [
            'grado' => 'Grado',
            'materia' => 'Materia',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripción',
        ];
    }
}
