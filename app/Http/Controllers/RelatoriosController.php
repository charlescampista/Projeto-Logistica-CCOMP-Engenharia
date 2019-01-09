<?php

namespace App\Http\Controllers;

use App\Nota;
use App\Grafico;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Khill\Lavacharts\Lavacharts;

class RelatoriosController extends Controller
{
    function temposMedios(){
        $graficos = Grafico::all();
        foreach($graficos as $grafico)
        {
            $this->gerar_grafico($grafico['titulo'], $grafico['sub'], [$grafico['col1'], $grafico['col2']], $grafico['multiplicador']);
        }
		return view('relatorios.tempos_medios', ['graficos' => $graficos]);
	}

	function gerar_grafico($titulo, $desc, array $colunas, $multiplicador)
    {
        $chegada_abertura = \Lava::DataTable();
        $chegada_abertura->addStringColumn('Dia do Mês');
        $chegada_abertura->addNumberColumn('Tempo(Minutos)');
        $chegada_abertura->addNumberColumn('Tolerancia');
        
        $chegada_abertura_data = Nota::getData($colunas[0], $colunas[1]);
        $tolerancia = $chegada_abertura_data['media_mes'] * (1 + $multiplicador / 100);
        for($i = 0; $i < Carbon::now()->endOfMonth()->day; $i++)
        {
            $tol = 0;
            $val = 0;
            foreach ($chegada_abertura_data['dias'] as $dia)
            {
                if($dia['dia'] == $i+1) {
                    $val = $dia['media'];
                    $tol = $dia['media'] * (1 + $multiplicador / 100);
                }
            }
            $chegada_abertura->addRow([$i+1, $val, $tol]);
        }

        \Lava::ComboChart($titulo, $chegada_abertura, [
            'title' => $desc,
            'legend' => ['position' => 'bottom'],
            'vAxis' => ['title' => 'Tempo(Minutos)'],
            'seriesType' => 'line',
            'pointSize' => 5,
            'colors' => ['#5555FF', 'red', 'orange'],
            'series' => [
                0 => ['pointSize' => 1, 'lineWidth' => 5],
                1 => ['pointSize' => 0, 'type' => 'line'],
            ],
        ]);
    }
}
