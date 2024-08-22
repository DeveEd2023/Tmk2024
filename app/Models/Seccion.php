<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    use HasFactory;

    protected $table = 'inst_sec_secciones';


    public function grado()
    {
        return $this->belongsTo('Grado');
    }

    static function ruleCrear(): array
    {
        return [

            'institucion' => 'required',
            'grado' => 'required',
            'seccion' => 'required',
            'turno' => 'required'
        ];
    }
    static function attrCrear(): array
    {
        return [
            'institucion' => 'Institución',
            'grado' => 'Grado',
            'seccion' => 'Sección',
            'turno' => 'Turno'
        ];
    }
}
