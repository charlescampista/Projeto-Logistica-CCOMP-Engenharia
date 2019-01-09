@extends('templates.base')

@section('content')
    <div class="row">
        <div class="col-md">
            <div class="card">
                <div class="card-header">
                    Notas
                </div>
                <div class="card-body">
                    <ul>
                        <li>Em Aberto: {{$dados['notas']['aberto']}}</li>
                        <li>Total: {{$dados['notas']['total']}}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card">
                <div class="card-header">
                    Veículos
                </div>
                <div class="card-body">
                    <ul>
                        <li>Em Movimento: {{$dados['veiculos']['emMovimento']}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('title')
    Home
@endsection