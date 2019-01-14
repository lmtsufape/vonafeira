<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--<title>{{ config('app.name', 'Laravel') }}</title> -->
    <title>@yield('titulo') | Vô na Feira</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script type="text/javascript">
        /* Máscaras ER */
        function mascara(o,f){
            v_obj=o
            v_fun=f
            setTimeout("execmascara()",1)
        }
        function execmascara(){
            v_obj.value=v_fun(v_obj.value)
        }
        function mtel(v){
            v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
            v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
            v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
            return v;
        }
        function id( el ){
            return document.getElementById( el );
        }
        window.onload = function(){
            id('telefone').onkeypress = function(){
                mascara( this, mtel );
            }
        }
    </script>

    <style type="text/css">
        hr {
            color: #7F7F7F;
            height: 1px;
        }
    </style>

</head>
<body>
    <div id="barra-brasil" style="background:#7F7F7F; height: 20px; padding:0 0 0 10px;display:block;">
    <ul id="menu-barra-temp" style="list-style:none;">
        <li style="display:inline; float:left;padding-right:10px; margin-right:10px; border-right:1px solid #EDEDED">
            <a href="http://brasil.gov.br" style="font-family:sans,sans-serif; text-decoration:none; color:white;">Portal do Governo Brasileiro</a>
        </li>
        <li>
        <a style="font-family:sans,sans-serif; text-decoration:none; color:white;" href="http://epwg.governoeletronico.gov.br/barra/atualize.html">Atualize sua Barra de Governo</a>
        </li>
    </ul>
    </div>

    <!-- Barra de Logos -->
    <div id="barra-logos" style="background:#FFFFFF; margin-top: 1px; height: 100px; padding: 10px 0 10px 0">
        <ul id="logos" style="list-style:none;">
            <li style="margin-right:140px; margin-left:110px; border-right:1px">
                <a href="/home">Vô Na Feira</a>
                <a target="_blank" href="http://lmts.uag.ufrpe.br/"><img src="{{asset('images/lmts2.png')}}" style = "margin-left: 15px; margin-top:10px " height="70" width="60"align = "right" ></a>
          
                <img src="{{asset('images/separador.png')}}" style = "margin-left: 15px" height="80" align = "right" >
                <a target="_blank" href="http://ww3.uag.ufrpe.br/"><img src="{{asset('images/uag.png')}}" style = "margin-left: 10px" height="80" width="70" align = "right" ></a>
          
                <img src="{{asset('images/separador.png')}}" style = "margin-left: 15px" height="80" align = "right" >
                <a target="_blank" href="http://www.ufrpe.br/"><img src="{{asset('images/ufrpe.png')}}" style = "margin-left: 15px; margin-right: -10px " height="80" width="70" align = "right"></a>
            </li>
        </ul>
    </div>

    
<!-- barra de menu -->
<div id="app">
    <div class="navbar navbar-default" style="background-color: #1B2E4F; border-color: #d3e0e9" role="navigation">
        <div class="container col-md-10 col-md-offset-1" >
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" >

                    <ul class="nav navbar-nav">
                        @if(Auth::check())
                            <li><a style="color: #ffffff" class="main-menu" href="/home">Início</a></li>
                        @endif
                    </ul>

                    

                    <ul class="nav navbar-nav navbar-right">
                        @if(Auth::check())

                        <li class="dropdown">
                                <a style="color: #fff" href="/gruposConsumo" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Grupos de Consumo <span class="caret"></span>
                                </a>
    
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="/gruposConsumo">Meus Grupos de Consumo</a>
                                    </li>
                                    <li>
                                        <a href="/selecionarGrupo">Entrar em Grupo de Consumo</a>
                                    </li>
                                </ul>
                            </li>

                        <li class="dropdown">
                            <a style="color: #ffffff" href="/loja" class="main-menu dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Loja <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="/loja">Comprar</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                                <a style="color: #ffffff" href="#" class="main-menu dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <ul style="" class="dropdown-menu" role="menu">
                                    <li><a href="/meusPedidos">Meus Pedidos</a></li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Sair
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else

                        <li><a style="color: #fff" href="{{ route('login') }}">Entrar</a></li>
                        |
                        <li><a style="color: #fff" href="{{ route('register') }}">Cadastrar</a></li>

                        @endif

                    </ul>

                </ul>
                            
            </div>
        </div>
    </div>

    <div style="margin-top: -30px" class="container">
        <hr>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="collapse navbar-collapse" >
                        <ul class="nav navbar-nav">
                            @yield('navbar')
                        </ul>
                    </div>
                </div>
            </div>
        <hr>
    </div>
        
    </div>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
<script defer="defer" src="//barra.brasil.gov.br/barra.js" type="text/javascript"></script>
</html>
