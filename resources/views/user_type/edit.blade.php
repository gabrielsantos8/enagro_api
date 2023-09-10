@extends('app')
@section('title', 'Editar Tipos de Usuários')
@section('menuAtivo', 'tipUsuarios')
@section('error', isset($error) ? $error : '')
@section('content')

    <h1>Tipo Usuários - Manutenção</h1>


    <form action="{{ route('user_type.update') }}" method="POST">
        @csrf
        @method('POST')
        <input type="number" value="{{ $usr_type->id }}" hidden name="id">
        <div class="mb-3">
            <label for="description" class="form-label"><b>Descrição</b></label>
            <input type="text" required name="description" id="description" value={{ $usr_type->description }}
                class="form-control">
        </div>
        <button class="botao-default w-100" type="submit">Salvar</button>
    </form>

@endsection
