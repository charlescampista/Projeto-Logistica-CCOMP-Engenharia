<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/alertas/{alerta}/read', function(\App\Alerta $alerta) {
    $alerta['read'] = !$alerta['read'];
    $alerta->save();
    return $alerta;
});

Route::post('lancamento', function(Request $request)
{
    $tempo = \Carbon\Carbon::now();
    $nota = \App\Nota::where('codigo', $request->get('codigo'))->first();
    if(!$nota)
    {
        return [
          'erro' => 'Nota Desconhecida'
        ];
    }

    return $nota->lancar();
});

Route::prefix('veiculos')->group(function() {
    Route::prefix('tipo')->group(function() {
       Route::get('/', function()
       {
           return \App\TipoVeiculo::all();
       });
    });

    Route::get('/', function()
    {
       return \App\Veiculo::all();
    });
});

Route::prefix('notas')->group(function() {
   Route::get('/', function()
   {
      return App\Nota::where('aberto', '1')->get();
   });

   Route::post('/', function(Request $request)
   {
       $nota = new \App\Nota($request->all());
       $nota->save();
   });
   Route::delete('/{nota}/', function(\App\Nota $nota)
    {
        $nota['aberto'] = 0;
        $nota->save();
        return $nota;
    });
    Route::put('/{nota}/', function(\App\Nota $nota)
    {
        $nota['aberto'] = 1;
        $nota->save();
        return $nota;
    });
    Route::post('/busca/', function(Request $request)
    {
       $response = [];
       if($request->has('tipo') && $request->get('tipo') != null)
       {
           switch ($request->get('tipo'))
           {
               case "nota":
               {
                   $notas = \App\Nota::select(['id', 'codigo', 'aberto'])->where('codigo', $request->get('valor'));
                   break;
               }
               case 'veiculo':
               {
                   try
                   {
                       $veiculo = \App\Veiculo::where('placa', $request->get('valor'))->firstOrFail();
                       $notas = \App\Nota::select(['id','codigo','aberto'])
                           ->where('veiculo_id', $veiculo['id']);
                   }
                   catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e)
                   {
                       $response['regError'] = "Nenhum dado encontrado";
                   }
                   break;
               }
               default:
               {
                   $response['regError'] = "Tipo de busca desconhecido";
               }
           }
           if(isset($notas))
           {
               $response['response'] = $notas->paginate(1);
               $response['response']['links'] = (string) $notas->paginate(1)->links();
           }
           else
           {
               $response['regError'] = "Nenhum dado encontrado";
           }
       }
       else
       {
           $response['reqError'] = "Tipo de busca deve ser definido";
       }
       return $response;
    });
});