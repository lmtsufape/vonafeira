@extends('layouts.app')

@section('titulo','Registrar')

@section('navbar')
    Registrar
@endsection



@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Registro</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            
                            <div class="col-md-8 col-md-offset-2">
                                <label for="name" class="col-md control-label">Nome</label>

                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            
                            <div class="col-md-8 col-md-offset-2">
                                <label for="email" class="col-md control-label">E-Mail</label>

                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('telefone') || $errors->has('cep') ? ' has-error' : '' }}">
                            
                            <div class="col-md-4 col-md-offset-2">
                                <label for="telefone" class="col-md control-label">Telefone</label>

                                <input  type="digit" name="telefone" id="telefone" minlength="10" placeholder="DDD+Telefone" class="form-control"  maxlength="15" value="{{ old('telefone') }}">

                                @if ($errors->has('telefone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('telefone') }}</strong>
                                    </span>
                                @endif
                            </div>

                            
                            <div class="col-md-4">
                                <label for="cep" class="col-md control-label">{{ __('CEP') }}</label>

                                <input value="{{old('cep')}}" onblur="pesquisacep(this.value);" id="cep" type="text" autocomplete="cep" name="cep" autofocus class="form-control field__input a-field__input" placeholder="CEP" size="10" maxlength="9" >
                                
                                @if ($errors->has('cep'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cep') }}</strong>
                                    </span>
                                @endif

                            </div>
                           
                        </div>

                    <!-- ADICIONANDO ENDEREÇO AO USUARIO -->


                    

                        <div class="form-group row {{ $errors->has('rua') || $errors->has('numero')  ? 'has-error' : '' }}">
                            <div class="col-md-6 col-md-offset-2">
                                <label for="rua" class="col-form-label">{{ __('Rua') }}</label>
                                <input value="{{old('rua')}}" id="rua" type="text" class="form-control @error('rua') is-invalid @enderror" name="rua" autocomplete="new-password">

                                @if ($errors->has('rua'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('rua') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-2">
                                <label for="numero" class="col-form-label">{{ __('Número') }}</label>
                                <input value="{{old('numero')}}" id="numero" type="text" class="form-control @error('numero') is-invalid @enderror" name="numero" autocomplete="numero">

                                @if ($errors->has('numero'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('numero') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row justify-content-center {{ $errors->has('bairro') ? ' has-error' : '' }}">
                        
                            <div class="col-md-8 col-md-offset-2">
                                <label for="bairro" class="col-md control-label">{{ __('Bairro') }}</label>
                                <input value="{{old('bairro')}}" id="bairro" type="text" class="form-control @error('bairro') is-invalid @enderror" name="bairro" autocomplete="bairro">

                                @if ($errors->has('bairro'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('bairro') }}</strong>
                                    </span>
                                @endif
                            </div>


                        </div>

                    <div class="form-group row {{ $errors->has('cidade') || $errors->has('uf') ? ' has-error' : '' }}">

                        <div class="col-md-4 col-md-offset-2">
                            <label for="cidade" class="col-form-label">{{ __('Cidade') }}</label>
                            <input value="{{old('cidade')}}" id="cidade" type="text" class="form-control @error('cidade') is-invalid @enderror" name="cidade" autocomplete="cidade">

                            @if ($errors->has('cidade'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('cidade') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-sm-4">
                            <label for="uf" class="col-form-label">{{ __('UF') }}</label>
                            {{-- <input id="uf" type="text" class="form-control @error('uf') is-invalid @enderror" name="uf" value="{{ old('uf') }}" autocomplete="uf" autofocus> --}}
                            <select class="form-control @error('uf') is-invalid @enderror" id="uf" name="uf">
                                <option value="" selected hidden>-- UF --</option>
                                <option @if(old('uf') == 'AC') selected @endif value="AC">Acre</option>
                                <option @if(old('uf') == 'AL') selected @endif value="AL">Alagoas</option>
                                <option @if(old('uf') == 'AP') selected @endif value="AP">Amapá</option>
                                <option @if(old('uf') == 'AM') selected @endif value="AM">Amazonas</option>
                                <option @if(old('uf') == 'BA') selected @endif value="BA">Bahia</option>
                                <option @if(old('uf') == 'CE') selected @endif value="CE">Ceará</option>
                                <option @if(old('uf') == 'DF') selected @endif value="DF">Distrito Federal</option>
                                <option @if(old('uf') == 'ES') selected @endif value="ES">Espírito Santo</option>
                                <option @if(old('uf') == 'GO') selected @endif value="GO">Goiás</option>
                                <option @if(old('uf') == 'MA') selected @endif value="MA">Maranhão</option>
                                <option @if(old('uf') == 'MT') selected @endif value="MT">Mato Grosso</option>
                                <option @if(old('uf') == 'MS') selected @endif value="MS">Mato Grosso do Sul</option>
                                <option @if(old('uf') == 'MG') selected @endif value="MG">Minas Gerais</option>
                                <option @if(old('uf') == 'PA') selected @endif value="PA">Pará</option>
                                <option @if(old('uf') == 'PB') selected @endif value="PB">Paraíba</option>
                                <option @if(old('uf') == 'PR') selected @endif value="PR">Paraná</option>
                                <option @if(old('uf') == 'PE') selected @endif value="PE">Pernambuco</option>
                                <option @if(old('uf') == 'PI') selected @endif value="PI">Piauí</option>
                                <option @if(old('uf') == 'RJ') selected @endif value="RJ">Rio de Janeiro</option>
                                <option @if(old('uf') == 'RN') selected @endif value="RN">Rio Grande do Norte</option>
                                <option @if(old('uf') == 'RS') selected @endif value="RS">Rio Grande do Sul</option>
                                <option @if(old('uf') == 'RO') selected @endif value="RO">Rondônia</option>
                                <option @if(old('uf') == 'RR') selected @endif value="RR">Roraima</option>
                                <option @if(old('uf') == 'SC') selected @endif value="SC">Santa Catarina</option>
                                <option @if(old('uf') == 'SP') selected @endif value="SP">São Paulo</option>
                                <option @if(old('uf') == 'SE') selected @endif value="SE">Sergipe</option>
                                <option @if(old('uf') == 'TO') selected @endif value="TO">Tocantins</option>
                            </select>

                            @if ($errors->has('uf'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('uf') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- TERMINANDO ENDEREÇO DO USUÁRIO-->

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-3 col-md-offset-2 control-label">Senha</label>

                            <div class="col-md-5">
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-3 col-md-offset-2 control-label">Confirme a Senha</label>

                            <div class="col-md-5">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" onchange="Enable(this)" id="termos" >Li e aceito os <a href="{{ route("termos") }}" target="_blank">termos de uso.</a></input>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" align="center">
                            <div class="col-md ">
                                <button id="submit" type="submit" class="btn btn-primary" disabled>
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