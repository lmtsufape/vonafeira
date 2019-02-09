<div width="100%" style="text-align: center; background-color: #1B2E4F; color: white">
    @if(Auth::check())
        <li style="list-style-type: none; display: inline;" class="dropdown">
            <a style="color:white" href="{{ route("grupoConsumo.listar") }}" class="menu-principal dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                <button class="btn" style="background-color: white; color: #1B2E4F;margin: 2px 0 2px 0">Grupos de Consumo <span class="caret"></span></button>
            </a>

            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="{{ route("grupoConsumo.listar") }}">Meus Grupos de Consumo</a>
                </li>
                <li>
                    <a href="{{ route("consumidor.grupo.entrar") }}">Entrar em Grupo de Consumo</a>
                </li>
            </ul>
        </li>
        <li style="list-style-type: none; display: inline">
            <a href="{{route('loja')}}"><button class="btn" style="background-color: white; color:#1B2E4F">Loja</button></a>
        </li>
        <li style="list-style-type: none; display: inline">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <button class="btn" style="background-color:white; color:#1B2E4F">Sair</button>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>
        
    @else
        <a href="{{route('login')}}"><button class="btn" style="background-color: white; color:#1B2E4F; margin: 2px 0 2px 0">Entrar</button></a>
         
        <a href="{{route('register')}}"><button class="btn" style="background-color: white; color:#1B2E4F">Cadastrar</button></a>
    @endif
</div>