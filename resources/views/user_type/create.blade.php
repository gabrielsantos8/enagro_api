@extends('app')
@section('title', 'Cadastro de tipos de usuário')
@section('menuAtivo', 'tipUsuarios')
@section('error', isset($error) ? $error : '')

@section('content')
    <h1>Tipo de usuário - Manutenção</h1>
    <form action="{{route('user_type.store')}}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="description" class="form-label"><b>Descrição</b></label>
            <input type="text" required name="description" id="description" class="form-control">
        </div>
        <button class="botao-default w-100" type="submit">Cadastrar</button>
    </form>

@endsection