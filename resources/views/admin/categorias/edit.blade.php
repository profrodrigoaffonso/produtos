@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Categorias</h1>
</div>
<form method="post" action="{{ route('admin.categoria.update') }}" autocomplete="off">
    @csrf
    @method('PUT')
    <div class="row">
        @component('components.forms.hidden', [
            'id'        => 'uuid',
            'name'      => 'uuid',
            'value'     => $categoria->uuid
        ])
        @endcomponent
        @component('components.forms.input', [
            'id'        => 'nome',
            'name'      => 'nome',
            'label'     => 'Nome',
            'type'      => 'text',
            'value'     => $categoria->nome,
            'maxlength' => 50
        ])
        @endcomponent

    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
</form>
@endsection
