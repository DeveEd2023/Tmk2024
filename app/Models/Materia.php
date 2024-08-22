<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;


    protected $table = 'inst_mat_materias';


    public function grado()
    {
        return $this->belongsTo('Grado');
    }

    static function ruleCrear(): array
    {
        return [
            'institucion' => 'required',
            'grado' => 'required',
            'materia' => 'required'
        ];
    }

    static function attrCrear(): array
    {

        return [
            'institucion' => 'Institución',
            'grado' => 'Grado',
            'materia' => 'Materia'
        ];
    }
}
