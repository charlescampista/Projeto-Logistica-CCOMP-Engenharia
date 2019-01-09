@extends('templates.base')
@section('title')
Resultados da busca
@endsection
@section('content')
    @isset($erros)
        @foreach($erros as $erro)
            {{$erro}}
        @endforeach
    @endisset
    @isset($notas)
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-hover">
                        <thead>
                        <tr>
                            <th>Código</th>
                            <th>Placa do Veículo</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($notas as $nota)
                                @if($nota['aberto'] == '1')
                                    <tr class="table-success" href="{{url('/notas/' . $nota['id'])}}">
                                @else
                                    <tr class="table-warning" href="{{url('/notas/' . $nota['id'])}}">
                                @endif
                                    <td>{{$nota['codigo']}}</td>
                                    <td>{{$nota['placa']}}</td>
                                </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$notas->links()}}
                </div>
            </div>
        </div>
    @endisset
@endsection

@section('script')
    <script>
        $(document).ready(function(){
           $("tbody tr").click(function(e) {
              window.location.href = $(this).attr('href');
           });
        });
    </script>
@endsection
