@extends('app')
@section('title', 'Tipos de usuário')
@section('menuAtivo', 'tipUsuarios')

@section('content')
    <h1>Tipos de Usuários</h1>

    <div class="d-flex justify-content-start">
        <a class="botao-default" href="{{ route('user_type.create') }}"><i class='bx bx-add-to-queue'></i> Adicionar</a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr class="header-table-default">
                <th class="header-table-col-default" scope="col">ID</th>
                <th class="header-table-col-default" scope="col">Descrição</th>
                <th class=""></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dados as $val)
                <tr>
                    <th scope="row">{{ $val->id }}</th>
                    <th scope="row">{{ $val->description }}</th>
                    <th scope="row">
                        <form action="{{ route('user_type.destroy') }}" method="POST">
                            <div class="btn-group" role="group" aria-label="Botões">
                                <a class="botao-default" href="{{ route('user_type.edit', $val->id) }}"><i
                                        class='bx bx-show-alt'></i></a>
                                @method('POST')
                                @csrf
                                <input type="number" name="id" value="{{$val->id}}" hidden>
                                <button class="botao-risco-default" type="submit"
                                    onclick="return confirm('Tem certeza que deseja apagar?')">
                                    <i class='bx bx-trash'></i>
                                </button>
                        </form>
                        </div>
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
