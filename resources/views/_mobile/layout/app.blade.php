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
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2-bootstrap.min.css') }}" rel="stylesheet">

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
        .panel-default > .panel-heading {
            color: #fff;
            background-color: #1B2E4F;
            border-color: #d3e0e9;
        }
        /* Select2 Selects CSS - Start */
        .select2-container--bootstrap .select2-selection--single .select2-selection__placeholder  {
            color: #555;
        }
        .select2-container--bootstrap .select2-results__option {
            color: #555;
            background-color: #fff;
        }
        .select2-container--bootstrap .select2-results__option--highlighted[aria-selected] {
            color: #fff;
            background-color: #bbb;
        }
        .select2-container--bootstrap .select2-selection--single {
            height: 36px;
            padding: 6px 18px;
            margin-left: 0px;
        }
        /* Select2 Selects CSS - End */

        #termo {
          width: 100%;
          font-size: 16px;
          padding: 12px 20px 12px 40px;
          border: 1px solid #ddd;
          margin-bottom: 12px;
        }

        .navbar-default .navbar-nav > .dropdown > a:focus, .navbar-default .navbar-nav > .dropdown > a:hover {
            color: #fff;
            background-color: #1B2E4F;
        }

        .navbar-default .navbar-nav > .open > a:focus, .navbar-default .navbar-nav > .open > a:hover {
            color: #000;
            background-color: #fff;
        }

        .navbar-default .navbar-nav > a, .navbar-default .navbar-nav > li > a {
            color: #fff;
        }

        .navbar-default .navbar-nav > li > a:hover, {
            color: #fff;
            background-color: #fff;
        }

        .dropdown-menu > li > a:hover {
            background-color: #cccccc;
        }

        .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-text {
            color: #000;
            background-color: #fff;
        }




    </style>

</head>
<body>
    @include('_mobile.layout.title')
    @include('_mobile.layout.menu')
    <div style="margin-top:5px" class="container">
        @yield('content')
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>