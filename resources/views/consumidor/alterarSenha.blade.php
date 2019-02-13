@extends('layouts.app')

@section('titulo','Alterar Senha')

@section('navbar')
    Alterar Senha
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Alterar Senha</div>

                <div class="panel-body">
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

                    <form class="form-horizontal" method="POST" action="{{ route('consumidor.atualizarSenha') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('senha_atual') ? ' has-error' : '' }}">
                            <label for="senha_atual" class="col-md-4 control-label">Senha atual</label>

                            <div class="col-md-6">
                                <input id="senha_atual" type="password" class="form-control" name="senha_atual" value="{{ old('senha_atual') }}" required>

                                @if ($errors->has('senha_atual'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('senha_atual') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('nova_senha') ? ' has-error' : '' }}">
                            <label for="nova_senha" class="col-md-4 control-label">Nova senha</label>

                            <div class="col-md-6">
                                <input id="nova_senha" type="password" class="form-control" name="nova_senha" value="{{ old('nova_senha') }}" required>

                                @if ($errors->has('nova_senha'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nova_senha') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('nova_senha_confirm') ? ' has-error' : '' }}">
                            <label for="nova_senha_confirm" class="col-md-4 control-label">Confirme nova senha</label>

                            <div class="col-md-6">
                                <input id="nova_senha_confirm" type="password" class="form-control" name="nova_senha_confirm" value="{{ old('nova_senha_confirm') }}" required>

                                @if ($errors->has('nova_senha_confirm'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nova_senha_confirm') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Alterar Senha
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
