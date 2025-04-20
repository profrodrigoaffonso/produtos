@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">categorias</h1>
</div>
<a href="{{ route('admin.categoria.create') }}" class="btn btn-primary">Novo</a>
<table class="table table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($categorias as $categoria): ?>
            <tr>
                <td>{{ $categoria->id }}</td>
                <td>{{ $categoria->nome  }}</td>
                <td><a href="{{ route('admin.categoria.edit', $categoria->uuid) }}" class="btn btn-primary">Editar</a></td>
            </tr>
        <?php endforeach?>
    </tbody>
</table>

@endsection
