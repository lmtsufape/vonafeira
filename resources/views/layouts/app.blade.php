<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--<title>{{ config('app.name', 'Laravel') }}</title> -->
    <title>@yield('titulo') | Grupo de Consumo Agrícola</title>

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

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">

            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <!--{{ config('app.name', 'Laravel') }}-->
                        Grupo de Consumo Agrícola

                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Registro</a></li>
                        @else

                        <li class="dropdown">
                                <a href="/gruposConsumo" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
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
                                    <a href="/loja" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        Loja <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="/loja">Comprar</a>
                                        </li>
                                    </ul>
                                </li>
                                <li >
                                </li>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="/meusPedidos">Meus Pedidos</a>
                                    </li>

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
                        @endif
                    </ul>

                </div>
                <hr style="margin-top: 0px; padding-bottom: -10px">
                <div name='navbar' style="padding-bottom: 22px" align:center>
                    @yield('navbar')
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
