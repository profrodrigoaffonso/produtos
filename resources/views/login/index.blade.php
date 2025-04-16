@extends('layouts.login')

@section('content')

<div class="login-box">
    <h2 class="mb-4 text-center">Login</h2>
    <form method="POST" action="{{ route('login.login') }}">
        @csrf
        @component('components.forms.input', [
            'id'        => 'email',
            'name'      => 'email',
            'label'     => 'E-mail',
            'type'      => 'email',
            'maxlength' => 100,
            'required'  => 'required'
        ])
        @endcomponent
        @component('components.forms.input', [
            'id'        => 'password',
            'name'      => 'password',
            'label'     => 'Senha',
            'type'      => 'password',
            'maxlength' => 100,
            'required'  => 'required'
        ])
        @endcomponent
    <button type="submit" class="btn btn-primary w-100">Entrar</button>
    </form>
</div>
@endsection
