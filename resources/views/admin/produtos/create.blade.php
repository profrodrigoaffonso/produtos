@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Produtos</h1>
</div>
<form method="post" action="{{ route('admin.produto.store') }}" autocomplete="off">
    @csrf
    <div class="row">
        @component('components.forms.select', [
            'id'        => 'categoria_id',
            'name'      => 'categoria_id',
            'label'     => 'Categoria',
            'values'    => $categoriasCombo
        ])
        @endcomponent
        @component('components.forms.input', [
            'id'        => 'nome',
            'name'      => 'nome',
            'label'     => 'Nome',
            'type'      => 'text',
            'value'     => old('nome'),
            'maxlength' => 50
        ])
        @endcomponent
        @component('components.forms.input', [
            'id'        => 'valor',
            'name'      => 'valor',
            'label'     => 'Valor',
            'type'      => 'text',
            'value'     => old('nome'),
            'maxlength' => 50
        ])
        @endcomponent

    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
</form>
<script src="/js/produtos.js"></script>
@endsection
