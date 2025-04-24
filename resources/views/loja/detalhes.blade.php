@extends('layouts.loja')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">{{ $produto->nome }}</h1>
</div>

    {{ $produto->categoria }}<br><br>
    R$ {{ number_format($produto->valor, 2, ',', ',') }}<br><br>
    @component('components.forms.select', [
        'id'        => 'quantidade',
        'name'      => 'quantidade',
        'label'     => 'Quantidade:',
        'type'      => 'text',
        'values'    => $combo,
        'required'  => 'required'
    ]);
    @endcomponent
    <button onclick="adicionar('{{ $produto->uuid }}')">Adicionar</button>
    <script type="text/javascript">
        function adicionar(uuid){
            quantidade = document.getElementById('quantidade').value
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // código a ser executado em caso de sucesso
                    // console.log(this.status)
                } else if (this.readyState == 4 && this.status != 200) {
                    // código a ser executado em caso de erro
                }
            };
            xhttp.open("GET", "/loja/" + uuid + "/" + quantidade + "/adicionar", true);
            xhttp.send();
        }

    </script>
@endsection
