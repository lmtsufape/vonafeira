@extends('layouts.app')

@section('titulo','Cadastro de Produtos')

@section('navbar')
    <a href="{{ route("home") }}">Início</a> >
    <a href="{{ route("grupoConsumo.listar") }}">Grupos de Consumo</a> >
    <a href="{{ route("grupoConsumo.gerenciar", ["id" => $grupoConsumo->id]) }}">Gerenciar Grupo: {{$grupoConsumo->name}}</a> >
    <a href="{{ route("produto.listar", ["idGrupoConsumo" => $grupoConsumo->id]) }}">Listar Produtos</a> >
    Adicionar
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Novo Produto</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route("produto.cadastrar") }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-6">
                                <input id="email" type="hidden" class="form-control" name="email" value="{{ Auth::user()->email }}">
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('grupoConsumo') ? ' has-error' : '' }}">
                            <div class="col-md-6">
                                <input id="grupoConsumo" type="hidden" class="form-control" name="grupoConsumo" value="{{$grupoConsumo->id}}">
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('idProdutor') ? ' has-error' : '' }}">
                            <label for="idProdutor" class="col-md-4 control-label">Produtor</label>

                            <div class="col-md-6">
                              <select id="produtor" class="form-control" name="idProdutor" autofocus>
                                <option value="" selected disabled hidden>Escolha o Produtor</option>
                                @foreach ($produtores as $produtor)
                                  @if (Illuminate\Support\Facades\Input::old('idProdutor') == $produtor->id)
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
                                <input id="nome" type="text" class="form-control" name="nome" value="{{ old('nome') }}" autofocus>

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
                                <input id="preco" type="number" step="0.01" class="form-control" name="preco" value="{{ old('preco') }}">

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
                                <select id="unidade" class="form-control" name="unidadeVenda">
                                    <option value="" selected disabled hidden>Escolha uma unidade</option>
                                    @foreach ($unidadesVenda as $unidadeVenda)
                                        @if (Illuminate\Support\Facades\Input::old('unidadeVenda') == $unidadeVenda->id)
                                            <option value="{{$unidadeVenda->id}}" selected>{{$unidadeVenda->nome}}</option>
                                        @else
                                            <option value="{{$unidadeVenda->id}}">{{$unidadeVenda->nome}}</option>
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
                                <button type="submit" class="btn btn-success">
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

<!-- Script do Select2 -->
<script src="{{ asset('js/jquery-3.3.1.min.js')}}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script type="text/javascript">
    $( "#produtor" ).select2({
        theme: "bootstrap",
        placeholder: "Selecione o produtor"
    });
</script>
<script type="text/javascript">
    $( "#unidade" ).select2({
        theme: "bootstrap",
        placeholder: "Selecione a unidade"
    });
</script>
<!-- Script do Select2 -->

@endsection
