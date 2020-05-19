@extends('layouts.app')

@section('titulo','Meus dados')

@section('navbar')
    <a href="{{ route("home") }}">Início</a> >
    Meus dados
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dados de: <strong>{{$user->name}}</strong></div>

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

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route("consumidor.cadastro.atualizar") }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('id') ? ' has-error' : '' }}">
                            <div class="col-md-6">
                                <input id="id" type="hidden" class="form-control" name="user_id" value="{{ $user->id }}">
                            </div>
                        </div>

                        <div class="form-group row justify-content-center  {{ $errors->has('email') ? ' has-error' : '' }}">
                        
                            <div class="col-md-8 col-md-offset-2">
                               
                            <label for="email" class="col-md control-label">E-mail</label>
                                
                                @if(old('email',NULL) != NULL)
                                    <input id="email" type="email" class="form-control" name="email" value="{{old('email')}}">
                                @else
                                    <input id="email" type="email" class="form-control" name="email" value="{{$user->email}}">
                                @endif

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row justify-content-center {{ $errors->has('name') ? ' has-error' : '' }}">
                        
                            <div class="col-md-8 col-md-offset-2">
                            <label for="name" class="col-md control-label">Nome</label>

                                
                                @if(old('name',NULL) != NULL)
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autofocus>
                                @else
                                    <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" autofocus>
                                @endif

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group  {{ $errors->has('telefone') || $errors->has('cep')? ' has-error' : '' }}">
                            
                            <div class="col-md-4 col-md-offset-2">
                                <label for="telefone" class="col-md control-label">Telefone</label>


                                @if(old('telefone',NULL) != NULL)
                                    <input type="text" name="telefone" id="telefone" placeholder="(11) 11111-1111" class="form-control"  maxlength="15" value="{{ old('telefone') }}">
                                @else
                                    <input type="text" name="telefone" id="telefone" placeholder="(11) 11111-1111" class="form-control"  maxlength="15" value="{{ $user->telefone }}">
                                @endif

                                @if ($errors->has('telefone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('telefone') }}</strong>
                                    </span>
                                @endif
                            </div>

                <!-- ADICIONANDO ENDEREÇO AO USUARIO -->

                            <div class="col-md-4 ">
                                <label for="cep" class="col-md control-label">{{ __('CEP') }}</label>

                                @if(old('cep',NULL) != NULL)
                                    <input onblur="pesquisacep(this.value);" value="{{old('cep')}}" id="cep" type="text" class="form-control @error('cep') is-invalid @enderror" name="cep"  autocomplete="cep" >
                                @else
                                
                                    <input onblur="pesquisacep(this.value);" value="{{ $user->endereco != null ? $user->endereco->cep : '' }}" id="cep" type="text" class="form-control @error('cep') is-invalid @enderror" name="cep"  autocomplete="cep">
                                @endif

                                @if ($errors->has('cep'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cep') }}</strong>
                                    </span>
                                @endif
                            
                            </div>
                        </div>

                        <div class="form-group row justify-content-center {{  $errors->has('rua') || $errors->has('numero') ? ' has-error' : '' }}">

                            

                            <div class="col-md-6 col-md-offset-2">
                                <label for="rua" class="col-form-label">{{ __('Rua') }}</label>

                                @if(old('rua',NULL) != NULL)
                                    <input value="{{old('rua')}}" id="rua" type="text" class="form-control @error('rua') is-invalid @enderror" name="rua"  autocomplete="new-password">
                                @else
                                    <input value="{{ $user->endereco != null ? $user->endereco->rua : '' }}" id="rua" type="text" class="form-control @error('rua') is-invalid @enderror" name="rua"  autocomplete="new-password">
                                @endif

                                @if ($errors->has('rua'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('rua') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-2">
                                <label for="numero" class="col-form-label">{{ __('Número') }}</label>

                                    @if(old('numero',NULL) != NULL)
                                        <input value="{{old('numero')}}" id="numero" type="number" class="form-control @error('numero') is-invalid @enderror" name="numero"  autocomplete="numero">
                                    @else
                                        <input value="{{ $user->endereco != null ? $user->endereco->numero : '' }}" id="numero" type="number" class="form-control @error('numero') is-invalid @enderror" name="numero"  autocomplete="numero">
                                    @endif

                                    @if ($errors->has('numero'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('numero') }}</strong>
                                        </span>
                                    @endif
                            </div>

                            
                        </div>

                        <div class="form-group row justify-content-center {{ $errors->has('bairro') ? ' has-error' : '' }}">
                        
                            <div class="col-md-8 col-md-offset-2">
                            <label for="bairro" class="col-md control-label">Bairro</label>

                                
                                @if(old('name',NULL) != NULL)
                                    <input id="bairro" type="text" class="form-control" name="bairro" value="{{ old('bairro') }}" autofocus>
                                @else
                                    <input id="bairro" type="text" class="form-control" name="bairro" value="{{ $user->endereco != null ? $user->endereco->bairro : '' }}" autofocus>
                                @endif

                                @if ($errors->has('bairro'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('bairro') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row justify-content-center {{ $errors->has('cidade') || $errors->has('uf') ? ' has-error' : '' }}">
                            

                            <div class="col-md-4 col-md-offset-2">
                                <label for="cidade" class="col-form-label">{{ __('Cidade') }}</label>

                                @if(old('cidade',NULL) != NULL)
                                    <input value="{{old('cidade')}}" id="cidade" type="text" class="form-control @error('cidade') is-invalid @enderror" name="cidade"  autocomplete="cidade">
                                @else
                                    <input value="{{ $user->endereco != null ? $user->endereco->cidade : '' }}" id="cidade" type="text" class="form-control @error('cidade') is-invalid @enderror" name="cidade"  autocomplete="cidade">
                                @endif

                                @if ($errors->has('cidade'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cidade') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-sm-4">
                                <label for="uf" class="col-form-label">{{ __('UF') }}</label>
                                <select class="form-control @error('uf') is-invalid @enderror" id="uf" name="uf" ">
                                    <option value="" disabled selected hidden>-- UF --</option>
                                    <option value="AC" {{ ($user->endereco != null && $user->endereco->uf == "AC") ? "selected" : ""}}>Acre</option>
                                    <option value="AL" {{ ($user->endereco != null && $user->endereco->uf == "AL") ? "selected" : ""}}>Alagoas</option>
                                    <option value="AP" {{ ($user->endereco != null && $user->endereco->uf == "AP") ? "selected" : ""}}>Amapá</option>
                                    <option value="AM" {{ ($user->endereco != null && $user->endereco->uf == "AM") ? "selected" : ""}}>Amazonas</option>
                                    <option value="BA" {{ ($user->endereco != null && $user->endereco->uf == "BA") ? "selected" : ""}}>Bahia</option>
                                    <option value="CE" {{ ($user->endereco != null && $user->endereco->uf == "CE") ? "selected" : ""}}>Ceará</option>
                                    <option value="DF" {{ ($user->endereco != null && $user->endereco->uf == "DF") ? "selected" : ""}}>Distrito Federal</option>
                                    <option value="ES" {{ ($user->endereco != null && $user->endereco->uf == "ES") ? "selected" : ""}}>Espírito Santo</option>
                                    <option value="GO" {{ ($user->endereco != null && $user->endereco->uf == "GO") ? "selected" : ""}}>Goiás</option>
                                    <option value="MA" {{ ($user->endereco != null && $user->endereco->uf == "MA") ? "selected" : ""}}>Maranhão</option>
                                    <option value="MT" {{ ($user->endereco != null && $user->endereco->uf == "MT") ? "selected" : ""}}>Mato Grosso</option>
                                    <option value="MS" {{ ($user->endereco != null && $user->endereco->uf == "MS") ? "selected" : ""}}>Mato Grosso do Sul</option>
                                    <option value="MG" {{ ($user->endereco != null && $user->endereco->uf == "MG") ? "selected" : ""}}>Minas Gerais</option>
                                    <option value="PA" {{ ($user->endereco != null && $user->endereco->uf == "PA") ? "selected" : ""}}>Pará</option>
                                    <option value="PB" {{ ($user->endereco != null && $user->endereco->uf == "PB") ? "selected" : ""}}>Paraíba</option>
                                    <option value="PR" {{ ($user->endereco != null && $user->endereco->uf == "PR") ? "selected" : ""}}>Paraná</option>
                                    <option value="PE" {{ ($user->endereco != null && $user->endereco->uf == "PE") ? "selected" : ""}}>Pernambuco</option>
                                    <option value="PI" {{ ($user->endereco != null && $user->endereco->uf == "PI") ? "selected" : ""}}>Piauí</option>
                                    <option value="RJ" {{ ($user->endereco != null && $user->endereco->uf == "RJ") ? "selected" : ""}}>Rio de Janeiro</option>
                                    <option value="RN" {{ ($user->endereco != null && $user->endereco->uf == "RN") ? "selected" : ""}}>Rio Grande do Norte</option>
                                    <option value="RS" {{ ($user->endereco != null && $user->endereco->uf == "RS") ? "selected" : ""}}>Rio Grande do Sul</option>
                                    <option value="RO" {{ ($user->endereco != null && $user->endereco->uf == "RO") ? "selected" : ""}}>Rondônia</option>
                                    <option value="RR" {{ ($user->endereco != null && $user->endereco->uf == "RR") ? "selected" : ""}}>Roraima</option>
                                    <option value="SC" {{ ($user->endereco != null && $user->endereco->uf == "SC") ? "selected" : ""}}>Santa Catarina</option>
                                    <option value="SP" {{ ($user->endereco != null && $user->endereco->uf == "SP") ? "selected" : ""}}>São Paulo</option>
                                    <option value="SE" {{ ($user->endereco != null && $user->endereco->uf == "SE") ? "selected" : ""}}>Sergipe</option>
                                    <option value="TO" {{ ($user->endereco != null && $user->endereco->uf == "TO") ? "selected" : ""}}>Tocantins</option>
                                </select>

                                @if ($errors->has('uf'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('uf') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>
          
         <!-- TERMINANDO ENDEREÇO DO USUÁRIO-->
                        </br>
                        <div class="form-group{{ $errors->has('senha') ? ' has-error' : '' }}">
                            <label for="senha" class="col-md-3 col-md-offset-2 control-label">Confirme sua senha</label>

                            <div class="col-md-5">
                                <input type="password" name="senha" class="form-control">

                                @if ($errors->has('senha'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('senha') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                        </div>

                        </br>
                        <div align ="center" class="form-group">
                            <div >
                                <a class="btn btn-danger" href="{{ route("home") }}">Retornar</a>
                            
                                <button type="submit" class="btn btn-success">Atualizar</button>
                            </div>
                        </div>

                        <hr>
                        
                          <div align ="center">
                            <a class="btn btn-warning" href="{{route('consumidor.alterarSenha')}}">
                              Alterar Senha
                            </a>
                          </div>
                     

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- INICIO SESSÃO SCRIPTS JS -->
@section('javascript')


<script type="text/javascript">

Enable = function(val)
{
    var sbmt = document.getElementById("submit");

    if(val.checked == true){
        sbmt.disabled = false;
    }else{
        sbmt.disabled = true;
    }

    
}

console.log("dentro da sessão js")

function limpa_formulário_cep() {
        //Limpa valores do formulário de cep.
        document.getElementById('rua').value=("");
        document.getElementById('bairro').value=("");
        document.getElementById('cidade').value=("");
        document.getElementById('uf').value=("");
}

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('rua').value=(conteudo.logradouro);
        document.getElementById('bairro').value=(conteudo.bairro);
        document.getElementById('cidade').value=(conteudo.localidade);
        document.getElementById('uf').value=(conteudo.uf);

    } //end if.
    else {
        //CEP não Encontrado.
        limpa_formulário_cep();
        alert("CEP não encontrado.");
    }
}

function pesquisacep(valor) {

    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('rua').value="...";
            document.getElementById('bairro').value="...";
            document.getElementById('cidade').value="...";
            document.getElementById('uf').value="...";


            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep();
            alert("Formato de CEP inválido.");
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep();
    }
};


</script>
@endsection

<!-- FIM SESSÃO SCRIPTS JS -->
