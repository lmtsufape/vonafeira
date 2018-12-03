@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Adicionar Consumidor</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="/cadastrarConsumidor">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-6">
                                <input id="email" type="hidden" class="form-control" name="email" value="{{ Auth::user()->email }}">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('usuario') ? ' has-error' : '' }}">
                            <label for="u" class="col-md-4 control-label">Usuário</label>

                            <div class="col-md-6">
                                <select name="usuario">
                                    <option value="" selected disabled hidden>Escolha um usuário</option>
                                    @foreach ($users as $usuario)
                                        <option value={{$usuario->id}}>{{$usuario->name}}</option>
                                    @endforeach
                                </select>


                                @if ($errors->has('usuario'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('usuario') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('grupoConsumo') ? ' has-error' : '' }}">
                            <label for="grupoConsumo" class="col-md-4 control-label">Grupo de Consumo</label>

                            <div class="col-md-6">
                                <select name="grupoConsumo">
                                    <option value="" selected disabled hidden>Escolha um grupo de consumo</option>
                                    @foreach ($gruposConsumo as $grupoConsumo)
                                        <option value={{$grupoConsumo->id}}>{{$grupoConsumo->name}}</option>
                                    @endforeach
                                </select>


                                @if ($errors->has('grupoConsumo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('grupoConsumo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Cadastrar
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