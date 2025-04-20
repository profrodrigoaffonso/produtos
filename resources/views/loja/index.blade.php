@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Produtos</h1>
</div>

        <?php foreach($produtos as $produto): ?>

            <div class="col-md-3">
                {{ $produto->nome }}<br><br>
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
                <a href="{{ route('loja.detalhes', $produto->uuid) }}">Detalhe</a>
            </div>

        <?php endforeach?>

@endsection
