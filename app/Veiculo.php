<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    protected $table = "veiculos";
    protected $fillable = [
        'placa',
        'tipo_id'
    ];

    public static function getVeiculosEmMovimento()
    {
        $veiculos = Veiculo::select(['veiculos.id', 'placa'])->
        leftJoin('notas', 'notas.veiculo_id', '=', 'veiculos.id')
            ->where('notas.aberto', 1)
            ->get();
        return $veiculos;
    }

    public function tipo()
    {
        return $this->belongsTo('App\TipoVeiculo', 'tipo_id');
    }

    public function notas()
    {
        return $this->hasMany('App\Nota', 'veiculo_id');
    }

    public function notasAbertas()
    {
        return $this->notas()->where('aberto', 1);
    }
}
