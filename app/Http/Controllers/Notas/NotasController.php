<?php

namespace App\Http\Controllers\Notas;

use App\Nota;
use App\Veiculo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NotasController extends Controller
{
    function index()
    {
        $viewData = [
            'ultimas_notas' => \App\Nota::select('*')->limit(10)->get(),
            'notas_em_aberto' => \App\Nota::getNotasEmAberto()->count(),
            'notas_totais' => \App\Nota::all()->count()
        ];
        return view('notas.index', $viewData);
    }

    function nova(Request $request)
    {
        $nota = new \App\Nota();
        try
        {
            $veiculo = Veiculo::where('placa', $request->get('placa'))->firstOrFail();
            $nota['codigo'] = $request->get('codigo');
            $nota['veiculo_id'] = $veiculo['id'];
            $nota->save();
        }
        catch (ModelNotFoundException $exception)
        {
            return redirect('/notas/')->with('erro', 'Veículo não cadastrado');
        }
        catch (QueryException $exception)
        {
            $errorCode = $exception->errorInfo[1];
            if($errorCode == 1062)
            {
                //1062 => Erro do SQL para valor unico repetido.
                return redirect('/notas/')->with('erro', 'Nota já existe');
            }
        }

        return redirect('/notas/' . $nota['id']);
    }

    function buscar(Request $request)
    {
        $erros = [];
        if(!$request->has('tipo') || !$request->has('valor'))
        {
            array_push($erros, "Busca inválida");
        }
        else
        {
            $tipo = $request->get('tipo');
            if($tipo == "nota")
            {
                $notas = Nota::where('codigo', '=', $request->get('valor'));
            }
            elseif ($tipo == "veiculo")
            {
                try
                {
                    $veiculo = Veiculo::where('placa', $request->get('valor'))->firstOrFail();
                    $notas = Nota::where('veiculo_id', $veiculo['id']);
                }
                catch (ModelNotFoundException $e)
                {
                    array_push($erros, "Veículo não cadastrado");
                }
            }
            else
            {
                array_push($erros, "Busca inválida");
            }
        }
        $parametros = [

        ];
        if(count($erros) != 0)
        {
            $parametros['erros'] = $erros;
        }
        else
        {
            $notas = $notas->leftJoin('veiculos', 'notas.veiculo_id', '=', 'veiculos.id')
                ->select(['notas.id','notas.codigo','notas.aberto','veiculos.placa'])
                ->paginate(15)
                ->appends(['tipo' => $request->get('tipo'), 'valor' => $request->get('valor')]);
            $parametros['notas'] = $notas;
        }
        return view('notas.buscar', $parametros);
    }

    function view(\App\Nota $nota)
    {

        return view('notas.view', ['nota' => $nota]);
    }
}
