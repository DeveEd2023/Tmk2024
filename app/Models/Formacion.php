<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formacion extends Model
{
    use HasFactory;

    protected $table = 'forc_formacioncontinua';


    //------------------- Validaciones ----------------------\\



    //---- crear -----\\

    static function ruleCrear(): array
    {
        return [

            'titulo' => 'required',
            'descripcion' => 'required',
            'txtEditor' => 'required',
        ];
    }

    static function attrCrear(): array
    {
        return [
            'titulo' => 'Título',
            'descripcion' => 'Descripción',
            'txtEditor' => 'Contenido',

        ];
    }
}
