@extends('templates.base')
@section('title')
Configurações
@endsection

@section('content')
  <div class="card">
  <div class="card-body">
    <h3 class="card-title">Configuração de limite</h3>
    <div class="card-deck">
    @foreach ($graficos as $grafico)
    <div class="card">
      <div class="card-body">
      <h6 class="card-title">{{$grafico->titulo}}</h5>
      <form action="" method="post">
      {{csrf_field()}}
      <input type="hidden" value="{{$grafico->id}}" name="id"/>
      <div class="form-group">
      <label for="multiplicador_input">Limite(% acima da média)</label>
      <input type="number" step="any" name="multiplicador" class="form-control" id="multiplicador_input" value="{{$grafico->multiplicador}}"/>
      </div>
      <input type="submit" class="btn btn-primary btn-block"/>
      </form>
      </div>
    </div>
    @endforeach
    </div>
  </div>
  </div>
@endsection