@extends('templates.base')

@section('content')
    <div class="card-columns">
    @foreach ($graficos as $grafico)
    <div class="card">
            <div class="card-body">
                <h3 class="card-title">{{$grafico->titulo}}</h3>
                <div id="{{$grafico->id}}_chart">
                </div>
                @combochart($grafico->titulo, "$grafico->id" . "_chart")
            </div>
    </div>
    @endforeach
    </div>

@endsection

@section('title')
    Relatório de Tempos Médios
@endsection
