@extends('templates.base')
@section('title')
  Notificações
@endsection

@section('content')
  @foreach(\App\Alerta::where('read', 0)->get() as $alerta)
  <div class="alert alert-{{$alerta['type']}} alert-dismissible fade show" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="read({{$alerta['id']}})">
    <span aria-hidden="true">&times;</span>
  </button>
  @isset($alerta['title'])
  <h4 class="alert-heading">{{$alerta['title']}}</h4>
  @endisset
  {{$alerta['conteudo']}}
  </div>
  @endforeach

  <script>
  function read(id) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      console.log('done');
    }

    xhttp.open("GET", "/api/alertas/" + id + "/read", true);
    xhttp.send();
  }
  </script>
@endsection