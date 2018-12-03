<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
            <title>Lista de Usuários</title>
    </head>
    <body>
    @foreach ($listaUsuarios as $user)
    	<b>Cod: {{ $user->id }}</b>: {{ $user->name}} 
		<a href="/editarUsuario/{{$user->id}}">Editar</a>
		<a href="/removerUsuario/{{$user->id}}">Remover</a>    	
    	
    	<br/>
    @endforeach
        <form action="/cadastrarUsuario" method="get">
            <input type="submit" value="Novo Cadastro" />
        </form>
    </body>
</html>