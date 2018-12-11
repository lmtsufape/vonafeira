@extends('layouts.app')

@section('navbar')
    <a href="/home">Painel</a> > Selecionar Grupo de Consumo
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>Seleção de Grupo de Consumo</h1></div>
                <div class="panel-body">
                    <h3>Selecione o grupo que queira fazer parte</h3>
                    </br>
                    <form class="form-horizontal" method="POST" action="{{action('ConsumidorController@cadastrar')}}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('grupoConsumo') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Grupo de Consumo</label>
                            <div class="col-md-6">
                                <select name="grupoConsumo">
                                    <option value="" selected disabled hidden>Selecione</option>
                                    @foreach($gruposConsumo as $grupoConsumo)
                                        <option value={{$grupoConsumo->id}}>{{$grupoConsumo->name}}</option>
                                    @endforeach
                                </select>
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
