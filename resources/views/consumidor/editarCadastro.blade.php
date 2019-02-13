@extends('layouts.app')

@section('titulo','Meus dados')

@section('navbar')
    <a href="{{ route("home") }}">Início</a> >
    Meus dados
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Editar Cadastro: <strong>{{$user->name}}</strong></div>

                @if (\Session::has('success'))
                    <br>
                    <div class="alert alert-success">
                        <strong>Sucesso!</strong>
                        {!! \Session::get('success') !!}
                    </div>
                
                @elseif (\Session::has('fail'))
                  <br>
                  <div class="alert alert-danger">
                      <strong>Erro!</strong>
                      {!! \Session::get('fail') !!}
                  </div>

                @endif

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route("consumidor.cadastro.atualizar") }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('id') ? ' has-error' : '' }}">
                            <div class="col-md-6">
                                <input id="id" type="hidden" class="form-control" name="user_id" value="{{ $user->id }}">
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nome</label>

                            <div class="col-md-6">
                                @if(old('name',NULL) != NULL)
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                @else
                                    <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required autofocus>
                                @endif

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-mail</label>

                            <div class="col-md-6">
                                @if(old('email',NULL) != NULL)
                                    <input id="email" type="email" class="form-control" name="email" value="{{old('email')}}">
                                @else
                                    <input id="email" type="email" class="form-control" name="email" value="{{$user->email}}">
                                @endif

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('telefone') ? ' has-error' : '' }}">
                            <label for="telefone" class="col-md-4 control-label">Telefone</label>

                            <div class="col-md-6">
                                @if(old('telefone',NULL) != NULL)
                                    <input type="text" name="telefone" id="telefone" pattern="\([0-9]{2}\) [0-9]{4,6}-[0-9]{3,4}$" placeholder="(11) 11111-1111" class="form-control"  maxlength="15" value="{{ old('telefone') }}">
                                @else
                                    <input type="text" name="telefone" id="telefone" pattern="\([0-9]{2}\) [0-9]{4,6}-[0-9]{3,4}$" placeholder="(11) 11111-1111" class="form-control"  maxlength="15" value="{{ $user->telefone }}">
                                @endif

                                @if ($errors->has('telefone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('telefone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="senha" class="col-md-4 control-label">Confirme sua senha</label>

                            <div class="col-md-6">
                                <input type="password" name="senha" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <a class="btn btn-danger" href="{{URL::previous()}}">Voltar</a>
                                <button type="submit" class="btn btn-success">Atualizar</button>
                            </div>
                        </div>
                        
                        <hr>
                        <div class="form-group">
                          <div class="col-md-6 col-md-offset-4">
                            <a class="btn btn-warning" href="{{route('consumidor.alterarSenha')}}">
                              Alterar Senha
                            </a>
                          </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


