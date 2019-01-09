<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoVeiculo extends Model
{
    protected $table = "tipo_veiculo";
    protected $fillable = [
        'tipo', 'carga'
    ];
}
