<?php

namespace App\Http\Controllers\Veiculos;

use App\TipoVeiculo;
use App\Veiculo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class VeiculosController extends Controller
{
    function index()
    {
        $veiculos_movimento = Veiculo::select(DB::raw('veiculos.id, placa, COUNT(*) as registros_abertos'))
            ->join('notas', function($join)
            {
                $join->on('veiculos.id', '=', 'notas.veiculo_id')
                    ->where('notas.aberto', '=', '1');
            })
            ->groupBy('veiculos.id')
            ->orderBy('registros_abertos', 'DESC')
            ->limit(15)
            ->get();
        $tipos = TipoVeiculo::select(['id', 'tipo'])->get();
        return view('veiculos.index', ['veiculos' => $veiculos_movimento, 'tipos' => $tipos]);
    }

    function view(Veiculo $veiculo)
    {
        $notas = $veiculo->notas()->select(['id', 'codigo'])->get();
        return view('veiculos.view', ['veiculo' => $veiculo, 'tipo' => $veiculo->tipo, 'notas' => $notas]);
    }

    function novo(Request $request)
    {
        $veiculo = new Veiculo($request->all());
        $veiculo->save();
        return redirect('/veiculos')->with('info', ' Veículo Criado.');
    }

    function tipoNovo(Request $request)
    {
        $novoTipo = new TipoVeiculo($request->all());
        $novoTipo->save();
        return redirect('/veiculos')->with('info', 'Tipo de Veículo Criado.');
    }
}
