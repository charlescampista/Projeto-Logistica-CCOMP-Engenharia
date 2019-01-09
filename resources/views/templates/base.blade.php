<!DOCTYPE html>
<html lang="en" ng-app="dashboard">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <link rel="stylesheet" href="{{asset('/css/bootstrap.css')}}"/>
    <link rel="stylesheet" href="{{asset('/css/font-awesome.css')}}"/>
    <link rel="stylesheet" href="{{asset('/css/hamburguer.css')}}"/>
    <link rel="stylesheet" href="{{asset('/css/app.css')}}"/>
</head>
<body ng-controller="DashboardController">
<div class="sidebar bg-success" aria-hidden="false">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">Controle Logístico</a>
    </div>
    <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/notas">Notas</a></li>
        <li><a href="/veiculos">Veículos</a></li>
        <li><a href="/lancamentos">Lançamentos</a></li>
        <li><a href="/configuracoes">Configurações</a></li>
        <li><a href="/notificacoes">Notificações <span class="badge badge-pill badge-dark">{{\App\Alerta::where('read', 0)->count()}}</span></li>
    </ul>
    <div class="sidebar-header">
        <a href class="sidebar-brand">Relatórios</a>
    </div>
    <ul>
		<li><a href="/relatorios/tempos_medios">Tempos Medios</a></li>
    </ul>
</div>
<div class="page-content">
    <nav class="navbar navbar-light navbar-toggleable-sm sticky-top" style="background: white">
        <button class="hamburger hamburger--spin navbar-toggler navbar-toggler-left" type="button">
          <span class="hamburger-box">
            <span class="hamburger-inner"></span>
          </span>
        </button>
        <a href="#" class="navbar-brand">@yield('title')</a>
        

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

        </div>
    </nav>
    <div class="container-fluid" style="margin-top: 8px;">
        @if (session('erro'))
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Ops!</strong> {{session('erro')}}
            </div>
        @endif
            @if (session('info'))
                <div class="alert alert-info" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{session('info')}}
                </div>
            @endif
        @yield('content')
    </div>
</div>
@yield('modal')
<script src="{{asset('/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('/js/tether.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.5/umd/popper.min.js"></script> 
<script src="{{asset('/js/bootstrap.js')}}"></script>
<script src="{{asset('/js/app.js')}}"></script>
<script>
    var w = 0;

    $(".navbar-toggler").click(function() {
       var navbarState = $(".sidebar").attr('aria-hidden');
       if(navbarState == 'true') {
           $(".sidebar").css('width', 220);
           $(".page-content").css('margin-left', 220);
           $(".sidebar").attr('aria-hidden', 'false');
           $(".navbar-toggler").addClass('is-active');
       } else {
           $(".sidebar").css('width', 0);
           $(".page-content").css('margin-left', 0);
           $(".sidebar").attr('aria-hidden', 'true');
           $(".navbar-toggler").removeClass('is-active');
       }
    });

    $(document).ready(function() {
        w = $(document).width();
        if(w <= 768) {
            $(".sidebar").css('width', 0);
            $(".page-content").css('margin-left', 0);
            $(".sidebar").attr('aria-hidden', 'true');
        } else {
            $(".sidebar").css('width', 220);
            $(".page-content").css('margin-left', 220);
            $(".sidebar").attr('aria-hidden', 'false');
        }
    });

    $(window).resize(function() {
        if(w != $(document).width())
        {
            w = $(document).width();
            if(w <= 768) {
                $(".sidebar").css('width', 0);
                $(".page-content").css('margin-left', 0);
                $(".sidebar").attr('aria-hidden', 'true');
            } else {
                $(".sidebar").css('width', 220);
                $(".page-content").css('margin-left', 220);
                $(".sidebar").attr('aria-hidden', 'false');
            }
        }
    });
</script>
@yield('script')
</body>
</html>