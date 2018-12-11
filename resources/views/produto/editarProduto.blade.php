@extends('layouts.app')

@section('navbar')
    <a href="/home">Painel</a> > <a href="/gruposConsumo">Grupos de Consumo</a> > <a href="/gerenciar/{{$grupoConsumo->id}}">Gerenciar Grupo: {{$grupoConsumo->name}}</a> > Editar: {{$produto->nome}}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Editar Produto</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="/atualizarProduto">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('id') ? ' has-error' : '' }}">
                            <div class="col-md-6">
                                <input id="id" type="hidden" class="form-control" name="id" value="{{ $produto->id }}">
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('grupoConsumo') ? ' has-error' : '' }}">
                            <div class="col-md-6">
                                <input id="grupoConsumo" type="hidden" class="form-control" name="grupoConsumo" value="1">
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('idProdutor') ? ' has-error' : '' }}">
                            <label for="idProdutor" class="col-md-4 control-label">Produtor</label>

                            <div class="col-md-6">
                            <select id="idProdutor" class="form-control" name="idProdutor" autofocus>
                              <option value="" selected disabled hidden>Escolha o Produtor</option>
                              @foreach ($produtores as $produtor)
                                @if (Illuminate\Support\Facades\Input::old('idProdutor') == $produtor->nome)
                                    <option value="{{$produtor->id}}" selected>{{$produtor->nome}}</option>
                                @else
                                    <option value="{{$produtor->id}}">{{$produtor->nome}}</option>
                                @endif
                              @endforeach
                            </select>

                            @if ($errors->has('idProdutor'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('idProdutor') }}</strong>
                                </span>
                            @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                            <label for="nome" class="col-md-4 control-label">Nome do Produto</label>

                            <div class="col-md-6">
                                <input id="nome" type="text" class="form-control" name="nome" value="{{$produto->nome}}" required autofocus>

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
                                <input id="descricao" type="text" class="form-control" name="descricao" value="{{$produto->descricao}}" autofocus>

                                @if ($errors->has('descricao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('descricao') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('preco') ? ' has-error' : '' }}">
                            <label for="preco" class="col-md-4 control-label">Preço</label>

                            <div class="col-md-6">
                                <input id="preco" type="number" min="0" step="0.01" class="form-control" name="preco" value="{{$produto->preco}}" required autofocus>

                                @if ($errors->has('preco'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('preco') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('unidadeVenda') ? ' has-error' : '' }}">
                            <label for="unidadeVenda" class="col-md-4 control-label">Unidade de Venda</label>

                            <div class="col-md-6">
                                <select name="unidadeVenda" required autofocus>
                                    <option value="" selected disabled hidden>Escolha uma unidade</option>
                                    @foreach ($unidadesVenda as $unidadeVenda)
                                        @if($produto->unidadeVenda->id == $unidadeVenda->id)
                                            <option value={{$unidadeVenda->id}} selected>{{$unidadeVenda->nome}}</option>
                                        @else
                                            <option value={{$unidadeVenda->id}} selected>{{$unidadeVenda->nome}}</option>
                                        @endif
                                    @endforeach
                                </select>


                                @if ($errors->has('unidadeVenda'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('unidadeVenda') }}</strong>
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
