@extends('templates.base')

@section('content')
    <div class="card-group">
        <div class="card card-inverse card-primary text-center">
            <div class="card-body">
                <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#novaNotaModal">Abrir Nota</button>
                <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#buscarNotaModal">Buscar Nota</button>
            </div>
        </div>
        <div class="card card-inverse card-primary text-center">
            <div class="card-body">
                <h3 class="card-title">Estátisticas</h3>
                <ul class="text-left" style="list-style: none">
                    <li><strong>Em Aberto:</strong> {{$notas_em_aberto}}</li>
                    <li><strong>Total:</strong> {{$notas_totais}}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card" style="margin-top: 2px;">
        <div class="card-body">
            <h3 class="card-title">Últimas notas em aberto</h3>
            <div class="list-group">
                @foreach(\App\Nota::all() as $nota)
                    <a href="{{url('/notas/' . $nota['id'])}}" class="list-group-item list-group-item-action">{{$nota['codigo']}}</a>
                @endforeach
            </div>
        </div>
    </div>

@endsection

@section('modal')
<div class="modal fade" id="novaNotaModal" tabindex="-1" role="dialog" aria-labelledby="Nova Nota" aria-hidden="true">
        <form action="{{url('/notas/nova')}}" method="post">
            {{csrf_field()}}
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Abrir Nota</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="inputNotaCodigo">Código da Nota</label>
                            <input type="text" class="form-control" id="inputNotaCodigo" placeholder="" name="codigo">
                        </div>
                        <div class="form-group">
                            <label for="inputVeiculoCodigo">Placa do Veículo</label>
                            <input type="text" class="form-control" id="inputVeiculoCodigo" placeholder="" name="placa">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="btnSubmit">Enviar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade" id="buscarNotaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form method="get" action="{{url('/notas/buscar')}}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Buscar Nota</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="inputNotaCodigo">Buscar Por</label>
                            <input type="text" class="form-control" id="inputSearchValue" placeholder="" name="valor">
                        </div>
                        <div class="form-group">
                            <label for="searchParam1">Tipo de Busca</label><br/>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="tipo" id="searchParam1" value="nota" checked> Código da Nota
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="tipo" id="searchParam2" value="veiculo"> Placa do Veículo
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="btnSearch">Buscar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('title')
    Notas
@endsection

@section('script')
@endsection