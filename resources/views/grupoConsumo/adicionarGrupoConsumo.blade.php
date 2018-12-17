@extends('layouts.app')

@section('navbar')
    <a href="/home">Painel</a> > <a href="/gruposConsumo">Grupos de Consumo</a> > Adicionar Grupo de Consumo
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Novo Grupo de Consumo</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="/cadastrarGrupoConsumo">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nome</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{old('name')}}" autofocus>

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
                                <input id="descricao" type="text" class="form-control" name="descricao" value="{{ old('descricao') }}">

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
                            <select id="periodo" class="form-control" name="periodo" autofocus>
                                    @if (old('periodo') == NULL)
                                        <option value="" selected disabled hidden>Selecionar</option>
                                    @endif

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
                                <select id="dia_semana" class="form-control" name="dia_semana" value="{{ old('dia_semana') }}" autofocus>
                                    @if (old('dia_semana') == NULL)
                                        <option value="" selected disabled hidden>Selecionar</option>
                                    @endif

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
                                </select>                                
                                @if ($errors->has('dia_semana'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dia_semana') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('dia_semana') ? ' has-error' : '' }}">
                            <label for="prazo_pedidos" class="col-md-4 control-label">Prazo Limite para Pedidos</label>

                            <div class="col-md-6">
                                <select id="prazo_pedidos" class="form-control" name="prazo_pedidos" value="{{ old('prazo_pedidos') }}" autofocus>
                                    @if (old('prazo_pedidos') == NULL)
                                        <option value="" selected disabled hidden>Selecionar</option>
                                    @endif

                                    @if (old('prazo_pedidos') == "1")
                                        <option value="1" selected>1 dia antes</option>
                                    @else
                                        <option value="1">1 dia antes</option>
                                    @endif

                                    @if (old('prazo_pedidos') == "2")
                                        <option value="2" selected>2 dias antes</option>
                                    @else
                                        <option value="2">2 dias antes</option>
                                    @endif

                                    @if (old('prazo_pedidos') == "3")
                                        <option value="3" selected>3 dias antes</option>
                                    @else
                                        <option value="3">3 dias antes</option>
                                    @endif

                                    @if (old('prazo_pedidos') == "4")
                                        <option value="4" selected>4 dias antes</option>
                                    @else
                                        <option value="4">4 dias antes</option>
                                    @endif

                                    @if (old('prazo_pedidos') == "5")
                                        <option value="5" selected>5 dias antes</option>
                                    @else
                                        <option value="5">5 dias antes</option>
                                    @endif

                                    @if (old('prazo_pedidos') == "6")
                                        <option value="6" selected>6 dias antes</option>
                                    @else
                                        <option value="6">6 dias antes</option>
                                    @endif
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