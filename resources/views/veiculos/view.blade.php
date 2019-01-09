@extends('templates.base')

@section('content')
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Dados</h3>
            <b>Placa</b> {{$veiculo['placa']}}<br/>
            <b>Tipo</b> {{$tipo['tipo']}}<br/>
            <b>Carga Máxima</b> {{$tipo['carga']}}
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Notas Associadas</h3>
            <ul class="list-group">
                @foreach($notas as $nota)
                    <li class="list-group-item">
                        <div class="justify-content-start">
                            <a href="{{url('/notas/' . $nota['id'])}}"><span class="fa-stack fa-lg">
                             <i class="fa fa-square fa-stack-2x text-dark"></i>
                                    <i class="fa fa-search fa-stack-1x text-success"></i>
                            </span></a>
                            <b>{{$nota['codigo']}}</b>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection

@section('title')
    Veículo {{$veiculo['placa']}}
@endsection