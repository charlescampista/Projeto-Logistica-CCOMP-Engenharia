@extends('templates.base')

@section('content')
    <div class="card-group">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Registrar Veículo</h3>
                <form action="{{url('/veiculos/novo')}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="inputPlaca">Placa do Veículo</label>
                        <input type="text" maxlength="7" class="form-control" name="placa"/>
                    </div>
                    <div class="form-group">
                        <label for="inputTipo">Tipo de Veículo</label>
                        <select class="form-control" id="inputTipo" name="tipo_id">
                            @foreach($tipos as $tipo)
                                <option value="{{$tipo['id']}}">{{$tipo['tipo']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Enviar</button>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Novo Tipo de Veículo</h3>
                <form action="{{url('/veiculos/tipos/novo')}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="inputTipo">Descrição</label>
                        <input type="text" id="inputTipo" class="form-control" name="tipo"/>
                    </div>
                    <div class="form-group">
                        <label for="inputCarga">Limite de Carga</label>
                        <input class="form-control" type="number" id="inputCarga" name="carga"/>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Enviar</button>
                </form>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Veículos em movimento</h3>
            <h6 class="card-subtitle">Somente listado os 15 veículos com mais notas associadas</h6>

            <ul class="list-group">
                @foreach($veiculos as $veiculo)
                    <li class="list-group-item justify-content-between">
                        <div class="justify-content-start">
                            <a href="{{url('/veiculos/' . $veiculo['id'])}}"><span class="fa-stack fa-lg">
                             <i class="fa fa-square fa-stack-2x text-dark"></i>
                                    <i class="fa fa-truck fa-stack-1x text-success"></i>
                            </span></a>
                            <b>{{$veiculo['placa']}}</b><span class="badge badge-dark badge-pill">{{$veiculo['registros_abertos']}}</span>
                        </div>
                        
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection

@section('title')
    Veículos
@endsection