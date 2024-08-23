<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;
    protected $table = 'alumno_seccion';

    protected $fillable = [
        'ins_usu_id',
        'ins_seccion_id',
        'ins_grado_id',
        'ins_inst_id',
       
    ];

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
