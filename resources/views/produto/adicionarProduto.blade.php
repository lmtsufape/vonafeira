@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Novo Produto</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="/cadastrarProduto">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-6">
                                <input id="email" type="hidden" class="form-control" name="email" value="{{ Auth::user()->email }}">
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('grupoConsumo') ? ' has-error' : '' }}">
                            <div class="col-md-6">
                                <input id="grupoConsumo" type="hidden" class="form-control" name="grupoConsumo" value="{{$idGrupoConsumo}}">
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('nomeProdutor') ? ' has-error' : '' }}">
                            <label for="nomeProdutor" class="col-md-4 control-label">Nome do Produtor</label>

                            <div class="col-md-6">
                                <input id="nomeProdutor" type="text" class="form-control" name="nomeProdutor" value="{{ old('nomeProdutor') }}" required autofocus>

                                @if ($errors->has('nomeProdutor'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nomeProdutor') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                            <label for="nome" class="col-md-4 control-label">Nome do Produto</label>

                            <div class="col-md-6">
                                <input id="nome" type="text" class="form-control" name="nome" value="{{ old('nome') }}" required autofocus>

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
                                <input id="descricao" type="text" class="form-control" name="descricao" value="{{ old('descricao') }}" autofocus>

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
                                <input id="preco" type="number" min="0" step="0.01" class="form-control" name="preco" value="{{ old('preco') }}" required autofocus>

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
                                <select name="unidadeVenda">
                                    <option value="" selected disabled hidden>Escolha uma unidade</option>
                                    @foreach ($unidadesVenda as $unidadeVenda)
                                        <option value={{$unidadeVenda->id}}>{{$unidadeVenda->nome}}</option>
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