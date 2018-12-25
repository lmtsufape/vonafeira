@extends('layouts.app')

@section('titulo','Editar Unidade de Venda')

@section('navbar')
    <a href="/">Painel</a> >
    <a href="/gruposConsumo">Grupos de Consumo</a> >
    <a href="/gerenciar/{{$grupoConsumo->id}}">Gerenciar Grupo: {{$grupoConsumo->name}}</a> >
    <a href="/unidadesVenda/{{$grupoConsumo->id}}">Listar Unidade de Venda</a> >
    Editar: {{$unidadeVenda->nome}}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Editar Unidade de Venda</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="/atualizarUnidadeVenda">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('id') ? ' has-error' : '' }}">
                            <div class="col-md-6">
                                <input id="id" type="hidden" class="form-control" name="id" value="{{ $unidadeVenda->id }}">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                            <label for="nome" class="col-md-4 control-label">Nome</label>

                            <div class="col-md-6">
                                @if(old('nome',NULL) != NULL)
                                    <input id="nome" type="text" class="form-control" name="nome" value="{{old('nome')}}">
                                @else
                                    <input id="nome" type="text" class="form-control" name="nome" value="{{$unidadeVenda->nome}}">
                                @endif

                                @if ($errors->has('nome'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nome') }}</strong>
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
                                    <input id="descricao" type="text" class="form-control" name="descricao" value="{{$unidadeVenda->descricao}}">
                                @endif

                                @if ($errors->has('descricao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('descricao') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('is_fracionado') ? ' has-error' : '' }}">
                            <label for="is_fracionado" class="col-md-4 control-label">Fracionado</label>

                            <div class="col-md-6">
                              <select id="is_fracionado" class="form-control" name="is_fracionado">

                                @if(old('is_fracionado',NULL) != NULL)

                                  @if (old('is_fracionado') == "1")
                                      <option value="1" selected>Sim</option>
                                  @else
                                      <option value="1">Sim</option>
                                  @endif

                                  @if (old('is_fracionado') == "0")
                                      <option value="0" selected>Não</option>
                                  @else
                                      <option value="0">Não</option>
                                  @endif

                                @else



                                  @if ($unidadeVenda->is_fracionado == True)
                                      <option value="1" selected>Sim</option>
                                  @else
                                      <option value="1">Sim</option>
                                  @endif

                                  @if ($unidadeVenda->is_fracionado == False)
                                      <option value="0" selected>Não</option>
                                  @else
                                      <option value="0">Não</option>
                                  @endif

                                @endif
                              </select>

                              @if ($errors->has('is_fracionado'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('is_fracionado') }}</strong>
                                  </span>
                              @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('is_porcao') ? ' has-error' : '' }}">
                            <label for="is_porcao" class="col-md-4 control-label">Porção</label>

                            <div class="col-md-6">
                              <select id="is_porcao" class="form-control" name="is_porcao">
                                @if(old('is_porcao',NULL) != NULL)

                                  @if (old('is_porcao' == "1"))
                                      <option value="1" selected>Sim</option>
                                  @else
                                      <option value="1">Sim</option>
                                  @endif

                                  @if (old('is_porcao' == "0"))
                                      <option value="0" selected>Não</option>
                                  @else
                                      <option value="0">Não</option>
                                  @endif

                                @else
                                  @if ($unidadeVenda->is_porcao == True)
                                      <option value="1" selected>Sim</option>
                                  @else
                                      <option value="1">Sim</option>
                                  @endif

                                  @if ($unidadeVenda->is_porcao == False)
                                      <option value="0" selected>Não</option>
                                  @else
                                      <option value="0">Não</option>
                                  @endif

                                @endif
                              </select>

                              @if ($errors->has('is_porcao'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('is_porcao') }}</strong>
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
