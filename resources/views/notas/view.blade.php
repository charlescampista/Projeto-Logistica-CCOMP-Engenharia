@extends('templates.base')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md">
                    <b>ID</b>
                    <input class="form-control" value="{{$nota['id']}}" readonly="true"/>
                </div>
                <div class="col-md">
                    <b>Código</b>
                    <input class="form-control"  value="{{$nota['codigo']}}" readonly="true"/>
                </div>
                <div class="col-md">
                    <b>Veículo</b>
                    <input class="form-control"  value="{{$nota['veiculo_id']}}" readonly="true"/><!-- TODO: Trocar por placa. -->
                </div>
            </div>
            <div class="row">
                <div class="col-md">
                    <b>Box</b>
                    <input class="form-control" value="{{$nota['box']}}" readonly></input>
                </div>
            </div>
            <div class="row">
                <div class="col-md">
                    <b>Aviso de Chegada</b>
                    <input class="form-control" value="{{$nota['aviso_chegada']}}" readonly></input>
                </div>
                <div class="col-md">
                    <b>Abertura do Portão</b>
                    <input class="form-control" value="{{$nota['abertura_portao']}}" readonly></input>
                </div>
            </div>
            <div class="row">
                <div class="col-md">
                    <b>Início da Descarga</b>
                    <input class="form-control" value="{{$nota['descarga_inicio']}}" readonly></input>
                </div>
                <div class="col-md">
                    <b>Término da Descarga</b>
                    <input class="form-control" value="{{$nota['descarga_termino']}}" readonly></input>
                </div>
            </div>
            <div class="row">
                <div class="col-md">
                    <b>Início da Conferência de NF</b>
                    <input class="form-control" value="{{$nota['conferencia_nf_inicio']}}" readonly></input>
                </div>
                <div class="col-md">
                    <b>Término da Conferência de NF</b>
                    <input class="form-control" value="{{$nota['conferencia_nf_termino']}}" readonly></input>
                </div>
            </div>
            <div class="row">
                <div class="col-md">
                    <b>Aviso de Saída</b>
                    <input class="form-control" value="{{$nota['aviso_saida']}}" readonly></input>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('title')
    Nota {{$nota['codigo']}}
@endsection