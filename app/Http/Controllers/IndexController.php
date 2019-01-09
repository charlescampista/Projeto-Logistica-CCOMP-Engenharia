<?php

namespace App\Http\Controllers;

use App\Nota;
use App\Veiculo;
use App\Grafico;
use App\Alerta;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;

class IndexController extends Controller
{
    function index()
    {
        $notas = [
            'aberto' => Nota::getNotasEmAberto()->count(),
            'total' => Nota::all()->count()
        ];
        $veiculos = [
            'emMovimento' => Veiculo::getVeiculosEmMovimento()->count()
        ];
        $viewData = [
            'notas' => $notas,
            'veiculos' => $veiculos
        ];
        return view('home', ['dados' => $viewData]);
    }

    function notificacoes()
    {
        return view('notificacoes.index');
    }

    function config()
    {
        return view('config.index', ['graficos' => Grafico::all()]);
    }

    function configPost(Request $request)
    {
        $grafico = Grafico::find($request->get('id'));
        $grafico['multiplicador'] = $request->get('multiplicador');
        if($grafico->save()) {
            return redirect('/configuracoes')->with('info', 'Limite Salvo.');
        } else {
            return redirect('/configuracoes')->with('erro', 'Não foi possível salvar limite.');
        }
    }

    function lancamentos()
    {
        return view('lancamentos.index');
    }

    function lancar(Request $request)
    {
        $nota = \App\Nota::where('codigo', $request->get('codigo'))->first();
        if(!$nota)
        {
            return redirect('/lancamentos')->with('erro', 'Nota não encontrada');
            
        }
        $status = $nota->lancar();

        if($status == null) {
            return redirect('/lancamentos')->with('erro', 'Nota Fechada');
        }
        return redirect('/lancamentos')->with('info', "Lançado evento $status[campo] na nota $nota[codigo]");
    }
}
