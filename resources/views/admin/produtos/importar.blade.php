@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Produtos</h1>
</div>
<form method="post" action="{{ route('admin.produto.upload') }}" autocomplete="off" enctype="multipart/form-data">
    @csrf
    <div class="row">
        @component('components.forms.input', [
            'id'        => 'arquivo',
            'name'      => 'arquivo',
            'label'     => 'Arquivo',
            'type'      => 'file',
            'value'     => old('nome'),
            'maxlength' => 50
        ])
        @endcomponent

    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
</form>
<script src="/js/produtos.js"></script>
@endsection
