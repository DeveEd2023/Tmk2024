<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    use HasFactory;

    protected $table = 'encargado_seccion';

    public function usuario()
    {
        return $this->belongsTo('Usuario');
    }

    public function seccion()
    {
        return $this->belongsTo('Seccion');
    }


}
