@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Produtos</h1>
</div>
<a href="{{ route('admin.produto.create') }}" class="btn btn-primary">Novo</a>
<table class="table table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Categoria</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($produtos as $produto): ?>
            <tr>
                <td>{{ $produto->id }}</td>
                <td>{{ $produto->nome  }}</td>
                <td>{{ $produto->categoria  }}</td>
                <td><a href="{{ route('admin.produto.edit', $produto->uuid) }}" class="btn btn-primary">Editar</a></td>
            </tr>
        <?php endforeach?>
    </tbody>
</table>

@endsection
