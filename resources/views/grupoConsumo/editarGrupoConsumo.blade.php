


@extends('layouts.app')

@section('navbar')
    <a href="/home">Painel</a> > <a href="/gruposConsumo">Grupos de Consumo</a> > <a href="/gerenciar/{{$grupoConsumo->id}}">Gerenciar Grupo: {{$grupoConsumo->name}}</a> > Editar
@endsection

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
                                @if(old('name',NULL) != NULL)
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                @else
                                    <input id="name" type="text" class="form-control" name="name" value="{{ $grupoConsumo->name }}" required autofocus>
                                @endif

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
                                @if(old('descricao',NULL) != NULL)
                                    <input id="descricao" type="text" class="form-control" name="descricao" value="{{old('descricao')}}">
                                @else
                                    <input id="descricao" type="text" class="form-control" name="descricao" value="{{$grupoConsumo->descricao}}">
                                @endif

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
                                
                                @if(old('periodo',NULL) != NULL)

                                    @if (old('periodo') == "Semanal")
                                            <option value="Semanal" selected>Semanal</option>
                                    @else
                                            <option value="Semanal">Semanal</option>
                                    @endif

                                    @if (old('periodo') == "Quinzenal")
                                        <option value="Quinzenal" selected>Quinzenal</option>
                                    @else
                                        <option value="Quinzenal">Quinzenal</option>
                                    @endif

                                    @if (old('periodo') == "Mensal")
                                        <option value="Mensal" selected>Mensal</option>
                                    @else
                                        <option value="Mensal">Mensal</option>
                                    @endif

                                    @if (old('periodo') == "Bimestral")
                                        <option value="Bimestral" selected>Bimestral</option>
                                    @else
                                        <option value="Bimestral">Bimestral</option>
                                        @endif

                                    </select>

                                @else

                                @if ($grupoConsumo->periodo == "Semanal")
                                        <option value="Semanal" selected>Semanal</option>
                                @else
                                        <option value="Semanal">Semanal</option>
                                @endif

                                @if ($grupoConsumo->periodo == "Quinzenal")
                                    <option value="Quinzenal" selected>Quinzenal</option>
                                @else
                                    <option value="Quinzenal">Quinzenal</option>
                                @endif

                                @if ($grupoConsumo->periodo == "Mensal")
                                    <option value="Mensal" selected>Mensal</option>
                                @else
                                    <option value="Mensal">Mensal</option>
                                @endif

                                @if ($grupoConsumo->periodo == "Bimestral")
                                    <option value="Bimestral" selected>Bimestral</option>
                                @else
                                    <option value="Bimestral">Bimestral</option>
                                    @endif

                                </select>

                                @endif

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
                                    
                                    @if(old('dia_semana',NULL) != NULL)

                                        @if (old('dia_semana') == "Domingo")
                                            <option value="Domingo" selected>Domingo</option>
                                        @else
                                            <option value="Domingo">Domingo</option>
                                        @endif

                                        @if (old('dia_semana') == "Segunda-feira")
                                            <option value="Segunda-feira" selected>Segunda-feira</option>
                                        @else
                                            <option value="Segunda-feira">Segunda-feira</option>
                                        @endif

                                        @if (old('dia_semana') == "Terça-feira")
                                            <option value="Terça-feira" selected>Terça-feira</option>
                                        @else
                                            <option value="Terça-feira">Terça-feira</option>
                                        @endif

                                        @if (old('dia_semana') == "Quarta-feira")
                                            <option value="Quarta-feira" selected>Quarta-feira</option>
                                        @else
                                            <option value="Quarta-feira">Quarta-feira</option>
                                        @endif

                                        @if (old('dia_semana') == "Quinta-feira")
                                            <option value="Quinta-feira" selected>Quinta-feira</option>
                                        @else
                                            <option value="Quinta-feira">Quinta-feira</option>
                                        @endif

                                        @if (old('dia_semana') == "Sexta-feira")
                                            <option value="Sexta-feira" selected>Sexta-feira</option>
                                        @else
                                            <option value="Sexta-feira">Sexta-feira</option>
                                        @endif

                                        @if (old('dia_semana') == "Sábado")
                                            <option value="Sábado" selected>Sábado</option>
                                        @else
                                            <option value="Sábado">Sábado</option>
                                        @endif

                                    @else

                                        @if ($grupoConsumo->dia_semana == "Domingo")
                                            <option value="Domingo" selected>Domingo</option>
                                        @else
                                            <option value="Domingo">Domingo</option>
                                        @endif

                                        @if ($grupoConsumo->dia_semana == "Segunda-feira")
                                            <option value="Segunda-feira" selected>Segunda-feira</option>
                                        @else
                                            <option value="Segunda-feira">Segunda-feira</option>
                                        @endif

                                        @if ($grupoConsumo->dia_semana == "Terça-feira")
                                            <option value="Terça-feira" selected>Terça-feira</option>
                                        @else
                                            <option value="Terça-feira">Terça-feira</option>
                                        @endif

                                        @if ($grupoConsumo->dia_semana == "Quarta-feira")
                                            <option value="Quarta-feira" selected>Quarta-feira</option>
                                        @else
                                            <option value="Quarta-feira">Quarta-feira</option>
                                        @endif

                                        @if ($grupoConsumo->dia_semana == "Quinta-feira")
                                            <option value="Quinta-feira" selected>Quinta-feira</option>
                                        @else
                                            <option value="Quinta-feira">Quinta-feira</option>
                                        @endif

                                        @if ($grupoConsumo->dia_semana == "Sexta-feira")
                                            <option value="Sexta-feira" selected>Sexta-feira</option>
                                        @else
                                            <option value="Sexta-feira">Sexta-feira</option>
                                        @endif

                                        @if ($grupoConsumo->dia_semana == "Sábado")
                                            <option value="Sábado" selected>Sábado</option>
                                        @else
                                            <option value="Sábado">Sábado</option>
                                        @endif

                                    @endif

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
                                    
                                    @if(old('prazo_pedidos',NULL) != NULL)

                                        @if (old('prazo_pedidos') == 1)
                                            <option value="1" selected>1 dia antes</option>
                                        @else
                                            <option value="1">1 dia antes</option>
                                        @endif

                                        @if (old('prazo_pedidos') == 2)
                                            <option value="2" selected>2 dias antes</option>
                                        @else
                                            <option value="2">2 dias antes</option>
                                        @endif

                                        @if (old('prazo_pedidos') == 3)
                                            <option value="3" selected>3 dias antes</option>
                                        @else
                                            <option value="3">3 dias antes</option>
                                        @endif

                                        @if (old('prazo_pedidos') == 4)
                                            <option value="4" selected>4 dias antes</option>
                                        @else
                                            <option value="4">4 dias antes</option>
                                        @endif

                                        @if (old('prazo_pedidos') == 5)
                                            <option value="5" selected>5 dias antes</option>
                                        @else
                                            <option value="5">5 dias antes</option>
                                        @endif
                                    
                                        @if (old('prazo_pedidos') == 6)
                                            <option value="6" selected>6 dias antes</option>
                                        @else
                                            <option value="6">6 dias antes</option>
                                        @endif

                                    @else

                                        @if ($grupoConsumo->prazo_pedidos == 1)
                                            <option value="1" selected>1 dia antes</option>
                                        @else
                                            <option value="1">1 dia antes</option>
                                        @endif

                                        @if ($grupoConsumo->prazo_pedidos == 2)
                                            <option value="2" selected>2 dias antes</option>
                                        @else
                                            <option value="2">2 dias antes</option>
                                        @endif

                                        @if ($grupoConsumo->prazo_pedidos == 3)
                                            <option value="3" selected>3 dias antes</option>
                                        @else
                                            <option value="3">3 dias antes</option>
                                        @endif

                                        @if ($grupoConsumo->prazo_pedidos == 4)
                                            <option value="4" selected>4 dias antes</option>
                                        @else
                                            <option value="4">4 dias antes</option>
                                        @endif

                                        @if ($grupoConsumo->prazo_pedidos == 5)
                                            <option value="5" selected>5 dias antes</option>
                                        @else
                                            <option value="5">5 dias antes</option>
                                        @endif
                                    
                                        @if ($grupoConsumo->prazo_pedidos == 6)
                                            <option value="6" selected>6 dias antes</option>
                                        @else
                                            <option value="6">6 dias antes</option>
                                        @endif

                                    @endif

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