@extends('layouts.loja')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Carrinho</h1>
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
        @foreach($carrinhos as $carrinho)
            <?php $total += $carrinho->valor ?>
            <tr>
                <td>{{ $carrinho->produto  }}</td>
                <td>{{ $carrinho->quantidade  }}</td>
                <td>R$ {{  number_format($carrinho->valor, 2, ',', '.')  }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2"><b>Total</b></td>
            <td><b>R$ {{  number_format($total, 2, ',', '.')  }}</b></td>
        </tr>
    </tbody>
</table>
@if($logado)
    <form action="{{ route('loja.store') }}" method="post">
        @csrf
        @method('POST')
        <button type="submit">Fechar</button>
    </form>
@endif
@endsection
