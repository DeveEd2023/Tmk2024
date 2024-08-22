<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
    use HasFactory;

    protected $table = 'inst_gra_grados';

    public function institucion()
    {
        return $this->belongsTo('Institucion');
    }

    static function ruleCrear(): array
    {
        return [

            'grado' => 'required',
            'institucion' => 'required'

        ];
    }

    static function attrCrear(): array
    {
        return [

            'grado' => 'Grado',
            'institucion' => 'Institución'
        ];
    }
}
