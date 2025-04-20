@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Produtos</h1>
</div>
<form method="post" action="{{ route('admin.produto.update') }}" autocomplete="off">
    @csrf
    @method('PUT')
    <div class="row">
        @component('components.forms.hidden', [
            'id'        => 'uuid',
            'name'      => 'uuid',
            'value'     => $produto->uuid
        ])
        @endcomponent
        @component('components.forms.select', [
            'id'        => 'categoria_id',
            'name'      => 'categoria_id',
            'label'     => 'Categoria',
            'values'    => $categoriasCombo,
            'selected'  => $produto->categoria_id
        ])
        @endcomponent
        @component('components.forms.input', [
            'id'        => 'nome',
            'name'      => 'nome',
            'label'     => 'Nome',
            'type'      => 'text',
            'value'     => $produto->nome,
            'maxlength' => 50
        ])
        @endcomponent
        @component('components.forms.input', [
            'id'        => 'valor',
            'name'      => 'valor',
            'label'     => 'Valor',
            'type'      => 'text',
            'value'     => number_format($produto->valor, 2, ',', '.') ,
            'maxlength' => 50
        ])
        @endcomponent

    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
</form>
<script src="/js/produtos.js"></script>
@endsection
