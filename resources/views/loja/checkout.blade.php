@extends('layouts.loja')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Checkout</h1>
</div>
<table class="table table-hover">
    <thead>
        <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Valor</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php $total = 0 ?>
        @foreach($produtos as $produto)
            <?php $total += $produto->valor ?>
            <tr>
                <td>{{ $produto->produto  }}</td>
                <td>{{ $produto->quantidade  }}</td>
                <td>R$ {{  number_format($produto->valor, 2, ',', '.')  }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2"><b>Total</b></td>
            <td><b>R$ {{  number_format($total, 2, ',', '.')  }}</b></td>
        </tr>
    </tbody>
</table>
<form action="{{ route('loja.finalizar', $uuid) }}" method="post">
    @csrf
    @component('components.forms.select', [
        'id'        => 'forma_pagamento_id',
        'name'      => 'forma_pagamento_id',
        'label'     => 'Forma de Pagamento:',
        'type'      => 'text',
        'values'    => $forma_pagamentos,
        'required'  => 'required'
    ]);
    @endcomponent
<button type="submit">Fechar</button>
</form>
@endsection
