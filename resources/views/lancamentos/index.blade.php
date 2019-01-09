@extends('templates.base')

@section('content')
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Novo Lançamento</h3>
            <form action="{{url('lancamentos/novo')}}" method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="inputOrigem">Código da Nota</label>
                    <input class="form-control" id="inputOrigem" name="codigo"/>
                </div>
                <button class="btn btn-primary btn-block" type="submit">Registrar</button>
            </form>
        </div>
    </div>
@endsection

@section('title')
    Lançamentos
@endsection