@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Administradores</h1>
</div>
<form method="post" action="{{ route('admin.admin.store') }}" autocomplete="off">
    @csrf
    <div class="row">
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
            'id'        => 'email',
            'name'      => 'email',
            'label'     => 'E-mail',
            'type'      => 'email',
            'value'     => old('nome'),
            'maxlength' => 100
        ])
        @endcomponent
        @component('components.forms.input', [
            'id'        => 'password',
            'name'      => 'password',
            'label'     => 'Senha',
            'type'      => 'password',
            'value'     => old('nome'),
            'maxlength' => 50
        ])
        @endcomponent

    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
</form>
@endsection
