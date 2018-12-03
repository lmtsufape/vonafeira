


@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Editar Grupo de Consumo</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{action('GrupoConsumoController@atualizar')}}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('id') ? ' has-error' : '' }}">
                            <div class="col-md-6">
                                <input id="id" type="hidden" class="form-control" name="id" value="{{ $grupoConsumo->id }}">
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nome</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $grupoConsumo->name }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('descricao') ? ' has-error' : '' }}">
                            <label for="descricao" class="col-md-4 control-label">Descrição</label>

                            <div class="col-md-6">
                                <input id="descricao" type="text" class="form-control" name="descricao" value="{{$grupoConsumo->descricao}}" required autofocus>

                                @if ($errors->has('descricao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('descricao') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('periodo') ? ' has-error' : '' }}">
                            <label for="periodo" class="col-md-4 control-label">Período</label>

                            <div class="col-md-6">
                            <select id="periodo" class="form-control" name="periodo" required autofocus>
                            <option value="" selected disabled hidden>Selecionar</option>
					                <option value="Semanal">Semanal</option>
                                    <option value="Quinzenal">Quinzenal</option>
                                    <option value="Mensal">Mensal</option>
                                    <option value="Bimestral">Bimestral</option>
                                </select>
                                @if ($errors->has('periodo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('periodo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('dia_semana') ? ' has-error' : '' }}">
                            <label for="dia_semana" class="col-md-4 control-label">Dia do Evento</label>

                            <div class="col-md-6">
                                <select id="dia_semana" class="form-control" name="dia_semana" required autofocus>
                                    <option value="" selected disabled hidden>Selecionar</option>
 					                <option value="Domingo">Domingo</option>
					                <option value="Segunda-feira">Segunda-feira</option>
                                    <option value="Terça-feira">Terça-feira</option>
                                    <option value="Quarta-feira">Quarta-feira</option>
                                    <option value="Quinta-feira">Quinta-feira</option>
                                    <option value="Sexta-feira">Sexta-feira</option>
                                    <option value="Sábado">Sábado</option>
                                </select>   
                                @if ($errors->has('periodo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('periodo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('dia_semana') ? ' has-error' : '' }}">
                            <label for="prazo_pedidos" class="col-md-4 control-label">Prazo Limite para Pedidos</label>

                            <div class="col-md-6">
                                <select id="prazo_pedidos" class="form-control" name="prazo_pedidos" required autofocus>
                                    <option value="" selected disabled hidden>Selecionar</option>
 					                <option value="1">1 dia antes</option>
					                <option value="2">2 dias antes</option>
                                    <option value="3">3 dias antes</option>
                                    <option value="4">4 dias antes</option>
                                    <option value="5">5 dias antes</option>
                                    <option value="6">6 dias antes</option>
                                </select>
                                </select>
                                @if ($errors->has('prazo_pedidos'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('prazo_pedidos') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <a class="btn btn-danger" href="{{URL::previous()}}">Voltar</a>
                                <button type="submit" class="btn btn-primary">
                                    Atualizar
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