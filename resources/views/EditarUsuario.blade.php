<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Edição de Usuário</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
    <h1> Editar Usuário</h1>
    <form action="/salvarUsuario" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token()}}" />
        <input type="hidden" name="id" value="{{ $user->id}}" />
        <div>
            Nome: <input type="text" name="name" value="{{ $user->name}}" required/>
        </div>
        <div>
            Telefone: <input  type="text" name="telefone" id="telefone" pattern="\([0-9]{2}\) [0-9]{4,6}-[0-9]{3,4}$" placeholder="(87) 91111-1111" class="form-control"  maxlength="15" value="{{ $user->telefone}}" required >
        </div>
        <div>
            Email: <input type="email" name="email" value="{{ $user->email}}" required/>
        </div>
        <div>
            Senha: <input type="password" name="password" value="{{ $user->password}}" required/>
        </div>
        <div>
            <input type="submit" value="Alterar" />
        </div>
    </form>
</body>
</html>
